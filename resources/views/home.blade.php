@extends('layouts.frontend')

@section('title', __('home.home') . ' - Cửa hàng giày online')
@section('description', 'Cửa hàng giày online chất lượng cao với đa dạng mẫu mã và thương hiệu nổi tiếng')

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
                <div class="slider-content-area" data-bg-img="{{ $banner->image_url ?? asset('img/slider/slider-02.webp') }}">
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
                                  <a class="btn-slider" href="{{ $banner->link_url }}">Xem ngay</a>
                                </div>
                              @else
                                <div class="btn-box">
                                  <a class="btn-slider" href="{{ route('shop') }}">Khám phá ngay</a>
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
            <!-- Default banners if no banners in database -->
            <div class="swiper-slide">
              <div class="slider-content-area" data-bg-img="{{ asset('img/slider/slider-02.webp') }}">
                <div class="container">
                  <div class="slider-container">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-sm-8 col-md-7">
                        <div class="slider-content text-center">
                          <div class="content">
                            <div class="title-box">
                              <h2 class="title">Bộ sưu tập mới 2024</h2>
                            </div>
                            <div class="desc-box">
                              <p class="desc">Khám phá những mẫu giày thời trang mới nhất với chất lượng cao</p>
                            </div>
                            <div class="btn-box">
                              <a class="btn-slider" href="{{ route('shop') }}">Khám phá ngay</a>
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
              <div class="slider-content-area" data-bg-img="{{ asset('img/slider/slider-04.webp') }}">
                <div class="container">
                  <div class="slider-container">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-sm-8 col-md-7">
                        <div class="slider-content text-center">
                          <div class="content">
                            <div class="title-box">
                              <h2 class="title">Giày cao cấp chính hãng</h2>
                            </div>
                            <div class="desc-box">
                              <p class="desc">Cam kết 100% sản phẩm chính hãng từ các thương hiệu nổi tiếng</p>
                            </div>
                            <div class="btn-box">
                              <a class="btn-slider" href="{{ route('shop') }}">{{ __('home.shop_now') }}</a>
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
    <section class="product-category-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">{{ __('home.popular_brands') }}</h3>
              <div class="desc">
                <p>Khám phá những thương hiệu giày nổi tiếng và được yêu thích nhất</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @if ($brands->count() > 0)
            @foreach ($brands->take(4) as $brand)
              <div class="col-md-6 col-lg-3">
                <!--== Start Brand Item ==-->
                <div class="category-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($loop->index * 200) }}">
                  <div class="category-thumb-wrap">
                    <a href="{{ route('shop') }}?brand={{ $brand->slug ?? $brand->id }}">
                      @if ($brand->getMedia('brand-images')->count() > 0)
                        <img src="{{ $brand->getFirstMediaUrl('brand-images') }}" width="270" height="320" alt="{{ $brand->name }}">
                      @elseif (isset($brand->logo) && $brand->logo)
                        <img src="{{ Storage::disk('public')->url($brand->logo) }}" width="270" height="320" alt="{{ $brand->name }}">
                      @else
                        <img src="{{ asset('img/brands/brand-' . (($loop->index % 4) + 1) . '.webp') }}" width="270" height="320" alt="{{ $brand->name }}">
                      @endif
                    </a>
                  </div>
                  <div class="category-content">
                    <h5 class="title"><a href="{{ route('shop') }}?brand={{ $brand->slug ?? $brand->id }}">{{ $brand->name }}</a></h5>
                    <p class="count">{{ $brand->products_count ?? 0 }}+ sản phẩm</p>
                  </div>
                </div>
                <!--== End Brand Item ==-->
              </div>
            @endforeach
          @else
            <!-- Default brands if no brands in database -->
            <div class="col-md-6 col-lg-3">
              <div class="category-item" data-aos="fade-up" data-aos-duration="1000">
                <div class="category-thumb-wrap">
                  <a href="{{ route('shop') }}">
                    <img src="{{ asset('img/brands/nike.webp') }}" width="270" height="320" alt="Nike">
                  </a>
                </div>
                <div class="category-content">
                  <h5 class="title"><a href="{{ route('shop') }}">Nike</a></h5>
                  <p class="count">150+ sản phẩm</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="category-item" data-aos="fade-up" data-aos-duration="1200">
                <div class="category-thumb-wrap">
                  <a href="{{ route('shop') }}">
                    <img src="{{ asset('img/brands/adidas.webp') }}" width="270" height="320" alt="Adidas">
                  </a>
                </div>
                <div class="category-content">
                  <h5 class="title"><a href="{{ route('shop') }}">Adidas</a></h5>
                  <p class="count">120+ sản phẩm</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="category-item" data-aos="fade-up" data-aos-duration="1400">
                <div class="category-thumb-wrap">
                  <a href="{{ route('shop') }}">
                    <img src="{{ asset('img/brands/converse.webp') }}" width="270" height="320" alt="Converse">
                  </a>
                </div>
                <div class="category-content">
                  <h5 class="title"><a href="{{ route('shop') }}">Converse</a></h5>
                  <p class="count">95+ sản phẩm</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="category-item" data-aos="fade-up" data-aos-duration="1600">
                <div class="category-thumb-wrap">
                  <a href="{{ route('shop') }}">
                    <img src="{{ asset('img/brands/vans.webp') }}" width="270" height="320" alt="Vans">
                  </a>
                </div>
                <div class="category-content">
                  <h5 class="title"><a href="{{ route('shop') }}">Vans</a></h5>
                  <p class="count">80+ sản phẩm</p>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
    <!--== End Product Brand Area ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Sản phẩm mới</h3>
              <div class="desc">
                <p>Những mẫu giày mới nhất vừa được cập nhật tại cửa hàng</p>
              </div>
            </div>
          </div>
        </div>

        <!--== Start Product Tab Menu ==-->
        <div class="row">
          <div class="col-12">
            <div class="product-tab-menu">
              <nav class="nav product-tab-nav" id="product-tab" role="tablist">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">
                  Tất cả
                  <span class="badge">{{ $latestProducts->count() }}</span>
                </button>
                @if ($categories->count() > 0)
                  @foreach ($categories as $category)
                    <button class="nav-link" id="category-{{ $category->id }}-tab" data-bs-toggle="tab" data-bs-target="#category-{{ $category->id }}-tab-pane" type="button" role="tab" aria-controls="category-{{ $category->id }}-tab-pane" aria-selected="false">
                      {{ $category->name }}
                      <span class="badge">{{ isset($categoryProducts[$category->id]) ? $categoryProducts[$category->id]->count() : 0 }}</span>
                    </button>
                  @endforeach
                @else
                  <button class="nav-link" id="men-tab" data-bs-toggle="tab" data-bs-target="#men-tab-pane" type="button" role="tab">Giày nam</button>
                  <button class="nav-link" id="women-tab" data-bs-toggle="tab" data-bs-target="#women-tab-pane" type="button" role="tab">Giày nữ</button>
                  <button class="nav-link" id="kids-tab" data-bs-toggle="tab" data-bs-target="#kids-tab-pane" type="button" role="tab">Giày trẻ em</button>
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
                        <!--== Start Product Item ==-->
                        <div class="product-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($loop->index * 100) }}">
                          <div class="inner-content">
                            <div class="product-thumb">
                              <a href="{{ route('product.show', $product->id) }}">
                                @if ($product->getMedia('product-images')->count() > 0)
                                  <img src="{{ $product->getFirstMediaUrl('product-images') }}" width="270" height="274" alt="{{ $product->name }}">
                                @else
                                  <img src="{{ asset('img/shop/default-product.webp') }}" width="270" height="274" alt="{{ $product->name }}">
                                @endif
                              </a>
                              @if($product->sale_price && $product->sale_price < $product->price)
                              <div class="product-flag">
                                <ul>
                                  <li class="discount">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</li>
                                </ul>
                              </div>
                              @endif
                              <div class="product-action">
                                <a class="btn-product-wishlist" href="{{ route('wishlist') }}" title="{{ __('home.add_to_wishlist') }}"><i class="fa fa-heart"></i></a>
                                <a class="btn-product-cart" href="{{ route('cart') }}" title="{{ __('home.add_to_cart') }}"><i class="fa fa-shopping-cart"></i></a>
                                <button type="button" class="btn-product-quick-view-open" title="{{ __('home.quick_view') }}">
                                  <i class="fa fa-arrows"></i>
                                </button>
                                <a class="btn-product-compare" href="{{ route('compare') }}" title="{{ __('home.compare') }}"><i class="fa fa-random"></i></a>
                              </div>
                            </div>
                            <div class="product-info">
                              <div class="category">
                                <ul>
                                  @if($product->brand)
                                    <li><a href="{{ route('shop') }}?brand={{ $product->brand->slug ?? $product->brand->id }}">{{ $product->brand->name }}</a></li>
                                    @if($product->categories->count() > 0)
                                      <li class="sep">/</li>
                                    @endif
                                  @endif
                                  @if($product->categories->count() > 0)
                                    <li><a href="{{ route('shop') }}?category={{ $product->categories->first()->slug ?? $product->categories->first()->id }}">{{ $product->categories->first()->name }}</a></li>
                                  @endif
                                </ul>
                              </div>
                              <h4 class="title"><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h4>
                              <div class="prices">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                  <span class="price-old">{{ number_format($product->price) }} VNĐ</span>
                                  <span class="sep">-</span>
                                  <span class="price">{{ number_format($product->sale_price) }} VNĐ</span>
                                @else
                                  <span class="price">{{ number_format($product->price) }} VNĐ</span>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--== End Product Item ==-->
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
                  <div class="tab-pane fade" id="category-{{ $category->id }}-tab-pane" role="tabpanel">
                    <div class="row">
                      @if (isset($categoryProducts[$category->id]) && $categoryProducts[$category->id]->count() > 0)
                        @foreach ($categoryProducts[$category->id] as $product)
                          <div class="col-sm-6 col-lg-3">
                            <!--== Start Product Item ==-->
                            <div class="product-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($loop->index * 100) }}">
                              <div class="inner-content">
                                <div class="product-thumb">
                                  <a href="{{ route('product.show', $product->id) }}">
                                    @if ($product->getMedia('product-images')->count() > 0)
                                      <img src="{{ $product->getFirstMediaUrl('product-images') }}" width="270" height="274" alt="{{ $product->name }}">
                                    @else
                                      <img src="{{ asset('img/shop/default-product.webp') }}" width="270" height="274" alt="{{ $product->name }}">
                                    @endif
                                  </a>
                                  @if($product->sale_price && $product->sale_price < $product->price)
                                  <div class="product-flag">
                                    <ul>
                                      <li class="discount">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</li>
                                    </ul>
                                  </div>
                                  @endif
                                  <div class="product-action">
                                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}" title="{{ __('home.add_to_wishlist') }}"><i class="fa fa-heart"></i></a>
                                    <a class="btn-product-cart" href="{{ route('cart') }}" title="{{ __('home.add_to_cart') }}"><i class="fa fa-shopping-cart"></i></a>
                                    <button type="button" class="btn-product-quick-view-open" title="{{ __('home.quick_view') }}">
                                      <i class="fa fa-arrows"></i>
                                    </button>
                                    <a class="btn-product-compare" href="{{ route('compare') }}" title="{{ __('home.compare') }}"><i class="fa fa-random"></i></a>
                                  </div>
                                </div>
                                <div class="product-info">
                                  <div class="category">
                                    <ul>
                                      @if($product->brand)
                                        <li><a href="{{ route('shop') }}?brand={{ $product->brand->slug ?? $product->brand->id }}">{{ $product->brand->name }}</a></li>
                                        @if($product->categories->count() > 0)
                                          <li class="sep">/</li>
                                        @endif
                                      @endif
                                      @if($product->categories->count() > 0)
                                        <li><a href="{{ route('shop') }}?category={{ $product->categories->first()->slug ?? $product->categories->first()->id }}">{{ $product->categories->first()->name }}</a></li>
                                      @endif
                                    </ul>
                                  </div>
                                  <h4 class="title"><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h4>
                                  <div class="prices">
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                      <span class="price-old">{{ number_format($product->price) }} VNĐ</span>
                                      <span class="sep">-</span>
                                      <span class="price">{{ number_format($product->sale_price) }} VNĐ</span>
                                    @else
                                      <span class="price">{{ number_format($product->price) }} VNĐ</span>
                                    @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--== End Product Item ==-->
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
                  <img src="{{ asset('img/shop/banner/1.webp') }}" width="570" height="350" alt="Banner">
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
                  <img src="{{ asset('img/shop/banner/2.webp') }}" width="570" height="350" alt="Banner">
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


    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
        <div class="container pt--0">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="title">{{ __('home.featured_products') }}</h3>
                        <div class="desc">
                            <p>Những sản phẩm được đánh giá cao và bán chạy nhất tại cửa hàng</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($featuredProducts->count() > 0)
                    @foreach ($featuredProducts->take(8) as $product)
                        <div class="col-sm-6 col-lg-3">
                            <!--== Start Product Item ==-->
                            <div class="product-item">
                                <div class="inner-content">
                                    <div class="product-thumb">
                                        <a href="{{ route('product.show', $product->id) }}">
                                            @if ($product->getMedia('product-images')->count() > 0)
                                                <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                                                    width="270" height="274" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('img/shop/' . (($loop->index % 8) + 1) . '.webp') }}"
                                                    width="270" height="274" alt="{{ $product->name }}">
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
                                        @if ($product->featured)
                                            <div class="product-flag">
                                                <ul>
                                                    <li class="hot">Nổi bật</li>
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="product-action">
                                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}" title="{{ __('home.add_to_wishlist') }}"><i
                                                    class="fa fa-heart"></i></a>
                                            <a class="btn-product-cart" href="{{ route('cart') }}" title="{{ __('home.add_to_cart') }}"><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <button type="button" class="btn-product-quick-view-open" title="{{ __('home.quick_view') }}">
                                                <i class="fa fa-arrows"></i>
                                            </button>
                                            <a class="btn-product-compare" href="{{ route('compare') }}" title="{{ __('home.compare') }}"><i
                                                    class="fa fa-random"></i></a>
                                        </div>
                                        <a class="banner-link-overlay"
                                            href="{{ route('product.show', $product->id) }}"></a>
                                    </div>
                                    <div class="product-info">
                                        <div class="category">
                                            <ul>
                                                @if ($product->categories->count() > 0)
                                                    @foreach ($product->categories->take(2) as $category)
                                                        <li><a
                                                                href="{{ route('shop') }}?category={{ $category->id }}">{{ $category->name }}</a>
                                                        </li>
                                                        @if (!$loop->last)
                                                            <li class="sep">/</li>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <li><a
                                                            href="{{ route('shop') }}">{{ $product->brand->name ?? 'Sản phẩm' }}</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <h4 class="title"><a
                                                href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="prices">
                                            @if ($product->old_price && $product->old_price > $product->price)
                                                <span class="price-old">{{ number_format($product->old_price) }} VNĐ</span>
                                                <span class="sep">-</span>
                                                <span class="price">{{ number_format($product->price) }} VNĐ</span>
                                            @else
                                                <span class="price">{{ number_format($product->price) }} VNĐ</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--== End Product Item ==-->
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="text-center">{{ __('home.no_featured_products') }}</p>
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->

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
                data-bg-img="{{ asset('img/photos/bg1.webp') }}"></div>
        </div>
    </section>
    <!--== End Divider Area Wrapper ==-->

    <!--== Start Testimonial Area ==-->
    <section class="testimonial-area testimonial-default-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Khách hàng nói gì về chúng tôi</h3>
              <div class="desc">
                <p>Những đánh giá chân thực từ khách hàng đã sử dụng sản phẩm</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="swiper-container testimonial-slider-container">
              <div class="swiper-wrapper">
                @for($i = 1; $i <= 3; $i++)
                <div class="swiper-slide">
                  <!--== Start Testimonial Item ==-->
                  <div class="testimonial-item">
                    <div class="testimonial-content">
                      <div class="testimonial-quote">
                        <p>"{{ ['Chất lượng giày rất tốt, đi rất êm chân và bền. Tôi đã mua nhiều đôi ở đây và luôn hài lòng.', 'Dịch vụ chăm sóc khách hàng tuyệt vời, nhân viên tư vấn nhiệt tình và chu đáo.', 'Giá cả hợp lý, chất lượng cao. Giao hàng nhanh và đóng gói cẩn thận.'][$i-1] }}"</p>
                      </div>
                      <div class="testimonial-author">
                        <div class="author-info">
                          <img src="{{ asset('img/testimonial/' . $i . '.webp') }}" width="60" height="60" alt="Customer">
                          <div class="info">
                            <h5 class="name">{{ ['Anh Minh', 'Chị Hương', 'Anh Tuấn'][$i-1] }}</h5>
                            <p class="designation">{{ ['Khách hàng thân thiết', 'Khách hàng VIP', 'Khách hàng mới'][$i-1] }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--== End Testimonial Item ==-->
                </div>
                @endfor
              </div>

              <!--== Add Swiper Pagination ==-->
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Testimonial Area ==-->
</main>
@endsection
