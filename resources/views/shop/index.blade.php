@extends('layouts.frontend')

@section('title', 'Cửa hàng - Shoe Store')
@section('description', 'Khám phá bộ sưu tập giày đa dạng với chất lượng cao')

@section('content')
    <main class="main-content">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
                ['label' => 'Cửa hàng', 'url' => route('shop'), 'icon' => 'store']
            ];

            if ($currentBrand) {
                $breadcrumbItems[] = ['label' => $currentBrand->name, 'icon' => 'tag', 'active' => !$currentCategory];
            }

            if ($currentCategory) {
                $breadcrumbItems[] = ['label' => $currentCategory->name, 'icon' => 'list', 'active' => true];
            }

            if (!$currentBrand && !$currentCategory) {
                $breadcrumbItems[count($breadcrumbItems) - 1]['active'] = true;
            }
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

        <!--== Start Page Header Area Wrapper ==-->
        <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
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
                                <div class="shop-top-bar-test" style="background: #f8f9fa; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <!-- Left: Product Count -->
                                        <div style="flex: 0 0 auto;">
                                            <p class="mb-0" style="font-size: 0.9rem;">
                                                <strong style="color: #DC3E37;">{{ $products->total() }}</strong> sản phẩm
                                            </p>
                                        </div>

                                        <!-- Right: Sort Dropdown -->
                                        <div style="flex: 0 0 auto; margin-left: auto;">
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <span style="font-size: 0.9rem;">Sắp xếp:</span>
                                                <select class="form-select form-select-sm" style="min-width: 150px; width: auto;"
                                                    aria-label="Sort select test" onchange="updateSort(this.value)">
                                                    <option value="created_at"
                                                        {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất
                                                    </option>
                                                    <option value="popularity"
                                                        {{ request('sort') == 'popularity' ? 'selected' : '' }}>Phổ biến
                                                    </option>
                                                    <option value="price_low_to_high"
                                                        {{ request('sort') == 'price_low_to_high' ? 'selected' : '' }}>
                                                        Giá thấp → cao</option>
                                                    <option value="price_high_to_low"
                                                        {{ request('sort') == 'price_high_to_low' ? 'selected' : '' }}>
                                                        Giá cao → thấp</option>
                                                    <option value="name"
                                                        {{ request('sort') == 'name' ? 'selected' : '' }}>
                                                        Tên A-Z</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Filters Display - Above Product Grid -->
                            @if (request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                                <div class="col-12">
                                    <div class="current-filters-bar">
                                        <div class="filters-header">
                                            <div class="filters-count">
                                                <span
                                                    class="count-badge">{{ collect(['search', 'category', 'brand', 'min_price', 'max_price'])->filter(fn($key) => request($key))->count() }}</span>
                                                <span class="count-text">bộ lọc</span>
                                            </div>
                                            <button type="button" onclick="clearAllSelections()"
                                                class="btn-clear-all-filters-top">
                                                <i class="bx bx-x"></i>
                                                <span>Xóa tất cả</span>
                                            </button>
                                        </div>
                                        <div class="filter-tags-wrapper">
                                            @if (request('search'))
                                                <span class="filter-tag search-tag">
                                                    <i class="bx bx-search"></i>
                                                    <span class="tag-label">Tìm kiếm:</span>
                                                    <span class="tag-value">"{{ request('search') }}"</span>
                                                    <button type="button" onclick="removeFilter('search')"
                                                        class="remove-tag">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </span>
                                            @endif
                                            @if (request('category'))
                                                <span class="filter-tag category-tag">
                                                    <i class="bx bx-category"></i>
                                                    <span class="tag-label">Danh mục:</span>
                                                    <span
                                                        class="tag-value">{{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}</span>
                                                    <button type="button" onclick="removeFilter('category')"
                                                        class="remove-tag">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </span>
                                            @endif
                                            @if (request('brand'))
                                                <span class="filter-tag brand-tag">
                                                    <i class="bx bx-copyright"></i>
                                                    <span class="tag-label">Thương hiệu:</span>
                                                    <span
                                                        class="tag-value">{{ $brands->where('slug', request('brand'))->first()->name ?? request('brand') }}</span>
                                                    <button type="button" onclick="removeFilter('brand')"
                                                        class="remove-tag">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </span>
                                            @endif
                                            @if (request('min_price') || request('max_price'))
                                                <span class="filter-tag price-tag">
                                                    <i class="bx bx-dollar"></i>
                                                    <span class="tag-label">Giá:</span>
                                                    <span class="tag-value">
                                                        @if (request('min_price') && request('max_price'))
                                                            {{ number_format(request('min_price'), 0, ',', '.') }} -
                                                            {{ number_format(request('max_price'), 0, ',', '.') }} VNĐ
                                                        @elseif(request('min_price'))
                                                            Từ {{ number_format(request('min_price'), 0, ',', '.') }} VNĐ
                                                        @else
                                                            Dưới {{ number_format(request('max_price'), 0, ',', '.') }} VNĐ
                                                        @endif
                                                    </span>
                                                    <button type="button" onclick="removeFilter('price')"
                                                        class="remove-tag">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="product-views">
                                    <div class="view-content" id="grid-view" style="display: block;">
                                        <div class="row">
                                            @forelse($products as $product)
                                                <div class="col-sm-6 col-lg-4">
                                                    <x-product-card :product="$product" />
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="no-products-message">
                                                        <i class="bx bx-search"></i>
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
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="view-content" id="list-view" style="display: none;">
                                        <div class="row">
                                            @forelse($products as $product)
                                                <div class="col-12">
                                                    <x-product-card :product="$product" class="product-item-list" />
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="no-products-message">
                                                        <i class="bx bx-search"></i>
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
                                                                <i class="bx bx-refresh"></i> Xóa tất cả bộ lọc
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Simple Pagination -->
                            @if ($products->hasPages())
                                <div class="col-12">
                                    <div class="simple-pagination-wrapper">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center mb-0">
                                                {{-- Previous Button --}}
                                                @if ($products->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">&laquo;</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $products->previousPageUrl() }}">&laquo;</a>
                                                    </li>
                                                @endif

                                                {{-- Page Numbers --}}
                                                @php
                                                    $start = max(1, $products->currentPage() - 2);
                                                    $end = min($products->lastPage(), $products->currentPage() + 2);
                                                @endphp

                                                @for ($i = $start; $i <= $end; $i++)
                                                    @if ($i == $products->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link">{{ $i }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endif
                                                @endfor

                                                {{-- Next Button --}}
                                                @if ($products->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $products->nextPageUrl() }}">&raquo;</a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link">&raquo;</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="text-center py-3">
                                        @if ($products->count() > 0)
                                            <span>Hiển thị tất cả <strong>{{ $products->count() }}</strong> sản phẩm</span>
                                        @else
                                            <span class="text-muted">Không có sản phẩm nào</span>
                                        @endif
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
                                    <i class="bx bx-filter-alt"></i>
                                    Bộ lọc
                                </h4>
                                @if (request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                                    <a href="{{ route('shop') }}" class="btn-clear-all-filters">
                                        <i class="bx bx-x"></i>
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
                                            <input type="text" name="search"
                                                class="form-control form-control-sm search-input"
                                                placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                            <button type="button" class="search-clear-btn" onclick="clearSearch()"
                                                {{ !request('search') ? 'style=display:none' : '' }}>
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Filter -->
                                <div class="filter-section category-section">
                                    <div class="filter-section-header collapsible" data-target="category-content">
                                        <h5 class="section-title">
                                            <i class="bx bx-category"></i>
                                            Danh mục ({{ $categories->count() }})
                                        </h5>
                                        <i class="bx bx-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="category-content">
                                        <div class="filter-options compact">
                                            <label
                                                class="filter-option compact {{ !request('category') ? 'active' : '' }}">
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
                                            <i class="bx bx-copyright"></i>
                                            Thương hiệu ({{ $brands->count() }})
                                        </h5>
                                        <i class="bx bx-chevron-down toggle-icon"></i>
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
                                            <i class="bx bx-dollar"></i>
                                            Khoảng giá
                                        </h5>
                                        <i class="bx bx-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="price-content">
                                        <!-- Quick Price Ranges -->
                                        <div class="price-range-grid compact collapsible-items" data-max-show="4">
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
                                            @foreach ($priceRanges as $index => $range)
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
                                                    $hiddenClass = $index >= 4 ? 'hidden-item' : '';
                                                @endphp
                                                <button type="button"
                                                    class="price-range-btn compact {{ $isActive ? 'active' : '' }} {{ $hiddenClass }}"
                                                    onclick="selectPriceRange({{ $range['min'] }}, {{ $range['max'] }})">
                                                    {{ $range['label'] }}
                                                </button>
                                            @endforeach
                                        </div>
                                        @if (count($priceRanges) > 4)
                                            <button type="button" class="btn-show-more" onclick="toggleShowMore(this)">
                                                <span class="show-more-text">Xem thêm</span>
                                                <i class="bx bx-chevron-down"></i>
                                            </button>
                                        @endif

                                        <!-- Custom Price Range -->
                                        <div class="price-inputs-row compact mt-2">
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
                                            <i class="bx bx-ruler"></i>
                                            Kích cỡ
                                        </h5>
                                        <i class="bx bx-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="size-content">
                                        <div class="size-grid compact collapsible-items" data-max-show="6">
                                            @php
                                                $sizes = range(35, 43);
                                            @endphp
                                            @foreach ($sizes as $index => $size)
                                                <button type="button"
                                                    class="size-btn solid-toggle {{ $index >= 6 ? 'hidden-item' : '' }}"
                                                    data-size="{{ $size }}">
                                                    {{ $size }}
                                                </button>
                                            @endforeach
                                        </div>
                                        @if (count($sizes) > 6)
                                            <button type="button" class="btn-show-more" onclick="toggleShowMore(this)">
                                                <span class="show-more-text">Xem thêm</span>
                                                <i class="bx bx-chevron-down"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Color Filter -->
                                <div class="filter-section color-section" data-filter-type="color">
                                    <div class="filter-section-header collapsible" data-target="color-content">
                                        <h5 class="section-title">
                                            <i class="bx bx-palette"></i>
                                            Màu sắc
                                        </h5>
                                        <i class="bx bx-chevron-down toggle-icon"></i>
                                    </div>
                                    <div class="filter-content" id="color-content">
                                        <div class="color-grid compact collapsible-items" data-max-show="8">
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
                                            @foreach ($colors as $index => $color)
                                                <button type="button"
                                                    class="color-btn solid-toggle {{ $index >= 8 ? 'hidden-item' : '' }}"
                                                    data-color="{{ $color['color'] }}"
                                                    style="background-color: {{ $color['color'] }};
                                                           {{ $color['color'] === '#FFFFFF' ? 'border: 2px solid #ddd;' : '' }}"
                                                    title="{{ $color['name'] }}">
                                                    <i class="bx bx-check color-check"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                        @if (count($colors) > 8)
                                            <button type="button" class="btn-show-more" onclick="toggleShowMore(this)">
                                                <span class="show-more-text">Xem thêm</span>
                                                <i class="bx bx-chevron-down"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Selection Summary -->
                                <div class="selection-summary">
                                    <span class="summary-text">Đã chọn: 0 bộ lọc</span>
                                    <span class="clear-selection" onclick="clearAllSelections()">Xóa tất cả</span>
                                </div>

                                <!-- Filter Actions -->
                                <div class="filter-actions compact">
                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-reset-filter"
                                        onclick="resetAllFilters()">
                                        <i class="bx bx-refresh"></i>
                                        Đặt lại tất cả
                                    </button>
                                </div>
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
        <script src="{{ asset('js/shop-ajax-filter.js') }}"></script>
        <script src="{{ asset('js/wishlist.js') }}"></script>
    @endpush

    @push('styles')
        <link href="{{ asset('css/shop-page.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/shop-page-custom.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/wishlist-shared.css') }}" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="{{ asset('js/shop.js') }}"></script>
    @endpush
@endsection
