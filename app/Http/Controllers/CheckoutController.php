<?php

namespace App\Http\Controllers;

use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Product;
use App\Models\Shop\Coupon;
use App\Models\Address;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CheckoutController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Display checkout page with cart items
     */
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to proceed with checkout.');
        }

        $user = Auth::user();

        // Get cart items for the user
        $cartItems = Cart::with(['product.media'])
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add some items before checkout.');
        }

        // Calculate totals using cart price (already stored in cart)
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Handle coupon from session
        $appliedCoupon = null;
        $couponDiscount = 0;
        if (session('applied_coupon_code')) {
            $appliedCoupon = Coupon::where('code', session('applied_coupon_code'))->valid()->first();
            if ($appliedCoupon) {
                $couponDiscount = $appliedCoupon->calculateDiscount($subtotal);
            } else {
                // Remove invalid coupon from session
                session()->forget('applied_coupon_code');
            }
        }

        $subtotalAfterDiscount = $subtotal - $couponDiscount;
        $shipping = $this->calculateShipping($subtotalAfterDiscount);
        $tax = $this->calculateTax($subtotalAfterDiscount);
        $total = $subtotalAfterDiscount + $shipping + $tax;

        // Get user's wallet balance
        $walletBalance = $this->walletService->getBalance($user);

        // For now, we'll handle addresses directly in the form
        // In future, you can implement proper address management
        $addresses = collect(); // Empty collection for now

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'appliedCoupon',
            'couponDiscount',
            'subtotalAfterDiscount',
            'addresses',
            'user',
            'walletBalance'
        ));
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        Log::info('Checkout process started', ['user_id' => Auth::id()]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to complete your order.');
        }

        $user = Auth::user();
        Log::info('User authenticated', ['user' => $user->id, 'email' => $user->email]);

        // Validate request
        Log::info('Starting validation', ['request_data' => $request->all()]);

        $validated = $request->validate([
            'payment_method' => 'required|string|in:cod,bank_transfer,paypal,wallet',
            'notes' => 'nullable|string|max:500',
            // Address fields
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        Log::info('Validation passed', ['validated_data' => $validated]);

        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->get();

            Log::info('Cart items loaded', ['count' => $cartItems->count(), 'items' => $cartItems->toArray()]);

            if ($cartItems->isEmpty()) {
                Log::warning('Cart is empty for user', ['user_id' => $user->id]);
                return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }

            // Check product availability
            foreach ($cartItems as $item) {
                if ($item->product->qty < $item->quantity) {
                    return redirect()->back()->with('error', "Sorry, {$item->product->name} only has {$item->product->qty} items in stock.");
                }
            }

            // Create address data from form
            $addressData = [
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'phone' => $validated['phone'],
            ];

            // Use same address for both billing and shipping
            $billingAddress = $addressData;
            $shippingAddress = $addressData;

            // Calculate totals using cart price (consistent with checkout display)
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Handle coupon from session
            $appliedCoupon = null;
            $couponDiscount = 0;
            $couponCode = null;

            if (session('applied_coupon_code')) {
                $appliedCoupon = Coupon::where('code', session('applied_coupon_code'))->valid()->first();
                if ($appliedCoupon) {
                    $couponCode = $appliedCoupon->code;
                    $couponDiscount = $appliedCoupon->calculateDiscount($subtotal);
                }
            }

            $subtotalAfterDiscount = $subtotal - $couponDiscount;
            $shipping = $this->calculateShipping($subtotalAfterDiscount);
            $tax = $this->calculateTax($subtotalAfterDiscount);
            $total = $subtotalAfterDiscount + $shipping + $tax;

            // Generate order number once
            $orderNumber = $this->generateOrderNumber();

            // Create order with all required fields
            $orderData = [
                'number' => $orderNumber,
                'order_number' => $orderNumber,
                'total_price' => $total,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'discount_amount' => $couponDiscount,
                'total_amount' => $total,
                'status' => 'new',
                'currency' => 'USD',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'shipping_price' => $shipping,
                'shipping_method' => 'standard',
                'notes' => $validated['notes'] ?? null,
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress,
                'coupon_code' => $couponCode,
                'coupon_discount' => $couponDiscount,
            ];

            // Add user_id if column exists
            if (Schema::hasColumn('shop_orders', 'user_id')) {
                $orderData['user_id'] = $user->id;
            }

            Log::info('Creating order', ['order_data' => $orderData]);

            $order = Order::create($orderData);

            Log::info('Order created successfully', ['order_id' => $order->id, 'order_number' => $order->order_number]);

            // Create order items and update product quantities
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'shop_order_id' => $order->id,
                    'shop_product_id' => $item->product->id,
                    'qty' => $item->quantity,
                    'unit_price' => $item->price, // Use price from cart (already calculated)
                    'size' => $item->size,
                    'color' => $item->color,
                ]);

                // Update product quantity
                $item->product->decrement('qty', $item->quantity);
            }

            // Update coupon usage if applied
            if ($appliedCoupon) {
                $appliedCoupon->incrementUsage();
            }

            // Process wallet payment BEFORE committing and clearing cart
            if ($validated['payment_method'] === 'wallet') {
                Log::info('Processing wallet payment', ['order_id' => $order->id, 'total' => $total]);

                $walletBalance = $this->walletService->getBalance($user);
                Log::info('Wallet balance checked', ['balance' => $walletBalance, 'required' => $total]);

                if ($walletBalance < $total) {
                    DB::rollBack();
                    Log::warning('Insufficient wallet balance', ['balance' => $walletBalance, 'required' => $total]);
                    return redirect()->back()
                        ->with('error', 'Số dư ví không đủ. Vui lòng chọn phương thức thanh toán khác.')
                        ->withInput();
                }

                // Deduct from wallet
                $wallet = $this->walletService->getOrCreateWallet($user);
                Log::info('Deducting from wallet', ['amount' => $total]);

                $wallet->deductFunds(
                    $total,
                    'payment',
                    "Thanh toán đơn hàng #{$order->order_number}",
                    $order->id
                );

                Log::info('Wallet deducted successfully');

                // Update order payment status
                $order->update([
                    'payment_status' => 'completed',
                    'paid_at' => now(),
                ]);

                Log::info('Order payment status updated');

                // Create payment record
                $order->payments()->create([
                    'amount' => $total,
                    'provider' => 'wallet',
                    'method' => 'wallet',
                    'currency' => 'VND',
                    'status' => 'completed',
                    'reference' => 'WALLET-' . $order->order_number,
                    'metadata' => json_encode(['wallet_payment' => true]),
                ]);

                Log::info('Payment record created successfully');
            }

            // Only clear cart and coupon session for non-PayPal payments
            if ($validated['payment_method'] !== 'paypal') {
                Cart::where('user_id', $user->id)->delete();
                session()->forget('applied_coupon_code');
            }

            DB::commit();

            // Redirect based on payment method
            switch ($validated['payment_method']) {
                case 'wallet':
                    return redirect()->route('order.confirmation', $order->id)
                        ->with('success', 'Đơn hàng đã được thanh toán thành công bằng ví!');

                case 'paypal':
                    // DON'T clear cart here - will be cleared after successful PayPal payment
                    // Cart::where('user_id', $user->id)->delete(); // Remove this line
                    Log::info('Redirecting to PayPal payment', ['order_id' => $order->id]);
                    return redirect()->route('paypal.payment', $order->id);

                case 'bank_transfer':
                    return redirect()->route('order.confirmation', $order->id)
                        ->with('success', 'Order created successfully! Please complete the bank transfer to process your order.');

                case 'cod':
                default:
                    return redirect()->route('order.confirmation', $order->id)
                        ->with('success', 'Order created successfully! You will pay on delivery.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout process failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id ?? null,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->with('error', 'Something went wrong during checkout. Please try again.')
                ->withInput();
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:255'
        ]);

        $couponCode = strtoupper(trim($request->coupon_code));

        // Find valid coupon
        $coupon = Coupon::where('code', $couponCode)->valid()->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
            ]);
        }

        // Get cart total to check minimum amount
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Check minimum amount
        if ($coupon->minimum_amount && $subtotal < $coupon->minimum_amount) {
            return response()->json([
                'success' => false,
                'message' => "Đơn hàng tối thiểu phải từ $" . number_format($coupon->minimum_amount, 2) . " để sử dụng mã này."
            ]);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không áp dụng được cho đơn hàng này.'
            ]);
        }

        // Store coupon in session
        session(['applied_coupon_code' => $couponCode]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'coupon' => [
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type->value,
                'value' => $coupon->value,
                'discount_amount' => $discount
            ]
        ]);
    }

    /**
     * Remove coupon code
     */
    public function removeCoupon()
    {
        session()->forget('applied_coupon_code');

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa mã giảm giá.'
        ]);
    }

    /**
     * Show order confirmation
     */
    public function confirmation($orderId): View
    {
        $order = Order::with(['items.product', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.confirmation', compact('order'));
    }

    /**
     * Calculate shipping cost
     */
    private function calculateShipping(float $subtotal): float
    {
        // Free shipping over $100
        if ($subtotal >= 100) {
            return 0.00;
        }

        // Standard shipping
        return 10.00;
    }

    /**
     * Calculate tax
     */
    private function calculateTax(float $subtotal): float
    {
        // 10% tax rate
        return $subtotal * 0.10;
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
