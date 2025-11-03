<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index(): View
    {
        $wishlistItems = collect([]);
        
        if (Auth::check()) {
            $wishlistItems = Auth::user()->wishlists()
                ->with(['product.brand', 'product.categories'])
                ->latest()
                ->get();
        }
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add a product to the wishlist
     */
    public function store(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:shop_products,id'
        ]);

        $productId = $request->input('product_id');
        $user = Auth::user();

        // Check if product already exists in wishlist
        if ($user->hasInWishlist($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã có trong danh sách yêu thích của bạn'
            ], 400);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $user->id,
            'shop_product_id' => $productId
        ]);

        $wishlistCount = $user->wishlists()->count();

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào danh sách yêu thích thành công',
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Remove a product from the wishlist
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
            'product_id' => 'required|exists:shop_products,id'
        ]);

        $productId = $request->input('product_id');
        $user = Auth::user();

        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('shop_product_id', $productId)
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong danh sách yêu thích'
            ], 404);
        }

        $wishlistItem->delete();
        $wishlistCount = $user->wishlists()->count();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích thành công',
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Toggle product in wishlist (add if not exists, remove if exists)
     */
    public function toggle(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để quản lý danh sách yêu thích',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:shop_products,id'
        ]);

        $productId = $request->input('product_id');
        $user = Auth::user();

        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('shop_product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $inWishlist = false;
            $message = 'Đã xóa sản phẩm khỏi danh sách yêu thích';
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'shop_product_id' => $productId
            ]);
            $inWishlist = true;
            $message = 'Đã thêm sản phẩm vào danh sách yêu thích';
        }

        $wishlistCount = $user->wishlists()->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist,
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Clear all items from wishlist
     */
    public function clear(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền truy cập'
            ], 401);
        }

        Auth::user()->wishlists()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ danh sách yêu thích thành công',
            'wishlist_count' => 0
        ]);
    }

    /**
     * Get wishlist count for current user
     */
    public function count(): JsonResponse
    {
        $count = Auth::check() ? Auth::user()->wishlists()->count() : 0;

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
