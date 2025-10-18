@extends('layouts.frontend')

@section('title', $product->name . ' - Shoe Store')
@section('description', $product->description ? strip_tags($product->description) : 'Chi tiết sản phẩm ' .
    $product->name)

@section('content')
    @php use Illuminate\Support\Facades\Storage; @endphp
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">{{ $product->name }}</h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
                                @if ($product->categories->count() > 0)
                                    <li class="breadcrumb-sep">//</li>
                                    <li><a href="{{ route('shop') }}">{{ $product->categories->first()->name }}</a></li>
                                @endif
                                <li class="breadcrumb-sep">//</li>
                                <li>{{ $product->name }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Product Single Area Wrapper ==-->
    <section class="product-area product-single-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-single-item">
                        <div class="row">
                            <div class="col-xl-6">
                                <!--== Start Product Thumbnail Area ==-->
                                <div class="product-single-thumb">
                                    <div class="swiper-container single-product-thumb single-product-thumb-slider">
                                        <div class="swiper-wrapper">
                                            @if ($product->getMedia('product-images')->count() > 0)
                                                @foreach ($product->getMedia('product-images') as $media)
                                                    <div class="swiper-slide">
                                                        <div class="custom-zoom-container">
                                                            <img class="zoom-image" src="{{ $media->getUrl() }}"
                                                                width="570" height="541" alt="{{ $product->name }}"
                                                                data-large="{{ $media->getUrl() }}">
                                                            <div class="zoom-lens"></div>
                                                            <div class="zoom-magnifier">
                                                                <img src="{{ $media->getUrl() }}"
                                                                    alt="{{ $product->name }}">
                                                            </div>
                                                            <a class="lightbox-link" data-fancybox="gallery"
                                                                href="{{ $media->getUrl() }}"
                                                                data-caption="{{ $product->name }} - Hình {{ $loop->iteration }}">
                                                                <div class="zoom-overlay">
                                                                    <i class="fa fa-search-plus"></i>
                                                                    <span>Hover để zoom, Click để phóng to</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="swiper-slide">
                                                    <div class="custom-zoom-container">
                                                        <img class="zoom-image"
                                                            src="{{ asset('img/shop/product-single/1.webp') }}"
                                                            width="570" height="541" alt="{{ $product->name }}"
                                                            data-large="{{ asset('img/shop/product-single/1.webp') }}">
                                                        <div class="zoom-lens"></div>
                                                        <div class="zoom-magnifier">
                                                            <img src="{{ asset('img/shop/product-single/1.webp') }}"
                                                                alt="{{ $product->name }}">
                                                        </div>
                                                        <a class="lightbox-link" data-fancybox="gallery"
                                                            href="{{ asset('img/shop/product-single/1.webp') }}"
                                                            data-caption="{{ $product->name }}">
                                                            <div class="zoom-overlay">
                                                                <i class="fa fa-search-plus"></i>
                                                                <span>Hover để zoom, Click để phóng to</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="swiper-container single-product-nav single-product-nav-slider">
                                        <div class="swiper-wrapper">
                                            @if ($product->getMedia('product-images')->count() > 0)
                                                @foreach ($product->getMedia('product-images') as $media)
                                                    <div class="swiper-slide">
                                                        <img src="{{ $media->getUrl('thumb') }}" width="127"
                                                            height="127" alt="{{ $product->name }}">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('img/shop/product-single/nav-1.webp') }}"
                                                        width="127" height="127" alt="{{ $product->name }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--== End Product Thumbnail Area ==-->
                            </div>
                            <div class="col-xl-6">
                                <!--== Start Product Info Area ==-->
                                <div class="product-single-info">
                                    <h3 class="main-title">{{ $product->name }}</h3>
                                    <div class="prices">
                                        @if ($product->old_price && $product->old_price > $product->price)
                                            <span class="price-old">{{ number_format($product->old_price) }} VNĐ</span>
                                            <span class="price">{{ number_format($product->price) }} VNĐ</span>
                                        @else
                                            <span class="price">{{ number_format($product->price) }} VNĐ</span>
                                        @endif
                                    </div>
                                    <div class="rating-box-wrap">
                                        <div class="rating-box">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star{{ $i <= ($product->rating ?? 5) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="review-status">
                                            <a href="javascript:void(0)">({{ $product->comments_count ?? 0 }} đánh giá
                                                khách hàng)</a>
                                        </div>
                                    </div>
                                    @if ($product->description)
                                        <div class="product-description">
                                            {!! $product->description !!}
                                        </div>
                                    @endif

                                    @if ($product->categories->count() > 0)
                                        <div class="product-category">
                                            <span><strong>Danh mục:</strong>
                                                @foreach ($product->categories as $category)
                                                    {{ $category->name }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif

                                    @if($product->colors && count($product->colors) > 0)
                                    <div class="product-color">
                                        <h6 class="title">Màu sắc</h6>
                                        <ul class="color-list">
                                            @foreach($product->colors as $index => $color)
                                                @php
                                                    // Handle both string format and object format
                                                    if (is_array($color)) {
                                                        $colorName = $color['name'] ?? $color['color'] ?? 'Unknown';
                                                        $colorCode = $color['color_code'] ?? $color['code'] ?? $color['hex'] ?? '#000000';
                                                    } else {
                                                        $colorName = $color;
                                                        // Simple color mapping for Vietnamese color names
                                                        $colorCode = match(strtolower($color)) {
                                                            'đỏ', 'red' => '#FF0000',
                                                            'xanh', 'blue' => '#0000FF',
                                                            'vàng', 'yellow' => '#FFFF00',
                                                            'xanh lá', 'green' => '#008000',
                                                            'đen', 'black' => '#000000',
                                                            'trắng', 'white' => '#FFFFFF',
                                                            'nâu', 'brown' => '#A52A2A',
                                                            'hồng', 'pink' => '#FFC0CB',
                                                            'cam', 'orange' => '#FFA500',
                                                            'tím', 'purple' => '#800080',
                                                            'xám', 'gray', 'grey' => '#808080',
                                                            'be', 'beige' => '#F5F5DC',
                                                            default => '#' . substr(md5($color), 0, 6)
                                                        };
                                                    }
                                                @endphp
                                                <li class="{{ $index === 0 ? 'active' : '' }}"
                                                    data-bg-color="{{ $colorCode }}"
                                                    data-color-name="{{ $colorName }}"
                                                    title="{{ $colorName }}"
                                                    style="background-color: {{ $colorCode }}; border: 2px solid #ddd;"></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if($product->sizes && count($product->sizes) > 0)
                                    <div class="product-size">
                                        <h6 class="title">Kích thước</h6>
                                        <ul class="size-list">
                                            @foreach($product->sizes as $index => $size)
                                                @php
                                                    // Handle both string/numeric format and object format
                                                    if (is_array($size)) {
                                                        $sizeValue = $size['value'] ?? $size['size'] ?? $size['label'] ?? 'Unknown';
                                                        $sizeLabel = $size['label'] ?? "Size {$sizeValue}";
                                                    } else {
                                                        $sizeValue = $size;
                                                        $sizeLabel = "Size {$size}";
                                                    }
                                                @endphp
                                                <li class="{{ $index === 0 ? 'active' : '' }}"
                                                    data-size="{{ $sizeValue }}"
                                                    title="{{ $sizeLabel }}">
                                                    {{ $sizeValue }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <div class="product-quick-action">
                                        <div class="qty-wrap">
                                            <div>
                                                <button type="button" class="btn dec qtybtn" aria-label="Decrease quantity">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="number" id="product-quantity" class="quantity-input"
                                                    title="Quantity" value="1" min="1"
                                                    max="{{ $product->qty ?? 100 }}" readonly>
                                                <button type="button" class="btn inc qtybtn" aria-label="Increase quantity">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-theme add-to-cart"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->price }}">
                                            <i class="fa fa-shopping-cart me-2"></i>
                                            Thêm vào giỏ
                                        </button>
                                    </div>

                                    <div class="product-wishlist-compare">
                                        <x-wishlist-button :product="$product" class="btn wishlist-btn" style="color: red !important" />
                                        <span class="wishlist-text">Thêm vào yêu thích</span>
                                        <a href="{{ route('compare') }}"><i class="pe-7s-shuffle"></i>So sánh sản
                                            phẩm</a>
                                    </div>

                                    <div class="product-info-footer">
                                        <h6 class="code"><span>Mã sản phẩm:</span>
                                            {{ $product->sku ?? 'SP-' . str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</h6>
                                        <div class="social-icons">
                                            <span>Chia sẻ</span>
                                            <a href="#/" target="_blank"><i class="fa fa-facebook"></i></a>
                                            <a href="#/" target="_blank"><i class="fa fa-twitter"></i></a>
                                            <a href="#/" target="_blank"><i class="fa fa-pinterest-p"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!--== End Product Info Area ==-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="product-review-tabs-content">
                        <ul class="nav product-tab-nav" id="ReviewTab" role="tablist">
                            <li role="presentation">
                                <a class="active" id="information-tab" data-bs-toggle="pill" href="#information"
                                    role="tab" aria-controls="information" aria-selected="true">Thông tin</a>
                            </li>
                            <li role="presentation">
                                <a id="description-tab" data-bs-toggle="pill" href="#description" role="tab"
                                    aria-controls="description" aria-selected="false">Mô tả</a>
                            </li>
                            <li role="presentation">
                                <a id="reviews-tab" data-bs-toggle="pill" href="#reviews" role="tab"
                                    aria-controls="reviews" aria-selected="false">Đánh giá
                                    <span>({{ rand(3, 10) }})</span></a>
                            </li>
                        </ul>
                        <div class="tab-content product-tab-content" id="ReviewTabContent">
                            <div class="tab-pane fade show active" id="information" role="tabpanel"
                                aria-labelledby="information-tab">
                                <div class="product-information">
                                    <h4>Thông tin sản phẩm</h4>
                                    <ul>
                                        <li><strong>Chất liệu:</strong> Da thật cao cấp</li>
                                        <li><strong>Đế giày:</strong> Cao su chống trượt</li>
                                        <li><strong>Lót giày:</strong> Memory foam êm ái</li>
                                        <li><strong>Xuất xứ:</strong> Việt Nam</li>
                                        <li><strong>Bảo hành:</strong> 6 tháng</li>
                                        <li><strong>Hướng dẫn bảo quản:</strong> Tránh nước, bảo quản nơi khô ráo</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="product-description">
                                    <h4>Mô tả chi tiết</h4>
                                    <p>Đây là một sản phẩm giày cao cấp được thiết kế với sự chú trọng đến từng chi tiết nhỏ
                                        nhất. Chất liệu da thật được tuyển chọn kỹ lưỡng, mang lại độ bền và vẻ đẹp sang
                                        trọng.</p>
                                    <p>Thiết kế hiện đại, phù hợp với xu hướng thời trang hiện tại. Đế giày được làm từ cao
                                        su chất lượng cao, có khả năng chống trượt tốt và mang lại cảm giác thoải mái khi di
                                        chuyển.</p>
                                    <p>Sản phẩm có nhiều màu sắc và kích thước khác nhau để phù hợp với nhu cầu đa dạng của
                                        khách hàng. Đây là lựa chọn hoàn hảo cho cả công việc và giải trí.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="product-review-content">
                                    <div class="review-content-header">
                                        <h3>Đánh giá của khách hàng</h3>
                                        <div class="review-info">
                                            <ul class="review-rating">
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star-o"></li>
                                            </ul>
                                            <span class="review-caption">Dựa trên {{ rand(5, 15) }} đánh giá</span>
                                            <span class="review-write-btn">Viết đánh giá</span>
                                        </div>
                                    </div>

                                    <!--== Start Reviews List ==-->
                                    <div class="reviews-list">
                                        @for ($i = 1; $i <= 3; $i++)
                                            <div class="review-item">
                                                <div class="review-author">
                                                    <h6>{{ ['Anh Minh', 'Chị Hoa', 'Anh Tuấn'][$i - 1] }}</h6>
                                                    <span
                                                        class="review-date">{{ now()->subDays($i * 5)->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="review-rating">
                                                    @for ($j = 1; $j <= 5; $j++)
                                                        <i class="fa fa-star{{ $j > 4 ? '-o' : '' }}"></i>
                                                    @endfor
                                                </div>
                                                <p>{{ ['Chất lượng giày rất tốt, đi rất êm chân và phong cách. Tôi rất hài lòng với sản phẩm này.', 'Giao hàng nhanh, đóng gói cẩn thận. Giày đúng như mô tả, chất lượng tốt.', 'Thiết kế đẹp, phù hợp với nhiều trang phục khác nhau. Sẽ mua thêm.'][$i - 1] }}
                                                </p>
                                            </div>
                                        @endfor
                                    </div>
                                    <!--== End Reviews List ==-->

                                    <!--== Start Reviews Form ==-->
                                    <div class="reviews-form-area">
                                        <h4 class="title">Viết đánh giá</h4>
                                        <div class="reviews-form-content">
                                            <form action="#" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tên của bạn <span>*</span></label>
                                                            <input class="form-control" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Email <span>*</span></label>
                                                            <input class="form-control" type="email" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Đánh giá của bạn <span>*</span></label>
                                                            <div class="review-rating-input">
                                                                <input type="radio" name="rating" value="5"
                                                                    id="star5">
                                                                <label for="star5">5 sao</label>
                                                                <input type="radio" name="rating" value="4"
                                                                    id="star4">
                                                                <label for="star4">4 sao</label>
                                                                <input type="radio" name="rating" value="3"
                                                                    id="star3">
                                                                <label for="star3">3 sao</label>
                                                                <input type="radio" name="rating" value="2"
                                                                    id="star2">
                                                                <label for="star2">2 sao</label>
                                                                <input type="radio" name="rating" value="1"
                                                                    id="star1">
                                                                <label for="star1">1 sao</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Nội dung đánh giá <span>*</span></label>
                                                            <textarea class="form-control" rows="6" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn-theme" type="submit">Gửi đánh giá</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--== End Reviews Form ==-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Single Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-related-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="title">Sản phẩm liên quan</h3>
                        <div class="desc">
                            <p>Những sản phẩm tương tự bạn có thể quan tâm</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($relatedProducts as $relatedProduct)
                    <div class="col-sm-6 col-lg-3">
                        <!--== Start Product Item ==-->
                        <div class="product-item">
                            <div class="inner-content">
                                <div class="product-thumb">
                                    <a href="{{ route('product.show', $relatedProduct->id) }}">
                                        @if ($relatedProduct->getFirstMediaUrl('product-images'))
                                            <img src="{{ $relatedProduct->getFirstMediaUrl('product-images') }}"
                                                width="270" height="274" alt="{{ $relatedProduct->name }}">
                                        @else
                                            <img src="{{ asset('img/shop/1.webp') }}" width="270" height="274"
                                                alt="{{ $relatedProduct->name }}">
                                        @endif
                                    </a>
                                    @if ($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->price)
                                        <div class="product-flag">
                                            <ul>
                                                <li class="discount">
                                                    -{{ round((($relatedProduct->old_price - $relatedProduct->price) / $relatedProduct->old_price) * 100) }}%
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="product-action">
                                        <x-wishlist-button :product="$relatedProduct" class="btn-product-wishlist" />
                                        <a class="btn-product-cart" href="{{ route('cart') }}"
                                            title="{{ __('home.add_to_cart') }}"><i class="fa fa-shopping-cart"></i></a>
                                        <button type="button" class="btn-product-quick-view-open"
                                            title="{{ __('home.quick_view') }}">
                                            <i class="fa fa-arrows"></i>
                                        </button>
                                        <a class="btn-product-compare" href="{{ route('compare') }}"
                                            title="{{ __('home.compare') }}"><i class="fa fa-random"></i></a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    @if ($relatedProduct->categories->count() > 0)
                                        <div class="category">
                                            <ul>
                                                <li><a
                                                        href="{{ route('shop') }}">{{ $relatedProduct->categories->first()->name }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    <h4 class="title"><a
                                            href="{{ route('product.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                                    </h4>
                                    <div class="prices">
                                        @if ($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->price)
                                            <span class="price-old">{{ number_format($relatedProduct->old_price) }}
                                                VNĐ</span>
                                            <span class="price">{{ number_format($relatedProduct->price) }} VNĐ</span>
                                        @else
                                            <span class="price">{{ number_format($relatedProduct->price) }} VNĐ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--== End Product Item ==-->
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Chưa có sản phẩm liên quan nào.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/wishlist-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-wishlist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/wishlist.js') }}"></script>
    <script src="{{ asset('js/shop.js') }}"></script>
    <!-- Custom Zoom JavaScript -->
    <script>
        // Define zoom function in global scope so it can be called from anywhere
        function initializeCustomZoom() {
            // Remove existing event handlers to prevent duplicates
            $('.custom-zoom-container').off('mouseenter.customZoom mouseleave.customZoom mousemove.customZoom');

            $('.custom-zoom-container').each(function() {
                const $container = $(this);
                const $image = $container.find('.zoom-image');
                const $lens = $container.find('.zoom-lens');
                const $magnifier = $container.find('.zoom-magnifier');
                const $magnifierImg = $magnifier.find('img');

                // Verify all required elements exist
                if ($image.length === 0 || $lens.length === 0 || $magnifier.length === 0 || $magnifierImg.length ===
                    0) {
                    return; // Skip if elements are missing
                }

                // Configuration constants (match CSS values)
                const LENS_SIZE = 100; // Adjusted for better visibility
                const MAGNIFIER_SIZE = 350; // Match CSS
                const ZOOM_LEVEL = 3; // Higher zoom for better detail

                // Mouse enter - show zoom elements
                $container.on('mouseenter.customZoom', function() {
                    // Ensure magnifier image source matches the current image
                    const imageSrc = $image.attr('src');
                    if ($magnifierImg.attr('src') !== imageSrc) {
                        $magnifierImg.attr('src', imageSrc);
                    }

                    $lens.css({
                        'opacity': '1',
                        'visibility': 'visible'
                    });
                    $magnifier.css({
                        'opacity': '1',
                        'visibility': 'visible',
                        'transform': 'scale(1)'
                    });
                    // Hide the overlay hint
                    $container.find('.zoom-overlay').addClass('zoom-active');
                });

                // Mouse leave - hide zoom elements
                $container.on('mouseleave.customZoom', function() {
                    $lens.css({
                        'opacity': '0',
                        'visibility': 'hidden'
                    });
                    $magnifier.css({
                        'opacity': '0',
                        'visibility': 'hidden',
                        'transform': 'scale(0.8)'
                    });
                    // Show the overlay hint again
                    $container.find('.zoom-overlay').removeClass('zoom-active');
                });

                // Mouse move - update zoom position
                $container.on('mousemove.customZoom', function(e) {
                    // Get container dimensions and position
                    const containerOffset = $container.offset();
                    const containerWidth = $container.outerWidth();
                    const containerHeight = $container.outerHeight();

                    // Calculate mouse position relative to container
                    const mouseX = e.pageX - containerOffset.left;
                    const mouseY = e.pageY - containerOffset.top;

                    // Prevent lens from going outside container
                    let lensX = mouseX - (LENS_SIZE / 2);
                    let lensY = mouseY - (LENS_SIZE / 2);

                    // Keep lens within container bounds
                    lensX = Math.max(0, Math.min(lensX, containerWidth - LENS_SIZE));
                    lensY = Math.max(0, Math.min(lensY, containerHeight - LENS_SIZE));

                    // Update lens position
                    $lens.css({
                        left: lensX + 'px',
                        top: lensY + 'px',
                        width: LENS_SIZE + 'px',
                        height: LENS_SIZE + 'px'
                    });

                    // Calculate position as percentage
                    const percentX = (mouseX / containerWidth);
                    const percentY = (mouseY / containerHeight);

                    // Get image dimensions
                    const imgWidth = $image.width();
                    const imgHeight = $image.height();

                    // Calculate zoomed image dimensions
                    const zoomedWidth = imgWidth * ZOOM_LEVEL;
                    const zoomedHeight = imgHeight * ZOOM_LEVEL;

                    // Calculate position for magnifier image
                    // The formula ensures the center of lens area is shown in magnifier center
                    const offsetX = -percentX * (zoomedWidth - MAGNIFIER_SIZE);
                    const offsetY = -percentY * (zoomedHeight - MAGNIFIER_SIZE);

                    // Update magnifier image
                    $magnifierImg.css({
                        'width': zoomedWidth + 'px',
                        'height': zoomedHeight + 'px',
                        'left': offsetX + 'px',
                        'top': offsetY + 'px'
                    });
                });
            });
        }

        $(document).ready(function() {
            console.log('🚀 Document ready - Product page initialized');

            // Color selection functionality
            $('.color-list li').on('click', function() {
                // Remove active class from all color items
                $('.color-list li').removeClass('active');
                // Add active class to clicked item
                $(this).addClass('active');

                // Get selected color info
                const colorCode = $(this).data('bg-color');
                const colorName = $(this).data('color-name');

                console.log('Selected color:', colorName, colorCode);

                // You can add logic here to update product images based on color
                // or show selected color information
            });

            // Size selection functionality
            $('.size-list li').on('click', function() {
                // Remove active class from all size items
                $('.size-list li').removeClass('active');
                // Add active class to clicked item
                $(this).addClass('active');

                // Get selected size info
                const selectedSize = $(this).data('size') || $(this).text();

                console.log('Selected size:', selectedSize);

                // You can add logic here to check stock availability for selected size
                // or update pricing based on size
            });

            // Quantity increase/decrease buttons
            $('.qtybtn').on('click', function() {
                var $input = $(this).siblings('.quantity-input');
                var currentVal = parseInt($input.val()) || 1;
                var maxVal = parseInt($input.attr('max')) || 100;
                var minVal = parseInt($input.attr('min')) || 1;

                if ($(this).hasClass('inc')) {
                    if (currentVal < maxVal) {
                        $input.val(currentVal + 1);
                    }
                } else {
                    if (currentVal > minVal) {
                        $input.val(currentVal - 1);
                    }
                }
            });

            // Validate quantity input
            $('#product-quantity').on('change', function() {
                var val = parseInt($(this).val()) || 1;
                var max = parseInt($(this).attr('max')) || 100;
                var min = parseInt($(this).attr('min')) || 1;

                if (val > max) $(this).val(max);
                if (val < min) $(this).val(min);
            });

            // Add to cart with quantity, color, and size
            $('.product-quick-action .add-to-cart').on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const productId = button.data('product-id');
                const productName = button.data('product-name');
                const productPrice = button.data('product-price');
                const quantity = parseInt($('#product-quantity').val()) || 1;

                // Get selected color and size
                const selectedColor = $('.color-list li.active').data('color-name') || null;
                const selectedColorCode = $('.color-list li.active').data('bg-color') || null;
                const selectedSize = $('.size-list li.active').data('size') || $('.size-list li.active').text() || null;

                // Validate selection if colors/sizes are available
                if ($('.color-list').length > 0 && !selectedColor) {
                    showNotification('error', 'Vui lòng chọn màu sắc');
                    return;
                }

                if ($('.size-list').length > 0 && !selectedSize) {
                    showNotification('error', 'Vui lòng chọn kích thước');
                    return;
                }

                // Disable button and show loading
                button.prop('disabled', true);
                const originalHtml = button.html();
                button.html('<i class="fa fa-spinner fa-spin me-2"></i>Adding...');

                // AJAX request to add product to cart
                $.ajax({
                    url: '/cart/add',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        color: selectedColor,
                        color_code: selectedColorCode,
                        size: selectedSize,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            showNotification('success',
                                `${productName} (x${quantity}) đã được thêm vào giỏ hàng!`);

                            // Update cart count in header if exists
                            if (response.cart_count) {
                                $('.cart-count, .header-cart-count').text(response.cart_count);
                            }

                            // Reset to 1 after adding
                            $('#product-quantity').val(1);

                            // Show success state
                            button.html('<i class="fa fa-check me-2"></i>Đã thêm!');
                            button.addClass('btn-success');

                            // Reset button after 2 seconds
                            setTimeout(() => {
                                button.html(originalHtml);
                                button.removeClass('btn-success');
                                button.prop('disabled', false);
                            }, 2000);
                        } else {
                            showNotification('error', response.message ||
                                'Không thể thêm sản phẩm vào giỏ hàng');
                            button.html(originalHtml);
                            button.prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        console.error('Cart Error:', xhr);
                        let message = 'Không thể thêm sản phẩm vào giỏ hàng';

                        if (xhr.status === 401) {
                            message = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng';
                        }

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        showNotification('error', message);
                        button.html(originalHtml);
                        button.prop('disabled', false);
                    }
                });
            });

            // Show notification function
            function showNotification(type, message) {
                // Remove existing notifications
                $('.product-notification').remove();

                // Create notification element
                const notification = $(`
            <div class="product-notification alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show" role="alert">
                <i class="fa fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);

                // Insert at top of product info
                $('.product-single-info').prepend(notification);

                // Auto hide after 5 seconds
                setTimeout(() => {
                    notification.fadeOut(() => {
                        notification.remove();
                    });
                }, 5000);
            }

            // Enhanced Image Zoom with Fancybox
            $('[data-fancybox="gallery"]').fancybox({
                loop: true,
                keyboard: true,
                arrows: true,
                infobar: true,
                thumbs: {
                    autoStart: true,
                    hideOnClose: true
                },
                buttons: [
                    "zoom",
                    "slideShow",
                    "thumbs",
                    "close"
                ],
                animationEffect: "fade",
                animationDuration: 300,
                transitionEffect: "slide",
                transitionDuration: 300,
                caption: function(instance, item) {
                    // Get caption from data-caption attribute or element's caption
                    return item.opts.caption || $(item.opts.$orig).data('caption') || '';
                },
                beforeLoad: function(instance, current) {
                    // Add loading spinner
                    $('.zoom-overlay').append('<i class="fa fa-spinner fa-spin zoom-loading"></i>');
                },
                afterLoad: function(instance, current) {
                    // Remove loading spinner
                    $('.zoom-loading').remove();
                }
            });

            // Preload images for better performance
            function preloadImages() {
                $('.zoom-image img').each(function() {
                    const img = new Image();
                    img.src = $(this).attr('src');
                });
            }

            // Call preload on page load
            preloadImages();

            // Add keyboard navigation for product images
            $(document).keydown(function(e) {
                if (!$.fancybox.getInstance()) {
                    if (e.keyCode === 37) { // Left arrow
                        $('.single-product-thumb-slider .swiper-button-prev').click();
                    } else if (e.keyCode === 39) { // Right arrow
                        $('.single-product-thumb-slider .swiper-button-next').click();
                    }
                }
            });

            // Touch/swipe support for mobile
            let startX = 0;
            let startY = 0;

            $('.zoom-image').on('touchstart', function(e) {
                startX = e.originalEvent.touches[0].clientX;
                startY = e.originalEvent.touches[0].clientY;
            });

            $('.zoom-image').on('touchend', function(e) {
                if (!startX || !startY) return;

                let endX = e.originalEvent.changedTouches[0].clientX;
                let endY = e.originalEvent.changedTouches[0].clientY;

                let diffX = startX - endX;
                let diffY = startY - endY;

                // If swipe is more horizontal than vertical and significant
                if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                    if (diffX > 0) {
                        // Swipe left - next image
                        $('.single-product-thumb-slider .swiper-button-next').click();
                    } else {
                        // Swipe right - previous image
                        $('.single-product-thumb-slider .swiper-button-prev').click();
                    }
                }

                // Reset values
                startX = 0;
                startY = 0;
            });

            // Wait for images to load before initializing zoom
            function waitForImagesToLoad(callback) {
                const images = $('.zoom-image');
                let loadedCount = 0;
                const totalImages = images.length;

                if (totalImages === 0) {
                    callback();
                    return;
                }

                images.each(function() {
                    const img = $(this)[0];
                    if (img.complete) {
                        loadedCount++;
                        if (loadedCount === totalImages) {
                            callback();
                        }
                    } else {
                        $(img).on('load error', function() {
                            loadedCount++;
                            if (loadedCount === totalImages) {
                                callback();
                            }
                        });
                    }
                });
            }

            // Initialize zoom multiple times with different strategies
            function setupZoom() {
                console.log('🔍 Setting up zoom functionality');

                // Strategy 1: Initialize immediately
                initializeCustomZoom();

                // Strategy 2: Wait for images to load
                waitForImagesToLoad(function() {
                    console.log('✅ All images loaded, initializing zoom');
                    setTimeout(initializeCustomZoom, 100);
                });

                // Strategy 3: Multiple delayed initializations
                setTimeout(initializeCustomZoom, 300);
                setTimeout(initializeCustomZoom, 600);
                setTimeout(initializeCustomZoom, 1000);
                setTimeout(initializeCustomZoom, 2000);
            }

            // Start setup immediately
            setupZoom();

            // Re-initialize when swiper slides change
            if ($('.single-product-thumb-slider').length > 0) {
                // Function to setup swiper event listeners
                function setupSwiperEvents() {
                    const swiperElement = $('.single-product-thumb-slider')[0];
                    if (swiperElement && swiperElement.swiper) {
                        console.log('✅ Swiper found, attaching event listeners');

                        // On slide change
                        swiperElement.swiper.on('slideChange', function() {
                            console.log('📸 Slide changed to index:', this.activeIndex);
                            setTimeout(initializeCustomZoom, 50);
                            setTimeout(initializeCustomZoom, 150);
                            setTimeout(initializeCustomZoom, 300);
                        });

                        // On slide transition end
                        swiperElement.swiper.on('slideChangeTransitionEnd', function() {
                            console.log('✨ Slide transition ended');
                            initializeCustomZoom();
                        });

                        return true;
                    }
                    return false;
                }

                // Try to setup swiper events with multiple attempts
                let attempts = 0;
                const maxAttempts = 10;
                const attemptInterval = setInterval(function() {
                    attempts++;
                    console.log(`🔄 Attempt ${attempts} to find Swiper...`);

                    if (setupSwiperEvents() || attempts >= maxAttempts) {
                        clearInterval(attemptInterval);
                        if (attempts >= maxAttempts) {
                            console.warn('⚠️ Could not find Swiper after', maxAttempts, 'attempts');
                        }
                    }
                }, 200);
            }

            // Show hint animation on page load for active slide
            setTimeout(function() {
                const $activeOverlay = $(
                    '.swiper-slide-active .zoom-overlay, .swiper-slide:first .zoom-overlay').first();
                if ($activeOverlay.length) {
                    $activeOverlay.addClass('hint-animation');
                    setTimeout(function() {
                        $activeOverlay.removeClass('hint-animation');
                    }, 2000);
                }
            }, 2000);
        });

        // Also initialize on window load (after all resources loaded)
        $(window).on('load', function() {
            console.log('🎯 Window loaded - Reinitializing zoom');
            setTimeout(initializeCustomZoom, 100);
            setTimeout(initializeCustomZoom, 500);
        });
    </script>
    <style>
        .product-notification {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-theme.btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-theme:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ElevateZoom Container Styles */
        .zoom-container {
            position: relative;
            display: block;
            overflow: visible;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .zoom-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: crosshair;
        }

        .zoom-container:hover .zoom-image {
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.2);
        }

        .lightbox-link {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10;
            cursor: zoom-in;
            pointer-events: none;
        }

        .zoom-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            color: white;
            pointer-events: auto;
            border-radius: 8px;
        }

        .zoom-overlay i {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .zoom-overlay span {
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            padding: 0 10px;
        }

        .zoom-container:hover .zoom-overlay:not(.zoom-active) {
            opacity: 1;
        }

        .zoom-overlay.zoom-active {
            opacity: 0 !important;
        }

        /* ElevateZoom Window Customization */
        .zoomWindow {
            border: 3px solid #007bff !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 123, 255, 0.3) !important;
            z-index: 1000 !important;
            background: #fff !important;
        }

        .zoomWindow:before {
            content: 'Zoom x10';
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .zoomLens {
            border: 2px solid #007bff !important;
            background-color: rgba(0, 123, 255, 0.15) !important;
            cursor: crosshair !important;
        }

        /* Loading animation for zoom */
        .zoomContainer {
            position: relative;
        }

        .zoomContainer.loading:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #007bff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Fancybox customization */
        .fancybox-slide {
            padding: 0;
        }

        .fancybox-content {
            border-radius: 8px;
            overflow: hidden;
        }

        .fancybox-caption {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            font-size: 16px;
            padding: 20px;
        }

        /* Product thumbnail nav improvements */
        .single-product-nav .swiper-slide {
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .single-product-nav .swiper-slide:hover {
            border-color: #007bff;
            transform: scale(1.05);
        }

        .single-product-nav .swiper-slide.swiper-slide-thumb-active {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .single-product-nav .swiper-slide img {
            transition: all 0.3s ease;
        }

        /* Loading spinner for image zoom */
        .zoom-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 20px;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .zoom-overlay {
                opacity: 1;
                background: rgba(0, 0, 0, 0.3);
            }

            .zoom-overlay span {
                font-size: 12px;
            }

            .zoom-overlay i {
                font-size: 20px;
            }
        }

        /* Enhanced Quantity Input Styling */
        .product-quick-action {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 25px 0;
        }

        .qty-wrap {
            flex-shrink: 0;
        }

        .add-to-cart {
            flex: 1;
            min-width: 200px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-to-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        /* Remove any duplicate qty-btn elements if they exist */
        .qty-btn {
            display: none !important;
        }

        @media (max-width: 576px) {
            .product-quick-action {
                flex-direction: column;
                gap: 10px;
            }

            .add-to-cart {
                width: 100%;
            }
        }
    </style>
@endpush
