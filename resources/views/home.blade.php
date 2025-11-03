@extends('layouts.frontend')

@section('title', __('home.home') . ' - Cửa hàng giày online')
@section('description', 'Cửa hàng giày online chất lượng cao với đa dạng mẫu mã và thương hiệu nổi tiếng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/minimal-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-spacing.css') }}">
@endpush

@section('content')
    @php use Illuminate\Support\Facades\Storage; @endphp
    <main class="main-content">
        <!--== Start Hero Area Wrapper ==-->
        <section class="home-slider-area home-slider-two-area">
            <div class="swiper-container home-slider-container default-slider-container">
                <div class="swiper-wrapper home-slider-wrapper slider-default">
                    @if ($banners->count() > 0)
                        @foreach ($banners as $banner)
                            <div class="swiper-slide">
                                <div class="slider-content-area"
                                    data-bg-img="{{ $banner->image_url ?? asset('img/slider/slider-02.webp') }}">
                                    <div class="container">
                                        <div class="slider-container">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-sm-8 col-md-7">
                                                    <div class="slider-content text-center">
                                                        <div class="content">
                                                            <div class="title-box">
                                                                <h2 class="title">{{ $banner->title }}</h2>
                                                            </div>
                                                            @if ($banner->description)
                                                                <div class="desc-box">
                                                                    <p class="desc">{{ $banner->description }}</p>
                                                                </div>
                                                            @endif
                                                            @if ($banner->link_url)
                                                                <div class="btn-box">
                                                                    <a class="btn-slider" href="{{ $banner->link_url }}">Xem
                                                                        ngay</a>
                                                                </div>
                                                            @else
                                                                <div class="btn-box">
                                                                    <a class="btn-slider" href="{{ route('shop') }}">Khám
                                                                        phá ngay</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                         <div class="swiper-slide">
                            <div class="slider-content-area" data-bg-img="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=1920&q=80">
                                <div class="container">
                                    <div class="slider-container">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-8 col-md-7">
                                                <div class="slider-content text-center">
                                                    <div class="content">
                                                        <div class="title-box">
                                                            <h2 class="title">Bộ sưu tập mới 2025</h2>
                                                        </div>
                                                        <div class="desc-box">
                                                            <p class="desc">Khám phá những mẫu giày thời trang mới nhất
                                                                với chất lượng cao</p>
                                                        </div>
                                                        <div class="btn-box">
                                                            <a class="btn-slider" href="{{ route('shop') }}">Khám phá
                                                                ngay</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-content-area" data-bg-img="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1920&q=80">
                                <div class="container">
                                    <div class="slider-container">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-8 col-md-7">
                                                <div class="slider-content text-center">
                                                    <div class="content">
                                                        <div class="title-box">
                                                            <h2 class="title">Giày thể thao cao cấp</h2>
                                                        </div>
                                                        <div class="desc-box">
                                                            <p class="desc">Cam kết 100% sản phẩm chính hãng từ các thương
                                                                hiệu nổi tiếng</p>
                                                        </div>
                                                        <div class="btn-box">
                                                            <a class="btn-slider"
                                                                href="{{ route('shop') }}">{{ __('home.shop_now') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-content-area" data-bg-img="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=1920&q=80">
                                <div class="container">
                                    <div class="slider-container">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-8 col-md-7">
                                                <div class="slider-content text-center">
                                                    <div class="content">
                                                        <div class="title-box">
                                                            <h2 class="title">Phong cách đường phố</h2>
                                                        </div>
                                                        <div class="desc-box">
                                                            <p class="desc">Nâng tầm phong cách của bạn với những đôi giày
                                                                độc đáo và cá tính</p>
                                                        </div>
                                                        <div class="btn-box">
                                                            <a class="btn-slider" href="{{ route('shop') }}">Mua ngay</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!--== Add Swiper Arrows ==-->
                <div class="swiper-btn-wrap">
                    <div class="swiper-btn-prev">
                        <i class="pe-7s-angle-left"></i>
                    </div>
                    <div class="swiper-btn-next">
                        <i class="pe-7s-angle-right"></i>
                    </div>
                </div>

                <!--== Add Swiper Pagination ==-->
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <!--== End Hero Area Wrapper ==-->

        <!--== Start Product Brand Area ==-->
        @if ($brands && $brands->count() > 0)
            <section class="product-category-area">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title text-center">
                                <h3 class="title text-uppercase">{{ __('home.popular_brands') }}</h3>
                                <div class="desc">
                                    <p>Khám phá những thương hiệu giày nổi tiếng và được yêu thích nhất</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($brands->take(4) as $brand)
                            <div class="col-md-6 col-lg-3">
                                <!--== Start Brand Item ==-->
                                <div class="category-item" data-aos="fade-up"
                                    data-aos-duration="{{ 1000 + $loop->index * 200 }}">
                                    <div class="category-thumb-wrap">
                                        <a href="{{ route('shop') }}?brand={{ $brand->slug ?? $brand->id }}">
                                            @if ($brand->getMedia('brand-images')->count() > 0)
                                                <img src="{{ $brand->getFirstMediaUrl('brand-images') }}" width="270"
                                                    height="320" alt="{{ $brand->name }}">
                                            @elseif (isset($brand->logo) && $brand->logo)
                                                <img src="{{ Storage::disk('public')->url($brand->logo) }}" width="270"
                                                    height="320" alt="{{ $brand->name }}">
                                            @else
                                                <img src="{{ asset('img/shop/placeholder.webp') }}" width="270"
                                                    height="320" alt="{{ $brand->name }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="category-content">
                                        <h5 class="title"><a
                                                href="{{ route('shop') }}?brand={{ $brand->slug ?? $brand->id }}">{{ $brand->name }}</a>
                                        </h5>
                                        <p class="count">{{ $brand->products_count ?? 0 }}+ sản phẩm</p>
                                    </div>
                                </div>
                                <!--== End Brand Item ==-->
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!--== End Product Brand Area ==-->

        <!--== Start Product Area Wrapper ==-->
        <section class="product-area product-default-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title text-uppercase">Sản phẩm mới</h3>
                            <div class="desc">
                                <p>Những mẫu giày mới nhất vừa được cập nhật tại cửa hàng</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!--== Start Product Tab Menu ==-->
                <div class="row">
                    <div class="col-12">
                        <div class="product-tab-menu minimal-tabs">
                            <nav class="nav product-tab-nav" id="product-tab" role="tablist">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                                    data-bs-target="#all-tab-pane" type="button" role="tab"
                                    aria-controls="all-tab-pane" aria-selected="true">
                                    Tất cả
                                    <span class="count">{{ $latestProducts->count() }}</span>
                                </button>
                                @if ($categories->count() > 0)
                                    @foreach ($categories as $category)
                                        <button class="nav-link" id="category-{{ $category->id }}-tab"
                                            data-bs-toggle="tab" data-bs-target="#category-{{ $category->id }}-tab-pane"
                                            type="button" role="tab"
                                            aria-controls="category-{{ $category->id }}-tab-pane" aria-selected="false">
                                            {{ $category->name }}
                                            <span
                                                class="count">{{ isset($categoryProducts[$category->id]) ? $categoryProducts[$category->id]->count() : 0 }}</span>
                                        </button>
                                    @endforeach
                                @else
                                    <button class="nav-link" id="men-tab" data-bs-toggle="tab"
                                        data-bs-target="#men-tab-pane" type="button" role="tab">Giày nam</button>
                                    <button class="nav-link" id="women-tab" data-bs-toggle="tab"
                                        data-bs-target="#women-tab-pane" type="button" role="tab">Giày nữ</button>
                                    <button class="nav-link" id="kids-tab" data-bs-toggle="tab"
                                        data-bs-target="#kids-tab-pane" type="button" role="tab">Giày trẻ
                                        em</button>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
                <!--== End Product Tab Menu ==-->

                <!--== Start Product Tab Content ==-->
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content product-tab-content" id="product-tabContent">
                            <!-- Tab "Tất cả" - hiển thị 8 sản phẩm mới nhất -->
                            <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel">
                                <div class="row">
                                    @if ($latestProducts->count() > 0)
                                        @foreach ($latestProducts as $product)
                                            <div class="col-sm-6 col-lg-3">
                                                <x-product-card
                                                    :product="$product"
                                                    :aos-delay="$loop->index * 100" />
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <p class="text-center">Chưa có sản phẩm nào.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Tabs cho các danh mục -->
                            @if ($categories->count() > 0)
                                @foreach ($categories as $category)
                                    <div class="tab-pane fade" id="category-{{ $category->id }}-tab-pane"
                                        role="tabpanel">
                                        <div class="row">
                                            @if (isset($categoryProducts[$category->id]) && $categoryProducts[$category->id]->count() > 0)
                                                @foreach ($categoryProducts[$category->id] as $product)
                                                    <div class="col-sm-6 col-lg-3">
                                                        <x-product-card
                                                            :product="$product"
                                                            :aos-delay="$loop->index * 100" />
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12">
                                                    <p class="text-center">Chưa có sản phẩm nào trong danh mục này.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!--== End Product Tab Content ==-->
            </div>
        </section>
        <!--== End Product Area Wrapper ==-->

        <!--== Start Banner Area ==-->
        <section class="banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <!--== Start Banner Item ==-->
                        <div class="banner-item" data-aos="fade-right" data-aos-duration="1000">
                            <div class="banner-thumb">
                                <a href="{{ route('shop') }}">
                                    <img src="https://i.lfi.media/is/image/LaCrosse/danner_homepage_feature_wheatridge_1025?wid=900&hei=1000"
                                        width="570" height="350" alt="Banner">
                                </a>
                            </div>
                            <div class="banner-content">
                                <h4 class="title">Bộ sưu tập nam</h4>
                                <h3 class="price">Từ 1.200.000 VNĐ</h3>
                                <a class="btn-banner" href="{{ route('shop') }}">Xem ngay</a>
                            </div>
                        </div>
                        <!--== End Banner Item ==-->
                    </div>
                    <div class="col-lg-6">
                        <!--== Start Banner Item ==-->
                        <div class="banner-item" data-aos="fade-left" data-aos-duration="1000">
                            <div class="banner-thumb">
                                <a href="{{ route('shop') }}">
                                    <img src="https://i.lfi.media/is/image/LaCrosse/danner_homepage_feature_clearance_0925?wid=900&hei=1000"
                                        width="570" height="350" alt="Banner">
                                </a>
                            </div>
                            <div class="banner-content">
                                <h4 class="title">Bộ sưu tập nữ</h4>
                                <h3 class="price">Từ 1.500.000 VNĐ</h3>
                                <a class="btn-banner" href="{{ route('shop') }}">Xem ngay</a>
                            </div>
                        </div>
                        <!--== End Banner Item ==-->
                    </div>
                </div>
            </div>
        </section>
        <!--== End Banner Area ==-->


        <!--== Start Featured Products Carousel ==-->
        <section class="product-area product-default-area featured-products-section">
            <div class="container pt--0">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h3 class="title text-uppercase">{{ __('home.featured_products') }}</h3>
                            <div class="desc">
                                <p>Những sản phẩm được đánh giá cao và bán chạy nhất tại cửa hàng</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($featuredProducts->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="swiper-container featured-products-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($featuredProducts as $product)
                                        <div class="swiper-slide">
                                            <x-product-card
                                                :product="$product"
                                                :show-actions="true"
                                                :aos-animation="'none'" />
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add Navigation -->
                                <div class="swiper-btn-wrap">
                                    <div class="swiper-btn-prev featured-prev">
                                        <i class="pe-7s-angle-left"></i>
                                    </div>
                                    <div class="swiper-btn-next featured-next">
                                        <i class="pe-7s-angle-right"></i>
                                    </div>
                                </div>

                                <!-- Add Pagination -->
                                <div class="swiper-pagination featured-pagination"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">{{ __('home.no_featured_products') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!--== End Featured Products Carousel ==-->

        <!--== Start Divider Area Wrapper ==-->
        <section class="bg-color-f2 position-relative z-index-1">
            <div class="container pt--0 pb--0">
                <div class="row divider-wrap divider-style1">
                    <div class="col-lg-6">
                        <div class="divider-content" data-title="MỚI">
                            <h4 class="sub-title">Giảm giá đến 50%</h4>
                            <h2 class="title">Toàn bộ cửa hàng online</h2>
                            <p class="desc">Ưu đãi áp dụng cho tất cả giày dép & sản phẩm</p>
                            <a class="btn-theme" href="{{ route('shop') }}">{{ __('home.shop_now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-layer-wrap">
                <div class="bg-layer-style z-index--1 parallax" data-speed="1.05"
                    data-bg-img="https://i.lfi.media/is/image/LaCrosse/danner_homepage_feature_eastwood_0925_desktop?wid=1728&hei=1152">
                </div>
            </div>
        </section>
        <!--== End Divider Area Wrapper ==-->


    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/wishlist-shared.css') }}">
    <style>
        /* Hero Slider Height Enhancement */
        .home-slider-area .slider-content-area {
            min-height: 600px;
            height: 80vh;
            display: flex;
            align-items: center;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .home-slider-area .slider-content-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .home-slider-area .slider-container {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .home-slider-area .slider-content {
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .home-slider-area .title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .home-slider-area .desc {
            font-size: 18px;
            margin-bottom: 30px;
            color: #ffffff;
        }

        .home-slider-area .btn-slider {
            background: #ffffff;
            color: #000000;
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .home-slider-area .btn-slider:hover {
            background: #ff0000;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .home-slider-area .slider-content-area {
                min-height: 500px;
                height: 70vh;
            }

            .home-slider-area .title {
                font-size: 36px;
            }

            .home-slider-area .desc {
                font-size: 16px;
            }
        }

        @media (max-width: 767px) {
            .home-slider-area .slider-content-area {
                min-height: 400px;
                height: 60vh;
            }

            .home-slider-area .title {
                font-size: 28px;
            }

            .home-slider-area .desc {
                font-size: 14px;
            }

            .home-slider-area .btn-slider {
                padding: 10px 30px;
                font-size: 14px;
            }
        }

        /* Featured Products Carousel Styles */
        .featured-products-slider {
            position: relative;
            padding: 0 50px;
            margin: 0 -15px;
        }

        .featured-products-slider .swiper-slide {
            padding: 0 15px;
        }

        .featured-products-slider .swiper-btn-wrap {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            z-index: 10;
            pointer-events: none;
        }

        .featured-products-slider .swiper-btn-prev,
        .featured-products-slider .swiper-btn-next {
            position: absolute;
            top: -50%;
            width: 40px;
            height: 40px;
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            pointer-events: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .featured-products-slider .swiper-btn-prev {
            left: 0;
        }

        .featured-products-slider .swiper-btn-next {
            right: 0;
        }

        .featured-products-slider .swiper-btn-prev:hover,
        .featured-products-slider .swiper-btn-next:hover {
            background: #007bff;
            color: #ffffff;
            border-color: #007bff;
        }

        .featured-products-slider .swiper-btn-prev i,
        .featured-products-slider .swiper-btn-next i {
            font-size: 16px;
        }

        .featured-products-slider .swiper-pagination {
            position: static;
            margin-top: 30px;
            text-align: center;
        }

        .featured-products-slider .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #dee2e6;
            opacity: 1;
            margin: 0 4px;
        }

        .featured-products-slider .swiper-pagination-bullet-active {
            background: #007bff;
        }

        /* Featured Products Section Spacing */
        .featured-products-section {
            margin-top: 50px;
        }

        @media (min-width: 992px) {
            .featured-products-section {
                margin-top: 80px;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .featured-products-slider {
                padding: 0 30px;
            }

            .featured-products-slider .swiper-btn-prev,
            .featured-products-slider .swiper-btn-next {
                width: 35px;
                height: 35px;
            }

            .featured-products-slider .swiper-btn-prev i,
            .featured-products-slider .swiper-btn-next i {
                font-size: 14px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/wishlist.js') }}"></script>
@endpush

@push('scripts')
    <script src="{{ asset('js/shop.js') }}"></script>
    <script>
        // Initialize Featured Products Carousel
        document.addEventListener('DOMContentLoaded', function() {
            const featuredProductsSlider = new Swiper('.featured-products-slider', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.featured-next',
                    prevEl: '.featured-prev',
                },
                pagination: {
                    el: '.featured-pagination',
                    clickable: true,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    992: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    }
                }
            });
        });
    </script>
@endpush
