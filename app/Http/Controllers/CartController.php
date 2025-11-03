<?php

namespace App\Http\Controllers;

use App\Models\Shop\Cart;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the user's cart
     */
    public function index(): View
    {
        $cartItems = [];
        $cartTotal = 0;
        $cartCount = 0;
        $appliedCoupon = null;
        $couponDiscount = 0;

        if (Auth::check()) {
            $cartItems = Auth::user()->carts()
                ->with(['product.brand', 'product.categories'])
                ->latest()
                ->get();

            $cartTotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $cartCount = $cartItems->sum('quantity');

            // Check for applied coupon in session
            if (session('applied_coupon_code')) {
                $appliedCoupon = \App\Models\Shop\Coupon::where('code', session('applied_coupon_code'))
                    ->valid()
                    ->first();

                if ($appliedCoupon) {
                    $couponDiscount = $appliedCoupon->calculateDiscount($cartTotal);
                } else {
                    // Remove invalid coupon from session
                    session()->forget(['applied_coupon_code', 'coupon_discount']);
                }
            }
        }

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartCount', 'appliedCoupon', 'couponDiscount'));
    }

    /**
     * Add a product to the cart
     */
    public function store(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:shop_products,id',
            'quantity' => 'sometimes|integer|min:1|max:100',
            'color' => 'sometimes|string|max:255',
            'color_code' => 'sometimes|string|max:7',
            'size' => 'sometimes|string|max:50'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $color = $request->input('color', '');
        $colorCode = $request->input('color_code', '');
        $size = $request->input('size', '');
        $user = Auth::user();

        $product = Product::findOrFail($productId);

        // Validate that color and size are provided if product has them
        $productColors = $product->colors ?? [];
        $productSizes = $product->sizes ?? [];

        if (!empty($productColors) && empty($color)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn màu sắc cho sản phẩm này.'
            ], 422);
        }

        if (!empty($productSizes) && empty($size)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn kích thước cho sản phẩm này.'
            ], 422);
        }        // Check if product already exists in cart with same color/size combination
        $cartItem = Cart::where('user_id', $user->id)
                       ->where('shop_product_id', $productId)
                       ->where('color', $color)
                       ->where('size', $size)
                       ->first();        if ($cartItem) {
            // Update quantity if exact same item (including color/size) already exists
            $cartItem->quantity += $quantity;
            $cartItem->save();
            $message = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng';
        } else {
            // Add new item to cart with color and size
            Cart::create([
                'user_id' => $user->id,
                'shop_product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->sale_price ?? $product->price,
                'color' => $color,
                'color_code' => $colorCode,
                'size' => $size
            ]);
            $message = 'Đã thêm sản phẩm vào giỏ hàng thành công';
        }

        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->carts()->get()->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền truy cập'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:shop_products,id',
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)
                       ->where('shop_product_id', $productId)
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->carts()->get()->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $itemTotal = $cartItem->quantity * $cartItem->price;

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật giỏ hàng thành công',
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'item_total' => number_format($itemTotal, 2)
        ]);
    }

    /**
     * Remove a product from the cart
     */
    public function destroy(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền truy cập'
            ], 401);
        }

        $request->validate([
            'cart_item_id' => 'required|exists:shop_carts,id'
        ]);

        $cartItemId = $request->input('cart_item_id');
        $user = Auth::user();

        $cartItem = Cart::where('id', $cartItemId)
                       ->where('user_id', $user->id)
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        }

        $cartItem->delete();
        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->carts()->get()->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng thành công',
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    /**
     * Clear all items from cart
     */
    public function clear(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền truy cập'
            ], 401);
        }

        Auth::user()->carts()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng thành công',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }

    /**
     * Get cart count for current user
     */
    public function count(): JsonResponse
    {
        $count = Auth::check() ? Auth::user()->carts()->sum('quantity') : 0;
        $total = 0;

        if (Auth::check()) {
            $total = Auth::user()->carts()->get()->sum(function($item) {
                return $item->quantity * $item->price;
            });
        }

        return response()->json([
            'success' => true,
            'count' => $count,
            'total' => number_format($total, 2)
        ]);
    }

    /**
     * Get cart sidebar content for AJAX updates
     */
    public function getSidebarContent(): JsonResponse
    {
        $cartItems = [];
        $cartTotal = 0;
        $cartCount = 0;

        if (Auth::check()) {
            $cartItems = Auth::user()->carts()
                ->with(['product.media'])
                ->latest()
                ->get();

            $cartTotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $cartCount = $cartItems->sum('quantity');
        }

        $html = view('partials.frontend.cart-sidebar-content', compact('cartItems', 'cartTotal', 'cartCount'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $cartCount,
            'total' => $cartTotal
        ]);
    }

    /**
     * Increment cart item quantity
     */
    public function increment(Request $request): JsonResponse
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền truy cập'
                ], 401);
            }

            $request->validate([
                'cart_item_id' => 'required|exists:shop_carts,id'
            ]);

        $cartItemId = $request->input('cart_item_id');
        $user = Auth::user();

        $cartItem = Cart::where('id', $cartItemId)
                       ->where('user_id', $user->id)
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        }

        if ($cartItem->quantity >= 100) {
            return response()->json([
                'success' => false,
                'message' => 'Đã đạt giới hạn số lượng tối đa'
            ], 422);
        }

        $cartItem->quantity += 1;
        $cartItem->save();

        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->carts()->get()->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $itemTotal = $cartItem->quantity * $cartItem->price;

        return response()->json([
            'success' => true,
            'message' => 'Đã tăng số lượng',
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
            'item_total' => $itemTotal,
            'item_quantity' => $cartItem->quantity
        ]);

        } catch (\Exception $e) {
            \Log::error('Cart increment error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'
            ], 500);
        }
    }

    /**
     * Decrement cart item quantity
     */
    public function decrement(Request $request): JsonResponse
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền truy cập'
                ], 401);
            }

            $request->validate([
                'cart_item_id' => 'required|exists:shop_carts,id'
            ]);

        $cartItemId = $request->input('cart_item_id');
        $user = Auth::user();

        $cartItem = Cart::where('id', $cartItemId)
                       ->where('user_id', $user->id)
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        }

        if ($cartItem->quantity <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể giảm số lượng xuống dưới 1'
            ], 422);
        }

        $cartItem->quantity -= 1;
        $cartItem->save();

        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->carts()->get()->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $itemTotal = $cartItem->quantity * $cartItem->price;

        return response()->json([
            'success' => true,
            'message' => 'Đã giảm số lượng',
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
            'item_total' => $itemTotal,
            'item_quantity' => $cartItem->quantity
        ]);

        } catch (\Exception $e) {
            \Log::error('Cart decrement error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'
            ], 500);
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $couponCode = strtoupper(trim($request->input('coupon_code')));

        // Find valid coupon
        $coupon = \App\Models\Shop\Coupon::where('code', $couponCode)->valid()->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
            ]);
        }

        // Get cart items to calculate subtotal
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống.'
            ]);
        }

        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Check minimum amount
        if ($coupon->minimum_amount && $subtotal < $coupon->minimum_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($coupon->minimum_amount, 0, ',', '.') . '₫ để áp dụng mã này.'
            ]);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($subtotal);

        // Store coupon in session
        session([
            'applied_coupon_code' => $coupon->code,
            'coupon_discount' => $discount
        ]);

        // Calculate new totals
        $subtotalAfterDiscount = $subtotal - $discount;
        $total = $subtotalAfterDiscount; // No shipping/tax in cart

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'coupon_code' => $coupon->code,
            'coupon_name' => $coupon->name,
            'discount' => $discount,
            'discount_formatted' => number_format($discount, 0, ',', '.') . '₫',
            'subtotal' => $subtotal,
            'subtotal_formatted' => number_format($subtotal, 0, ',', '.') . '₫',
            'total' => $total,
            'total_formatted' => number_format($total, 0, ',', '.') . '₫'
        ]);
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon(Request $request)
    {
        // Remove coupon from session
        session()->forget(['applied_coupon_code', 'coupon_discount']);

        // Get cart items to recalculate totals
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa mã giảm giá.',
            'subtotal' => $subtotal,
            'subtotal_formatted' => number_format($subtotal, 0, ',', '.') . '₫',
            'total' => $subtotal,
            'total_formatted' => number_format($subtotal, 0, ',', '.') . '₫'
        ]);
    }
}
