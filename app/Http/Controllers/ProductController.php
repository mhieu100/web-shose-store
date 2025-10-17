<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with(['categories', 'media', 'comments.customer'])
            ->withCount('comments')
            ->findOrFail($id);

        // Related products from same category
        $categoryIds = $product->categories->pluck('id');
        $relatedProducts = Product::whereHas('categories', function($query) use ($categoryIds) {
                $query->whereIn('shop_categories.id', $categoryIds);
            })
            ->where('id', '!=', $product->id)
            ->where('is_visible', true)
            ->take(4)
            ->get();        // Recently viewed products (you can implement this later with sessions)
        $recentlyViewed = Product::where('is_visible', true)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();        return view('product.show', compact('product', 'relatedProducts', 'recentlyViewed'));
    }
}
