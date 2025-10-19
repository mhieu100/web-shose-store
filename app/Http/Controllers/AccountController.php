<?php

namespace App\Http\Controllers;

use App\Models\Shop\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->middleware('auth');
        $this->walletService = $walletService;
    }

    /**
     * Display the user account dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Get user's recent orders
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get wallet info
        $walletBalance = $this->walletService->getBalance($user);
        $recentTransactions = $this->walletService->getTransactions($user, 5);

        // Get user statistics
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)
                ->where('status', 'new')
                ->count(),
            'completed_orders' => Order::where('user_id', $user->id)
                ->where('status', 'delivered')
                ->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->where('payment_status', 'completed')
                ->sum('total_price'),
            'wallet_balance' => $walletBalance,
        ];

        return view('account.index', compact('user', 'orders', 'stats', 'recentTransactions'));
    }

    /**
     * Update user profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('account')
            ->with('success', 'Thông tin tài khoản đã được cập nhật thành công!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account')
            ->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

    /**
     * Show order details
     */
    public function showOrder($orderId)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('id', $orderId)
            ->with(['items.product', 'payments'])
            ->firstOrFail();

        return view('account.order-details', compact('order'));
    }

    /**
     * Get orders data for AJAX requests
     */
    public function getOrders(Request $request)
    {
        $user = Auth::user();

        $query = Order::where('user_id', $user->id)
            ->with(['items.product']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by order number
        if ($request->has('search') && $request->search !== '') {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('account.partials.orders-table', compact('orders'))->render(),
                'pagination' => $orders->links()->render()
            ]);
        }

        return $orders;
    }

    /**
     * Cancel an order
     */
    public function cancelOrder($orderId)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('id', $orderId)
            ->with('payment')
            ->firstOrFail();

        if (!$order->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Đơn hàng này không thể hủy được.');
        }

        $order->update([
            'status' => OrderStatus::Cancelled,
            'cancelled_at' => now(),
        ]);

        // Process refund if order was paid
        try {
            $refunded = $this->walletService->processRefund($order);

            if ($refunded) {
                $message = 'Đơn hàng đã được hủy và hoàn tiền thành công.';
            } else {
                $message = 'Đơn hàng đã được hủy thành công.';
            }
        } catch (\Exception $e) {
            // Even if refund fails, order is still cancelled
            \Log::error('Refund failed during order cancellation', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            $message = 'Đơn hàng đã được hủy. Hoàn tiền sẽ được xử lý trong vòng 24 giờ.';
        }

        return redirect()->back()
            ->with('success', $message);
    }    /**
     * Confirm order delivery - user confirms they received the order
     */
    public function confirmDelivery($orderId)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('id', $orderId)
            ->firstOrFail();

        // Check if order can be confirmed as delivered
        if (!$order->canBeConfirmedAsDelivered()) {
            return redirect()->back()
                ->with('error', 'Đơn hàng này không thể xác nhận đã nhận được.');
        }

        // Update order status to delivered and payment status to completed
        $order->update([
            'status' => OrderStatus::Delivered,
            'payment_status' => 'completed',
            'delivered_at' => now(),
        ]);

        // Process affiliate commission if applicable
        if ($order->hasAffiliate()) {
            $this->processAffiliateCommission($order);
        }

        return redirect()->back()
            ->with('success', 'Cảm ơn bạn đã xác nhận nhận hàng! Đơn hàng đã được hoàn thành.');
    }

    /**
     * Process affiliate commission when order is confirmed as delivered
     */
    private function processAffiliateCommission(Order $order)
    {
        if (!$order->hasAffiliate() || !$order->affiliateUser) {
            return;
        }

        // Check if commission already exists
        $existingCommission = \App\Models\Commission::where('order_id', $order->id)->first();
        if ($existingCommission) {
            return; // Commission already processed
        }

        // Calculate commission amount
        $commissionAmount = $order->calculateAffiliateCommission();
        if ($commissionAmount <= 0) {
            return;
        }

        // Create commission record
        \App\Models\Commission::create([
            'user_id' => $order->affiliate_user_id,
            'order_id' => $order->id,
            'commission_amount' => $commissionAmount,
            'commission_rate' => $order->affiliateUser->commission_rate ?? 0,
            'status' => 'pending',
            'earned_at' => now(),
        ]);
    }

    /**
     * Show wallet deposit page
     */
    public function showDepositForm()
    {
        $user = Auth::user();
        $walletBalance = $this->walletService->getBalance($user);
        $recentTransactions = $this->walletService->getTransactions($user, 10);

        return view('account.wallet-deposit', compact('walletBalance', 'recentTransactions'));
    }

    /**
     * Process wallet deposit request
     */
    public function processDeposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000|max:50000000', // Min 10k, Max 50M VND
            'payment_method' => 'required|in:paypal,bank_transfer',
        ]);

        $user = Auth::user();
        $amount = $validated['amount'];

        try {
            // Create a temporary deposit record
            $deposit = \App\Models\Shop\WalletDeposit::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            // Redirect based on payment method
            if ($validated['payment_method'] === 'paypal') {
                return redirect()->route('wallet.deposit.paypal', $deposit->id);
            } else {
                return redirect()->route('wallet.deposit.bank-transfer', $deposit->id)
                    ->with('success', 'Vui lòng chuyển khoản theo thông tin bên dưới.');
            }

        } catch (\Exception $e) {
            \Log::error('Deposit request failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Không thể tạo yêu cầu nạp tiền. Vui lòng thử lại.')
                ->withInput();
        }
    }

    /**
     * Show bank transfer instructions for deposit
     */
    public function showBankTransferInstructions($depositId)
    {
        $user = Auth::user();
        $deposit = \App\Models\Shop\WalletDeposit::where('id', $depositId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('account.wallet-bank-transfer', compact('deposit'));
    }

    /**
     * Confirm manual bank transfer deposit (admin will verify)
     */
    public function confirmBankTransfer(Request $request, $depositId)
    {
        $user = Auth::user();
        $deposit = \App\Models\Shop\WalletDeposit::where('id', $depositId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'transfer_proof' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Store transfer proof if uploaded
        $proofPath = null;
        if ($request->hasFile('transfer_proof')) {
            $proofPath = $request->file('transfer_proof')->store('deposits', 'public');
        }

        $deposit->update([
            'transaction_reference' => $validated['transaction_reference'],
            'transfer_proof' => $proofPath,
            'status' => 'pending_verification',
            'submitted_at' => now(),
        ]);

        return redirect()->route('account.index')
            ->with('success', 'Đã gửi thông tin chuyển khoản. Chúng tôi sẽ xác nhận trong vòng 24 giờ.');
    }
}
