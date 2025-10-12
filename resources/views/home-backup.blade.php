@extends('layouts.frontend')

@section('title', 'Trang chủ - Cửa hàng giày online')
@section('description', 'Cửa hàng giày online chất lượng cao với nhiều mẫu mã đa dạng, giá cả hợp lý')

@section('content')
<main class="main-content">
    <!--== Start Hero Area Wrapper ==-->
    <section class="home-slider-area">
      <div class="swiper-container home-slider-container default-slider-container">
        <div class="swiper-wrapper home-slider-wrapper slider-default">
          <div class="swiper-slide">
            <div class="slider-content-area" data-bg-img="{{ asset('img/shape/1.webp') }}">
              <div class="container">
                <div class="slider-container">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6 col-md-5">
                      <div class="slider-content">
                        <div class="content">
                          <div class="title-box">
                            <h2 class="title">Giày mới độc quyền</h2>
                          </div>
                          <div class="desc-box">
                            <p class="desc">Giảm giá lên đến 30% cho tất cả giày & sản phẩm</p>
                          </div>
                          <div class="btn-box">
                            <a class="btn-slider" href="{{ route('shop') }}">Mua ngay</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="slider-thumb">
                        <div class="thumb scene">
                          <span class="scene-layer" data-depth=".3"><img src="{{ asset('img/slider/slider-01.webp') }}" width="461" height="489" alt="Shoe Image"></span>
                        </div>
                        <div class="shape-group mousemove">
                          <div class="shape-group-one mousemove-layer" data-speed=".8" data-bg-img="{{ asset('img/shape/2.webp') }}"></div>
                          <div class="shape-group-two scene"><span class="scene-layer" data-depth=".6"><img src="{{ asset('img/shape/3.webp') }}" width="471" height="462" alt="Shape"></span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <h2 class="slider-text-shape">NEW 2024</h2>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="slider-content-area" data-bg-img="{{ asset('img/shape/1.webp') }}">
              <div class="container">
                <div class="slider-container">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6 col-md-5">
                      <div class="slider-content">
                        <div class="content">
                          <div class="title-box">
                            <h2 class="title">Bộ sưu tập mới</h2>
                          </div>
                          <div class="desc-box">
                            <p class="desc">Khuyến mãi đặc biệt cho khách hàng thân thiết</p>
                          </div>
                          <div class="btn-box">
                            <a class="btn-slider" href="{{ route('shop') }}">Khám phá</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="slider-thumb">
                        <div class="thumb scene">
                          <span class="scene-layer" data-depth=".3"><img src="{{ asset('img/slider/slider-03.webp') }}" width="548" height="649" alt="Shoe Image"></span>
                        </div>
                        <div class="shape-group mousemove">
                          <div class="shape-group-one mousemove-layer" data-speed=".8" data-bg-img="{{ asset('img/shape/2.webp') }}"></div>
                          <div class="shape-group-two scene"><span class="scene-layer" data-depth=".6"><img src="{{ asset('img/shape/3.webp') }}" width="471" height="462" alt="Shape"></span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <h2 class="slider-text-shape">SALE 2024</h2>
            </div>
          </div>
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
      </div>
    </section>
    <!--== End Hero Area Wrapper ==-->

    <!--== Start Product Collection Area Wrapper ==-->
    <section class="product-area product-collection-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <!--== Start Product Collection Item ==-->
            <div class="product-collection">
              <div class="inner-content">
                <div class="product-collection-content">
                  <div class="content">
                    <h3 class="title"><a href="{{ route('shop') }}">Giày thể thao</a></h3>
                    <h4 class="price">Từ 2.000.000 VNĐ</h4>
                  </div>
                </div>
                <div class="product-collection-thumb" data-bg-img="{{ asset('img/shop/collection/1.webp') }}"></div>
                <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
              </div>
            </div>
            <!--== End Product Collection Item ==-->
          </div>
          <div class="col-lg-4 col-md-6">
            <!--== Start Product Collection Item ==-->
            <div class="product-collection">
              <div class="inner-content">
                <div class="product-collection-content">
                  <div class="content">
                    <h3 class="title"><a href="{{ route('shop') }}">Giày mới nhất</a></h3>
                    <h4 class="price">Từ 1.800.000 VNĐ</h4>
                  </div>
                </div>
                <div class="product-collection-thumb" data-bg-img="{{ asset('img/shop/collection/2.webp') }}"></div>
                <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
              </div>
            </div>
            <!--== End Product Collection Item ==-->
          </div>
          <div class="col-lg-4 col-md-6">
            <!--== Start Product Collection Item ==-->
            <div class="product-collection">
              <div class="inner-content">
                <div class="product-collection-content">
                  <div class="content">
                    <h3 class="title"><a href="{{ route('shop') }}">Giày công sở</a></h3>
                    <h4 class="price">Từ 2.200.000 VNĐ</h4>
                  </div>
                </div>
                <div class="product-collection-thumb" data-bg-img="{{ asset('img/shop/collection/3.webp') }}"></div>
                <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
              </div>
            </div>
            <!--== End Product Collection Item ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Collection Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
      <div class="container pt--0">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Sản phẩm nổi bật</h3>
              <div class="desc">
                <p>Những đôi giày được yêu thích nhất tại cửa hàng của chúng tôi</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @for($i = 1; $i <= 8; $i++)
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', $i) }}">
                    <img src="{{ asset('img/shop/' . $i . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                  </a>
                  @if($i % 3 == 0)
                  <div class="product-flag">
                    <ul>
                      <li class="discount">-{{ rand(10, 30) }}%</li>
                    </ul>
                  </div>
                  @endif
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('product.show', $i) }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Công sở' }}</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da cao cấp', 'Giày thể thao hiện đại', 'Giày công sở lịch lãm', 'Giày sneaker trẻ trung', 'Giày boot cá tính', 'Giày cao gót sang trọng', 'Giày sandal thoải mái', 'Giày oxford thanh lịch'][$i-1] }}</a></h4>
                  <div class="prices">
                    @if($i % 3 == 0)
                      <span class="price-old">{{ number_format(rand(2500000, 3500000)) }} VNĐ</span>
                      <span class="sep">-</span>
                    @endif
                    <span class="price">{{ number_format(rand(1500000, 2400000)) }} VNĐ</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          @endfor
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
              <h4 class="sub-title">Tiết kiệm 50%</h4>
              <h2 class="title">Toàn bộ cửa hàng Online</h2>
              <p class="desc">Ưu đãi áp dụng cho tất cả giày và sản phẩm</p>
              <a class="btn-theme" href="{{ route('shop') }}">Mua ngay</a>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-layer-wrap">
        <div class="bg-layer-style z-index--1 parallax" data-speed="1.05" data-bg-img="{{ asset('img/photos/bg1.webp') }}"></div>
      </div>
    </section>
    <!--== End Divider Area Wrapper -->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-best-seller-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Bán chạy nhất</h3>
              <div class="desc">
                <p>Những sản phẩm được khách hàng yêu thích và mua nhiều nhất</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="product-slider-wrap">
              <div class="swiper-container product-slider-col4-container">
                <div class="swiper-wrapper">
                  @for($i = 1; $i <= 6; $i++)
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', $i) }}">
                            <img src="{{ asset('img/shop/' . $i . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                          </a>
                          @if($i % 2 == 0)
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-{{ rand(10, 25) }}%</li>
                            </ul>
                          </div>
                          @endif
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('product.show', $i) }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Thời trang' }}</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày thông minh hiện đại', 'Giày nam Quickiin', 'Giày nữ Rexpo', 'Giày da cao cấp', 'Giày nam nguyên bản', 'Giày nữ cao gót mới'][$i-1] }}</a></h4>
                          <div class="prices">
                            @if($i % 2 == 0)
                              <span class="price-old">{{ number_format(rand(3000000, 4000000)) }} VNĐ</span>
                              <span class="sep">-</span>
                            @endif
                            <span class="price">{{ number_format(rand(2000000, 2800000)) }} VNĐ</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  @endfor
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->

    <!--== Start Feature Area Wrapper ==-->
    <section class="feature-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <!--== Start Feature Item ==-->
            <div class="feature-item">
              <div class="feature-icon">
                <img src="{{ asset('img/icons/1.webp') }}" width="65" height="65" alt="Icon">
              </div>
              <div class="feature-content">
                <h4 class="title">Miễn phí vận chuyển</h4>
                <p class="desc">Miễn phí vận chuyển toàn quốc cho đơn hàng trên 500.000đ</p>
              </div>
            </div>
            <!--== End Feature Item ==-->
          </div>
          <div class="col-lg-4 col-md-6">
            <!--== Start Feature Item ==-->
            <div class="feature-item">
              <div class="feature-icon">
                <img src="{{ asset('img/icons/2.webp') }}" width="65" height="65" alt="Icon">
              </div>
              <div class="feature-content">
                <h4 class="title">Hỗ trợ 24/7</h4>
                <p class="desc">Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn</p>
              </div>
            </div>
            <!--== End Feature Item ==-->
          </div>
          <div class="col-lg-4 col-md-6">
            <!--== Start Feature Item ==-->
            <div class="feature-item">
              <div class="feature-icon">
                <img src="{{ asset('img/icons/3.webp') }}" width="65" height="65" alt="Icon">
              </div>
              <div class="feature-content">
                <h4 class="title">Đổi trả dễ dàng</h4>
                <p class="desc">Chính sách đổi trả trong vòng 30 ngày không điều kiện</p>
              </div>
            </div>
            <!--== End Feature Item ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Feature Area Wrapper ==-->
</main>
@endsection