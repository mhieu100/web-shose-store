<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Brand;
use App\Models\Shop\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['brand', 'categories', 'media'])
            ->where('is_visible', true);

        // Filter by brand
        if ($request->has('brand') && !empty($request->get('brand'))) {
            $brandSlug = $request->get('brand');
            $query->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug);
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->get('category'))) {
            $categorySlug = $request->get('category');
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter by price range
        $minPrice = $request->get('min_price');
        if (!empty($minPrice) && is_numeric($minPrice)) {
            $minPrice = (float) $minPrice;
            if ($minPrice >= 0) {
                $query->where('price', '>=', $minPrice);
            }
        }
        
        $maxPrice = $request->get('max_price');
        if (!empty($maxPrice) && is_numeric($maxPrice)) {
            $maxPrice = (float) $maxPrice;
            if ($maxPrice > 0) {
                $query->where('price', '<=', $maxPrice);
            }
        }

        // Filter by sizes
        if ($request->has('sizes') && !empty($request->get('sizes'))) {
            $sizes = explode(',', $request->get('sizes'));
            $sizes = array_filter(array_map('trim', $sizes));
            if (!empty($sizes)) {
                $query->where(function ($q) use ($sizes) {
                    foreach ($sizes as $size) {
                        $q->orWhereJsonContains('sizes', $size)
                          ->orWhereJsonContains('sizes', (int) $size); // Handle both string and int
                    }
                });
            }
        }

        // Filter by colors
        if ($request->has('colors') && !empty($request->get('colors'))) {
            $colors = explode(',', $request->get('colors'));
            $colors = array_filter(array_map('trim', $colors));
            if (!empty($colors)) {
                $query->where(function ($q) use ($colors) {
                    foreach ($colors as $color) {
                        $q->orWhereJsonContains('colors', $color)
                          ->orWhereJsonContains('colors', ['name' => $color])
                          ->orWhereJsonContains('colors', ['color' => $color]);
                    }
                });
            }
        }

        // Search by keyword
        if ($request->has('search') && !empty(trim($request->get('search')))) {
            $search = trim($request->get('search'));
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
        $perPage = $request->get('per_page', 12);
        $perPage = in_array($perPage, [12, 24, 36, 48]) ? $perPage : 12;
        $products = $query->paginate($perPage)->withQueryString();

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

        // Handle AJAX requests
        if ($request->ajax() || $request->has('ajax')) {
            return $this->handleAjaxRequest($request, $products, $currentBrand, $currentCategory);
        }

        return view('shop.index', compact(
            'products',
            'brands',
            'categories',
            'currentBrand',
            'currentCategory'
        ));
    }

    private function handleAjaxRequest($request, $products, $currentBrand, $currentCategory)
    {
        try {
            // Simple response first - test basic functionality
            $gridViewHtml = '';
            $listViewHtml = '';
            $paginationHtml = '';
            
            // Try to render grid view
            try {
                $gridViewHtml = view('shop.partials.products-grid', compact('products'))->render();
            } catch (\Exception $e) {
                // Fallback: generate simple grid HTML
                $gridViewHtml = $this->generateSimpleProductGrid($products);
            }
            
            // Try to render list view
            try {
                $listViewHtml = view('shop.partials.products-list', compact('products'))->render();
            } catch (\Exception $e) {
                // Fallback: generate simple list HTML
                $listViewHtml = $this->generateSimpleProductList($products);
            }
            
            // Try to render pagination
            try {
                if ($products->hasPages()) {
                    $paginationHtml = view('shop.partials.pagination', compact('products'))->render();
                }
            } catch (\Exception $e) {
                $paginationHtml = '<div class="text-center">Pagination Error: ' . $e->getMessage() . '</div>';
            }
            
            // Build page title
            $pageTitle = 'Cửa hàng';
            if ($currentBrand) {
                $pageTitle .= ' - ' . $currentBrand->name;
            }
            if ($currentCategory) {
                $pageTitle .= ' - ' . $currentCategory->name;
            }
            
            return response()->json([
                'success' => true,
                'products_grid_html' => $gridViewHtml,
                'products_list_html' => $listViewHtml,
                'pagination_html' => $paginationHtml,
                'page_title' => $pageTitle,
                'total_products' => $products->total(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ]);
            
        } catch (\Exception $e) {
            \Log::error('AJAX Shop Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra khi tải dữ liệu',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    private function generateSimpleProductGrid($products)
    {
        $html = '';
        foreach ($products as $product) {
            $imageUrl = $product->getFirstMediaUrl('product-images') ?: asset('img/shop/placeholder.webp');
            $productUrl = route('product.show', $product->id);
            $price = number_format($product->price, 0, ',', '.');
            $oldPrice = $product->old_price ? number_format($product->old_price, 0, ',', '.') : null;
            
            // Calculate discount percentage
            $discount = '';
            if ($product->old_price && $product->old_price > $product->price) {
                $discountPercent = round((($product->old_price - $product->price) / $product->old_price) * 100);
                $discount = "<span class=\"flag-new sale\">-{$discountPercent}%</span>";
            }
            
            // Categories
            $categories = '';
            foreach ($product->categories as $index => $category) {
                $categories .= "<a href=\"" . route('shop', ['category' => $category->slug]) . "\">{$category->name}</a>";
                if ($index < count($product->categories) - 1) {
                    $categories .= '<span>/</span>';
                }
            }
            
            $html .= "
                <div class=\"col-lg-4 col-md-4 col-sm-6 col-6\">
                    <div class=\"product-item\" style=\"opacity: 1; transform: translateY(0px); transition: 0.5s;\">
                        <div class=\"inner-content\">
                            <div class=\"product-thumb\">
                                <a href=\"{$productUrl}\">
                                    <img src=\"{$imageUrl}\" width=\"270\" height=\"274\" alt=\"{$product->name}\">
                                </a>
                                {$discount}
                                <div class=\"product-action\">
                                    <button type=\"button\" class=\"btn-product-cart add-to-cart\"
                                            data-product-id=\"{$product->id}\"
                                            data-product-name=\"{$product->name}\"
                                            data-product-price=\"{$product->price}\"
                                            data-product-colors=\"" . htmlspecialchars($product->colors ? json_encode($product->colors) : '[]') . "\"
                                            data-product-sizes=\"" . htmlspecialchars($product->sizes ? json_encode($product->sizes) : '[]') . "\"
                                            title=\"Thêm vào giỏ hàng\">
                                        <i class=\"fa fa-shopping-cart\"></i>
                                    </button>
                                    <button class=\"add-to-wishlist btn-product-wishlist\" data-product-id=\"{$product->id}\" title=\"Thêm vào danh sách yêu thích\">
                                        <i class=\"fa fa-heart-o\"></i>
                                    </button>
                                    <button type=\"button\" class=\"btn-product-quick-view-open\" title=\"Xem nhanh\">
                                        <i class=\"fa fa-arrows-alt\"></i>
                                    </button>
                                </div>
                            </div>
                            <div class=\"product-info\">
                                <div class=\"category-list\">
                                    {$categories}
                                </div>
                                <h4 class=\"title\"><a href=\"{$productUrl}\">{$product->name}</a></h4>
                                <div class=\"prices\">
                                    " . ($oldPrice ? "<span class=\"price-old\">{$oldPrice} VNĐ</span><span class=\"sep\">-</span>" : "") . "
                                    <span class=\"price\">{$price} VNĐ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }
        
        if (empty($html)) {
            $html = '<div class="col-12 text-center p-5"><h4>Không tìm thấy sản phẩm nào</h4></div>';
        }
        
        return $html;
    }
    
    private function generateSimpleProductList($products)
    {
        $html = '';
        foreach ($products as $product) {
            $imageUrl = $product->getFirstMediaUrl('product-images') ?: asset('img/shop/placeholder.webp');
            $productUrl = route('product.show', $product->id);
            $price = number_format($product->price, 0, ',', '.');
            $oldPrice = $product->old_price ? number_format($product->old_price, 0, ',', '.') : null;
            $description = \Str::limit($product->description, 100);
            
            $html .= "
                <div class=\"col-12\">
                    <div class=\"product-item product-item-list\" style=\"opacity: 1; transform: translateY(0px); transition: 0.5s;\">
                        <div class=\"inner-content\">
                            <div class=\"product-thumb\">
                                <a href=\"{$productUrl}\">
                                    <img src=\"{$imageUrl}\" width=\"270\" height=\"274\" alt=\"{$product->name}\">
                                </a>
                            </div>
                            <div class=\"product-info\">
                                <h4 class=\"title\"><a href=\"{$productUrl}\">{$product->name}</a></h4>
                                <div class=\"prices\">
                                    " . ($oldPrice ? "<span class=\"price-old\">{$oldPrice} VNĐ</span><span class=\"sep\">-</span>" : "") . "
                                    <span class=\"price\">{$price} VNĐ</span>
                                </div>
                                <p>{$description}</p>
                                <div class=\"product-action\">
                                    <button type=\"button\" class=\"btn-product-cart add-to-cart\"
                                            data-product-id=\"{$product->id}\"
                                            data-product-name=\"{$product->name}\"
                                            data-product-price=\"{$product->price}\"
                                            data-product-colors=\"" . htmlspecialchars($product->colors ? json_encode($product->colors) : '[]') . "\"
                                            data-product-sizes=\"" . htmlspecialchars($product->sizes ? json_encode($product->sizes) : '[]') . "\"
                                            title=\"Thêm vào giỏ hàng\">Thêm vào giỏ</button>
                                    <button class=\"add-to-wishlist btn-product-wishlist\" data-product-id=\"{$product->id}\" title=\"Thêm vào danh sách yêu thích\">
                                        <i class=\"fa fa-heart-o\"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }
        
        if (empty($html)) {
            $html = '<div class="col-12 text-center p-5"><h4>Không tìm thấy sản phẩm nào</h4></div>';
        }
        
        return $html;
    }

    public function search(Request $request)
    {
        $query = Product::query()
            ->with(['brand', 'categories', 'media'])
            ->where('is_visible', true);

        // Search by keyword (using 'q' parameter like in the URL)
        $searchTerm = $request->get('q', $request->get('search', ''));
        if (!empty(trim($searchTerm))) {
            $search = trim($searchTerm);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('brand', function ($brandQuery) use ($search) {
                      $brandQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('categories', function ($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
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
        $perPage = $request->get('per_page', 12);
        $perPage = in_array($perPage, [12, 24, 36, 48]) ? $perPage : 12;
        $products = $query->paginate($perPage)->withQueryString();

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

        return view('shop.search', compact(
            'products',
            'brands',
            'categories',
            'searchTerm'
        ));
    }
}
