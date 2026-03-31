<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Category;
use App\Models\Shop\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index()
    {
        // Get banners
        $banners = \App\Http\Controllers\BannerController::getHomepageBanners();

        // Get latest products
        $latestProducts = \Illuminate\Support\Facades\Cache::remember('home_latest_products', 3600, function () {
            return Product::where('is_visible', true)
                ->with(['brand', 'categories', 'media'])
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        });

        // Get popular brands
        $brands = \Illuminate\Support\Facades\Cache::remember('home_brands', 3600, function () {
            return Brand::whereHas('products', function($query) {
                $query->where('is_visible', true);
            })
            ->withCount(['products' => function($query) {
                $query->where('is_visible', true);
            }])
            ->orderBy('products_count', 'desc')
            ->limit(4)
            ->get();
        });

        // Get categories for tabs
        $categories = \Illuminate\Support\Facades\Cache::remember('home_categories', 3600, function () {
            return Category::where('is_visible', true)
                ->whereNull('parent_id')
                ->withCount(['products' => function($query) {
                    $query->where('is_visible', true);
                }])
                ->having('products_count', '>', 0)
                ->orderBy('products_count', 'desc')
                ->limit(3)
                ->get();
        });

        // Get products for each category
        $categoryProducts = \Illuminate\Support\Facades\Cache::remember('home_category_products', 3600, function () use ($categories) {
            $products = [];
            foreach ($categories as $category) {
                $products[$category->id] = Product::where('is_visible', true)
                    ->whereHas('categories', function($query) use ($category) {
                        $query->where('shop_categories.id', $category->id);
                    })
                    ->with(['brand', 'categories', 'media'])
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
            }
            return $products;
        });

        // Get featured products
        $featuredProducts = \Illuminate\Support\Facades\Cache::remember('home_featured_products', 3600, function () {
            return Product::where('is_visible', true)
                ->where('featured', true)
                ->with(['brand', 'categories', 'media'])
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        });

        return view('home', compact('banners', 'latestProducts', 'brands', 'categories', 'categoryProducts', 'featuredProducts'));
    }
}
