<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Brand;
use App\Models\Shop\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with(['brand', 'categories', 'media'])
            ->where('is_visible', true);

        // Filter by brand
        if ($request->has('brand')) {
            $brandSlug = $request->get('brand');
            $query->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug);
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        // Search by keyword
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        switch ($sort) {
            case 'price_low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popularity':
                $query->withCount('orderItems')
                      ->orderBy('order_items_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $products = $query->paginate(12)->withQueryString();

        // Get filter data for sidebar
        $brands = Brand::where('is_visible', true)
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_visible', true)
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get current filter info
        $currentBrand = null;
        if ($request->has('brand')) {
            $currentBrand = Brand::where('slug', $request->get('brand'))->first();
        }

        $currentCategory = null;
        if ($request->has('category')) {
            $currentCategory = Category::where('slug', $request->get('category'))->first();
        }

        return view('shop.index', compact(
            'products',
            'brands',
            'categories',
            'currentBrand',
            'currentCategory'
        ));
    }
}
