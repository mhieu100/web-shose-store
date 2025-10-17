@extends('layouts.frontend')

@section('title', 'Cửa hàng - Shoe Store')
@section('description', 'Khám phá bộ sưu tập giày đa dạng với chất lượng cao')

@section('content')
    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
            <div class="container pt--0 pb--0">
                <div class="row">
                    <div class="col-12">
                        <div class="page-header-content">
                            <h2 class="title" data-aos="fade-down" data-aos-duration="1000">
                                Cửa hàng
                                @if ($currentBrand)
                                    - {{ $currentBrand->name }}
                                @endif
                                @if ($currentCategory)
                                    - {{ $currentCategory->name }}
                                @endif
                            </h2>
                            <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                                <ul class="breadcrumb">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-sep">//</li>
                                    <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
                                    @if ($currentBrand)
                                        <li class="breadcrumb-sep">//</li>
                                        <li>{{ $currentBrand->name }}</li>
                                    @endif
                                    @if ($currentCategory)
                                        <li class="breadcrumb-sep">//</li>
                                        <li>{{ $currentCategory->name }}</li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->
        <section class="product-area product-default-area">
            <div class="container">
                <div class="row flex-xl-row-reverse justify-content-between">
                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="shop-top-bar">
                                    <div class="row align-items-center g-2">
                                        <!-- Product Count - Takes full width on mobile, half on tablet, auto on desktop -->
                                        <div class="col-12 col-md-6 col-lg-5 mb-2 mb-md-0">
                                            <div class="shop-top-left">
                                                <p class="pagination-line mb-0 text-center text-md-start">
                                                    <strong>{{ $products->total() }}</strong> sản phẩm được tìm thấy
                                                    @if ($currentBrand)
                                                        cho thương hiệu <strong>{{ $currentBrand->name }}</strong>
                                                    @endif
                                                    @if ($currentCategory)
                                                        trong danh mục <strong>{{ $currentCategory->name }}</strong>
                                                    @endif
                                                    @if (request('min_price') || request('max_price'))
                                                        với giá
                                                        @if (request('min_price') && request('max_price'))
                                                            từ <strong>{{ number_format(request('min_price'), 0, ',', '.') }}
                                                                VNĐ</strong>
                                                            đến <strong>{{ number_format(request('max_price'), 0, ',', '.') }}
                                                                VNĐ</strong>
                                                        @elseif(request('min_price'))
                                                            từ <strong>{{ number_format(request('min_price'), 0, ',', '.') }}
                                                                VNĐ</strong>
                                                        @elseif(request('max_price'))
                                                            dưới <strong>{{ number_format(request('max_price'), 0, ',', '.') }}
                                                                VNĐ</strong>
                                                        @endif
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sort Dropdown - Takes half width on mobile, quarter on tablet, auto on desktop -->
                                        <div class="col-6 col-md-3 col-lg-4 mb-2 mb-md-0">
                                            <div class="shop-top-center">
                                                <div class="shop-sort d-flex align-items-center gap-2">
                                                    <span class="d-none d-lg-inline text-nowrap">Sắp xếp:</span>
                                                    <select class="form-select form-select-sm flex-grow-1" aria-label="Sort select"
                                                        onchange="updateSort(this.value)">
                                                        <option value="created_at"
                                                            {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất
                                                        </option>
                                                        <option value="popularity"
                                                            {{ request('sort') == 'popularity' ? 'selected' : '' }}>Phổ biến
                                                        </option>
                                                        <option value="price_low_to_high"
                                                            {{ request('sort') == 'price_low_to_high' ? 'selected' : '' }}>Giá thấp → cao</option>
                                                        <option value="price_high_to_low"
                                                            {{ request('sort') == 'price_high_to_low' ? 'selected' : '' }}>Giá cao → thấp</option>
                                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                                            Tên A-Z</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Toggle - Takes half width on mobile, quarter on tablet, auto on desktop -->
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <div class="shop-top-right d-flex justify-content-end">
                                                <div class="view-toggle">
                                                    <button class="view-toggle-btn active" id="grid-view-btn" data-view="grid"
                                                            title="Xem dạng lưới">
                                                        <i class="fa fa-th"></i>
                                                        <span class="d-none d-lg-inline ms-1">Lưới</span>
                                                    </button>
                                                    <button class="view-toggle-btn" id="list-view-btn" data-view="list"
                                                            title="Xem dạng danh sách">
                                                        <i class="fa fa-list"></i>
                                                        <span class="d-none d-lg-inline ms-1">Danh sách</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="product-views">
                                    <div class="view-content" id="grid-view" style="display: block;">
                                        <div class="row">
                                            @forelse($products as $product)
                                                <div class="col-sm-6 col-lg-4">
                                                    <!--== Start Product Item ==-->
                                                    <div class="product-item">
                                                        <div class="inner-content">
                                                            <div class="product-thumb">
                                                                <a href="{{ route('product.show', $product->id) }}">
                                                                    @if ($product->getFirstMediaUrl('product-images'))
                                                                        <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                                                                            width="270" height="274"
                                                                            alt="{{ $product->name }}">
                                                                    @else
                                                                        <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                                            width="270" height="274"
                                                                            alt="{{ $product->name }}">
                                                                    @endif
                                                                </a>
                                                                @if ($product->old_price && $product->old_price > $product->price)
                                                                    <div class="product-flag">
                                                                        <ul>
                                                                            <li class="discount">
                                                                                -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                                <div class="product-action">
                                                                    <x-wishlist-button :product="$product" class="btn-product-wishlist" />
                                                                    <button type="button" class="btn-product-cart add-to-cart"
                                                                            data-product-id="{{ $product->id }}"
                                                                            data-product-name="{{ $product->name }}"
                                                                            data-product-price="{{ $product->sale_price ?? $product->price }}"
                                                                            data-product-colors="{{ $product->colors ? json_encode($product->colors) : '[]' }}"
                                                                            data-product-sizes="{{ $product->sizes ? json_encode($product->sizes) : '[]' }}"
                                                                            title="Thêm vào giỏ hàng">
                                                                        <i class="fas fa-shopping-cart"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn-product-quick-view-open">
                                                                        <i class="fas fa-expand-arrows-alt"></i>
                                                                    </button>
                                                                    <a class="btn-product-compare"
                                                                        href="{{ route('compare') }}"><i
                                                                            class="fas fa-random"></i></a>
                                                                </div>
                                                                <a class="banner-link-overlay"
                                                                    href="{{ route('product.show', $product->id) }}"></a>
                                                            </div>
                                                            <div class="product-info">
                                                                <div class="category">
                                                                    <ul>
                                                                        @foreach ($product->categories->take(2) as $category)
                                                                            <li><a
                                                                                    href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                                                            </li>
                                                                            @if (!$loop->last)
                                                                                <li class="sep">/</li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                                <h4 class="title"><a
                                                                        href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                                                </h4>
                                                                <div class="prices">
                                                                    @if ($product->old_price && $product->old_price > $product->price)
                                                                        <span
                                                                            class="price-old">{{ number_format($product->old_price, 0, ',', '.') }}
                                                                            VNĐ</span>
                                                                        <span class="sep">-</span>
                                                                    @endif
                                                                    <span
                                                                        class="price">{{ number_format($product->price, 0, ',', '.') }}
                                                                        VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--== End Product Item ==-->
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="no-products-message">
                                                        <i class="fa fa-search"></i>
                                                        <h3>Không tìm thấy sản phẩm nào</h3>
                                                        <p>
                                                            @if (request('search') || request('brand') || request('category') || request('min_price') || request('max_price'))
                                                                Không có sản phẩm nào phù hợp với các bộ lọc hiện tại.<br>
                                                                Hãy thử điều chỉnh bộ lọc hoặc xóa tất cả bộ lọc để xem toàn
                                                                bộ sản phẩm.
                                                            @else
                                                                Hiện tại không có sản phẩm nào trong cửa hàng.
                                                            @endif
                                                        </p>
                                                        @if (request('search') || request('brand') || request('category') || request('min_price') || request('max_price'))
                                                            <a href="{{ route('shop') }}" class="btn-clear-filters">
                                                                <i class="fa fa-refresh"></i> Xóa tất cả bộ lọc
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="view-content" id="list-view" style="display: none;">
                                        <div class="row">
                                            @forelse($products as $product)
                                                <div class="col-12">
                                                    <!--== Start Product Item ==-->
                                                    <div class="product-item product-item-list">
                                                        <div class="inner-content">
                                                            <div class="product-thumb">
                                                                <a href="{{ route('product.show', $product->id) }}">
                                                                    @if ($product->getFirstMediaUrl('product-images'))
                                                                        <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                                                                            width="270" height="274"
                                                                            alt="{{ $product->name }}">
                                                                    @else
                                                                        <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                                            width="270" height="274"
                                                                            alt="{{ $product->name }}">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="product-info">
                                                                <h4 class="title"><a
                                                                        href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                                                </h4>
                                                                <div class="prices">
                                                                    @if ($product->old_price && $product->old_price > $product->price)
                                                                        <span
                                                                            class="price-old">{{ number_format($product->old_price, 0, ',', '.') }}
                                                                            VNĐ</span>
                                                                        <span class="sep">-</span>
                                                                    @endif
                                                                    <span
                                                                        class="price">{{ number_format($product->price, 0, ',', '.') }}
                                                                        VNĐ</span>
                                                                </div>
                                                                <p>{{ Str::limit($product->description, 100) }}</p>
                                                                <div class="product-action">
                                                                    <button type="button" class="btn-product-cart add-to-cart"
                                                                            data-product-id="{{ $product->id }}"
                                                                            data-product-name="{{ $product->name }}"
                                                                            data-product-price="{{ $product->sale_price ?? $product->price }}"
                                                                            data-product-colors="{{ $product->colors ? json_encode($product->colors) : '[]' }}"
                                                                            data-product-sizes="{{ $product->sizes ? json_encode($product->sizes) : '[]' }}"
                                                                            title="Thêm vào giỏ hàng">Thêm vào giỏ</button>
                                                                    <x-wishlist-button :product="$product" class="btn-product-wishlist" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--== End Product Item ==-->
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="no-products-message">
                                                        <i class="fa fa-search"></i>
                                                        <h3>Không tìm thấy sản phẩm nào</h3>
                                                        <p>
                                                            @if (request('search') || request('brand') || request('category') || request('min_price') || request('max_price'))
                                                                Không có sản phẩm nào phù hợp với các bộ lọc hiện tại.<br>
                                                                Hãy thử điều chỉnh bộ lọc hoặc xóa tất cả bộ lọc để xem toàn
                                                                bộ sản phẩm.
                                                            @else
                                                                Hiện tại không có sản phẩm nào trong cửa hàng.
                                                            @endif
                                                        </p>
                                                        @if (request('search') || request('brand') || request('category') || request('min_price') || request('max_price'))
                                                            <a href="{{ route('shop') }}" class="btn-clear-filters">
                                                                <i class="fa fa-refresh"></i> Xóa tất cả bộ lọc
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Pagination -->
                            @if ($products->hasPages())
                                <div class="col-12">
                                    <div class="pagination-wrapper">
                                        <div class="pagination-info">
                                            <div class="pagination-summary">
                                                <span class="showing-text">Hiển thị</span>
                                                <strong>{{ $products->firstItem() ?? 0 }}</strong>
                                                <span>đến</span>
                                                <strong>{{ $products->lastItem() ?? 0 }}</strong>
                                                <span>trong tổng số</span>
                                                <strong>{{ $products->total() }}</strong>
                                                <span>sản phẩm</span>
                                                @if (request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                                                    <span class="filtered-text">(đã lọc)</span>
                                                @endif
                                            </div>

                                            <div class="per-page-selector">
                                                <label for="per-page">Hiển thị:</label>
                                                <select id="per-page" class="form-select per-page-select"
                                                    onchange="changePerPage(this.value)">
                                                    <option value="12"
                                                        {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 sản phẩm
                                                    </option>
                                                    <option value="24"
                                                        {{ request('per_page') == 24 ? 'selected' : '' }}>24 sản phẩm
                                                    </option>
                                                    <option value="36"
                                                        {{ request('per_page') == 36 ? 'selected' : '' }}>36 sản phẩm
                                                    </option>
                                                    <option value="48"
                                                        {{ request('per_page') == 48 ? 'selected' : '' }}>48 sản phẩm
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="pagination-area">
                                            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                                                <div class="pagination-container">
                                                    @if ($products->onFirstPage())
                                                        <span class="page-link disabled first-last-btn">
                                                            <i class="fa fa-angle-double-left"></i>
                                                            <span class="btn-text">Đầu</span>
                                                        </span>
                                                        <span class="page-link disabled">
                                                            <i class="fa fa-angle-left"></i>
                                                            <span class="btn-text">Trước</span>
                                                        </span>
                                                    @else
                                                        <a href="{{ $products->url(1) }}"
                                                            class="page-link first-last-btn">
                                                            <i class="fa fa-angle-double-left"></i>
                                                            <span class="btn-text">Đầu</span>
                                                        </a>
                                                        <a href="{{ $products->previousPageUrl() }}" class="page-link">
                                                            <i class="fa fa-angle-left"></i>
                                                            <span class="btn-text">Trước</span>
                                                        </a>
                                                    @endif

                                                    <div class="page-numbers">
                                                        @php
                                                            $start = max(1, $products->currentPage() - 2);
                                                            $end = min(
                                                                $products->lastPage(),
                                                                $products->currentPage() + 2,
                                                            );
                                                        @endphp

                                                        @if ($start > 1)
                                                            <a href="{{ $products->url(1) }}" class="page-link">1</a>
                                                            @if ($start > 2)
                                                                <span class="page-link dots">...</span>
                                                            @endif
                                                        @endif

                                                        @for ($i = $start; $i <= $end; $i++)
                                                            @if ($i == $products->currentPage())
                                                                <span class="page-link active">{{ $i }}</span>
                                                            @else
                                                                <a href="{{ $products->url($i) }}"
                                                                    class="page-link">{{ $i }}</a>
                                                            @endif
                                                        @endfor

                                                        @if ($end < $products->lastPage())
                                                            @if ($end < $products->lastPage() - 1)
                                                                <span class="page-link dots">...</span>
                                                            @endif
                                                            <a href="{{ $products->url($products->lastPage()) }}"
                                                                class="page-link">{{ $products->lastPage() }}</a>
                                                        @endif
                                                    </div>

                                                    @if ($products->hasMorePages())
                                                        <a href="{{ $products->nextPageUrl() }}" class="page-link">
                                                            <span class="btn-text">Tiếp</span>
                                                            <i class="fa fa-angle-right"></i>
                                                        </a>
                                                        <a href="{{ $products->url($products->lastPage()) }}"
                                                            class="page-link first-last-btn">
                                                            <span class="btn-text">Cuối</span>
                                                            <i class="fa fa-angle-double-right"></i>
                                                        </a>
                                                    @else
                                                        <span class="page-link disabled">
                                                            <span class="btn-text">Tiếp</span>
                                                            <i class="fa fa-angle-right"></i>
                                                        </span>
                                                        <span class="page-link disabled first-last-btn">
                                                            <span class="btn-text">Cuối</span>
                                                            <i class="fa fa-angle-double-right"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </nav>
                                        </div>

                                        <div class="pagination-jump">
                                            <div class="jump-to-page">
                                                <label for="jump-page">Đi đến trang:</label>
                                                <input type="number" id="jump-page" class="form-control jump-input"
                                                    min="1" max="{{ $products->lastPage() }}"
                                                    placeholder="{{ $products->currentPage() }}">
                                                <button type="button" class="btn btn-primary jump-btn"
                                                    onclick="jumpToPage()">
                                                    <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="pagination-wrapper no-pagination">
                                        <div class="pagination-info">
                                            <div class="pagination-summary">
                                                @if ($products->count() > 0)
                                                    <span>Hiển thị tất cả</span>
                                                    <strong>{{ $products->count() }}</strong>
                                                    <span>sản phẩm</span>
                                                @else
                                                    <span class="no-results">Không có sản phẩm nào</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <!-- Unified Product Filter Section -->
                        <div class="product-filter-panel compact-filter">
                            <div class="filter-header">
                                <h4 class="filter-title">
                                    <i class="fa fa-filter"></i>
                                    Bộ lọc
                                </h4>
                                @if (request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                                    <a href="{{ route('shop') }}" class="btn-clear-all-filters">
                                        <i class="fa fa-times"></i>
                                        Xóa
                                    </a>
                                @endif
                            </div>

                            <!-- All-in-One Filter Form -->
                            <form action="{{ route('shop') }}" method="GET" class="unified-filter-form"
                                id="filter-form">
                                @if (request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                @if (request('per_page'))
                                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                @endif

                                <!-- Search Filter -->
                                <div class="filter-section search-section">
                                    <div class="filter-content">
                                        <div class="search-input-wrapper">
                                            <input type="text" name="search" class="form-control form-control-sm search-input"
                                                placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                            <button type="button" class="search-clear-btn" onclick="clearSearch()"
                                                {{ !request('search') ? 'style=display:none' : '' }}>
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Filter -->
                                <div class="filter-section category-section">
                                    <div class="filter-section-header collapsible" data-target="category-content">
                                        <h5 class="section-title">
                                            <i class="fa fa-tags"></i>
                                            Danh mục ({{ $categories->count() }})
                                        </h5>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="category-content">
                                        <div class="filter-options compact">
                                            <label class="filter-option compact {{ !request('category') ? 'active' : '' }}">
                                                <input type="radio" name="category" value=""
                                                    {{ !request('category') ? 'checked' : '' }}>
                                                <span class="option-text">Tất cả</span>
                                            </label>
                                            @foreach ($categories as $category)
                                                <label
                                                    class="filter-option compact {{ request('category') == $category->slug ? 'active' : '' }}">
                                                    <input type="radio" name="category" value="{{ $category->slug }}"
                                                        {{ request('category') == $category->slug ? 'checked' : '' }}>
                                                    <span class="option-text">{{ $category->name }}</span>
                                                    <span class="option-count">({{ $category->products_count }})</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Brand Filter -->
                                <div class="filter-section brand-section">
                                    <div class="filter-section-header collapsible" data-target="brand-content">
                                        <h5 class="section-title">
                                            <i class="fa fa-copyright"></i>
                                            Thương hiệu ({{ $brands->count() }})
                                        </h5>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="brand-content">
                                        <div class="filter-options compact">
                                            <label class="filter-option compact {{ !request('brand') ? 'active' : '' }}">
                                                <input type="radio" name="brand" value=""
                                                    {{ !request('brand') ? 'checked' : '' }}>
                                                <span class="option-text">Tất cả</span>
                                            </label>
                                            @foreach ($brands as $brand)
                                                <label
                                                    class="filter-option compact {{ request('brand') == $brand->slug ? 'active' : '' }}">
                                                    <input type="radio" name="brand" value="{{ $brand->slug }}"
                                                        {{ request('brand') == $brand->slug ? 'checked' : '' }}>
                                                    <span class="option-text">{{ $brand->name }}</span>
                                                    <span class="option-count">({{ $brand->products_count }})</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Filter -->
                                <div class="filter-section price-section">
                                    <div class="filter-section-header collapsible" data-target="price-content">
                                        <h5 class="section-title">
                                            <i class="fa fa-dollar"></i>
                                            Khoảng giá
                                        </h5>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="price-content">
                                        <!-- Quick Price Ranges -->
                                        <div class="price-range-grid compact">
                                            @php
                                                $priceRanges = [
                                                    ['min' => null, 'max' => null, 'label' => 'Tất cả'],
                                                    ['min' => 1, 'max' => 500000, 'label' => '<500k'],
                                                    ['min' => 500000, 'max' => 1000000, 'label' => '500k-1tr'],
                                                    ['min' => 1000000, 'max' => 2000000, 'label' => '1tr-2tr'],
                                                    ['min' => 2000000, 'max' => 5000000, 'label' => '2tr-5tr'],
                                                    ['min' => 5000000, 'max' => null, 'label' => '>5tr'],
                                                ];
                                            @endphp
                                            @foreach ($priceRanges as $range)
                                                @php
                                                    $isActive = false;
                                                    if ($range['min'] === null && $range['max'] === null) {
                                                        $isActive = !request('min_price') && !request('max_price');
                                                    } else {
                                                        $isActive =
                                                            request('min_price') == $range['min'] &&
                                                            (is_null($range['max'])
                                                                ? !request('max_price')
                                                                : request('max_price') == $range['max']);
                                                    }
                                                @endphp
                                                <button type="button"
                                                    class="price-range-btn compact {{ $isActive ? 'active' : '' }}"
                                                    onclick="selectPriceRange({{ $range['min'] }}, {{ $range['max'] }})">
                                                    {{ $range['label'] }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <!-- Custom Price Range -->
                                        <div class="price-inputs-row compact">
                                            <input type="number" id="min_price_filter" name="min_price"
                                                class="form-control form-control-sm price-input" placeholder="Từ"
                                                min="0" max="1000000000" value="{{ request('min_price') }}">
                                            <span class="price-separator">-</span>
                                            <input type="number" id="max_price_filter" name="max_price"
                                                class="form-control form-control-sm price-input" placeholder="Đến"
                                                min="0" max="1000000000" value="{{ request('max_price') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Size Filter -->
                                <div class="filter-section size-section" data-filter-type="size">
                                    <div class="filter-section-header collapsible" data-target="size-content">
                                        <h5 class="section-title">
                                            <i class="fas fa-expand-arrows-alt-h"></i>
                                            Kích cỡ
                                        </h5>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="size-content">
                                        <div class="size-grid compact">
                                            @for ($size = 35; $size <= 43; $size++)
                                                <button type="button" class="size-btn solid-toggle" data-size="{{ $size }}">
                                                    {{ $size }}
                                                </button>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <!-- Color Filter -->
                                <div class="filter-section color-section" data-filter-type="color">
                                    <div class="filter-section-header collapsible" data-target="color-content">
                                        <h5 class="section-title">
                                            <i class="fa fa-paint-brush"></i>
                                            Màu sắc
                                        </h5>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="color-content">
                                        <div class="color-grid compact">
                                            @php
                                                $colors = [
                                                    ['color' => '#000000', 'name' => 'Đen'],
                                                    ['color' => '#FFFFFF', 'name' => 'Trắng'],
                                                    ['color' => '#8B4513', 'name' => 'Nâu'],
                                                    ['color' => '#FF0000', 'name' => 'Đỏ'],
                                                    ['color' => '#0000FF', 'name' => 'Xanh dương'],
                                                    ['color' => '#008000', 'name' => 'Xanh lá'],
                                                    ['color' => '#FFFF00', 'name' => 'Vàng'],
                                                    ['color' => '#FFC0CB', 'name' => 'Hồng'],
                                                    ['color' => '#808080', 'name' => 'Xám'],
                                                    ['color' => '#800080', 'name' => 'Tím'],
                                                    ['color' => '#FFA500', 'name' => 'Cam'],
                                                    ['color' => '#A52A2A', 'name' => 'Nâu đỏ'],
                                                ];
                                            @endphp
                                            @foreach ($colors as $color)
                                                <button type="button" class="color-btn solid-toggle"
                                                    data-color="{{ $color['color'] }}"
                                                    style="background-color: {{ $color['color'] }};
                                                           {{ $color['color'] === '#FFFFFF' ? 'border: 2px solid #ddd;' : '' }}"
                                                    title="{{ $color['name'] }}">
                                                    <i class="fa fa-check color-check"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Selection Summary -->
                                <div class="selection-summary">
                                    <span class="summary-text">Đã chọn: 0 bộ lọc</span>
                                    <span class="clear-selection" onclick="clearAllSelections()">Xóa tất cả</span>
                                </div>

                                <!-- Filter Actions -->
                                <div class="filter-actions compact">
                                    <button type="submit" class="btn btn-primary btn-sm btn-apply-filter">
                                        <i class="fa fa-check"></i>
                                        Áp dụng
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-reset-filter"
                                        onclick="resetAllFilters()">
                                        <i class="fa fa-refresh"></i>
                                        Đặt lại
                                    </button>
                                </div>

                                <!-- Current Filters Display -->
                                @if (request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                                    <div class="current-filters">
                                        <h5 class="current-filters-title">Bộ lọc hiện tại:</h5>
                                        <div class="filter-tags">
                                            @if (request('search'))
                                                <span class="filter-tag search-tag">
                                                    <i class="fa fa-search"></i>
                                                    "{{ request('search') }}"
                                                    <button type="button" onclick="removeFilter('search')"
                                                        class="remove-tag">×</button>
                                                </span>
                                            @endif
                                            @if (request('category'))
                                                <span class="filter-tag category-tag">
                                                    <i class="fa fa-folder"></i>
                                                    {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}
                                                    <button type="button" onclick="removeFilter('category')"
                                                        class="remove-tag">×</button>
                                                </span>
                                            @endif
                                            @if (request('brand'))
                                                <span class="filter-tag brand-tag">
                                                    <i class="fa fa-tag"></i>
                                                    {{ $brands->where('slug', request('brand'))->first()->name ?? request('brand') }}
                                                    <button type="button" onclick="removeFilter('brand')"
                                                        class="remove-tag">×</button>
                                                </span>
                                            @endif
                                            @if (request('min_price') || request('max_price'))
                                                <span class="filter-tag price-tag">
                                                    <i class="fa fa-money"></i>
                                                    @if (request('min_price') && request('max_price'))
                                                        {{ number_format(request('min_price'), 0, ',', '.') }} -
                                                        {{ number_format(request('max_price'), 0, ',', '.') }} VNĐ
                                                    @elseif(request('min_price'))
                                                        Từ {{ number_format(request('min_price'), 0, ',', '.') }} VNĐ
                                                    @elseif(request('max_price'))
                                                        Dưới {{ number_format(request('max_price'), 0, ',', '.') }} VNĐ
                                                    @endif
                                                    <button type="button" onclick="removeFilter('price')"
                                                        class="remove-tag">×</button>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Product Area Wrapper ==-->
    </main>

    @push('scripts')
        <script src="{{ asset('js/shop-page.js') }}"></script>
        <script src="{{ asset('js/wishlist.js') }}"></script>
    @endpush

    @push('styles')
        <link href="{{ asset('css/shop-page.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/wishlist-shared.css') }}" rel="stylesheet" />
    @endpush

    @push('scripts')
    <script src="{{ asset('js/shop.js') }}"></script>
    @endpush
@endsection
