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
        $wishlistItems = [];
        
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
                'message' => 'Please login to add items to wishlist',
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
                'message' => 'Product is already in your wishlist'
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
            'message' => 'Product added to wishlist successfully',
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
                'message' => 'Unauthorized'
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
                'message' => 'Product not found in wishlist'
            ], 404);
        }

        $wishlistItem->delete();
        $wishlistCount = $user->wishlists()->count();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist successfully',
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
                'message' => 'Please login to manage wishlist',
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
            $message = 'Product removed from wishlist';
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'shop_product_id' => $productId
            ]);
            $inWishlist = true;
            $message = 'Product added to wishlist';
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
                'message' => 'Unauthorized'
            ], 401);
        }

        Auth::user()->wishlists()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared successfully',
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
