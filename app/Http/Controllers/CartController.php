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

        if (Auth::check()) {
            $cartItems = Auth::user()->carts()
                ->with(['product.brand', 'product.categories'])
                ->latest()
                ->get();

            $cartTotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $cartCount = $cartItems->sum('quantity');
        }

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Add a product to the cart
     */
    public function store(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to cart',
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
        $cartTotal = $user->cart_total;

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal
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
                'message' => 'Unauthorized'
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
                'message' => 'Product not found in cart'
            ], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->cart_total;
        $itemTotal = $cartItem->quantity * $cartItem->price;

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
            'item_total' => $itemTotal
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
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:shop_products,id'
        ]);

        $productId = $request->input('product_id');
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)
                       ->where('shop_product_id', $productId)
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        $cartItem->delete();
        $cartCount = $user->carts()->sum('quantity');
        $cartTotal = $user->cart_total;

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully',
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal
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
                'message' => 'Unauthorized'
            ], 401);
        }

        Auth::user()->carts()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
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
        $total = Auth::check() ? Auth::user()->cart_total : 0;

        return response()->json([
            'success' => true,
            'count' => $count,
            'total' => $total
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
}
