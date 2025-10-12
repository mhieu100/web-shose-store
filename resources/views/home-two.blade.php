@extends('layouts.frontend')

@section('title', 'Trang chủ 2 - Cửa hàng giày online')
@section('description', 'Cửa hàng giày online phong cách mới với thiết kế hiện đại')

@section('content')
<main class="main-content">
    <!--== Start Hero Area Wrapper ==-->
    <section class="home-slider-area home-slider-two-area">
      <div class="swiper-container home-slider-container default-slider-container">
        <div class="swiper-wrapper home-slider-wrapper slider-default">
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

    <!--== Start Product Category Area ==-->
    <section class="product-category-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Danh mục sản phẩm</h3>
              <div class="desc">
                <p>Lựa chọn theo từng danh mục phù hợp với phong cách của bạn</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <!--== Start Category Item ==-->
            <div class="category-item" data-aos="fade-up" data-aos-duration="1000">
              <div class="category-thumb-wrap">
                <a href="{{ route('shop') }}">
                  <img src="{{ asset('img/shop/category/1.webp') }}" width="270" height="320" alt="Giày thể thao">
                </a>
              </div>
              <div class="category-content">
                <h5 class="title"><a href="{{ route('shop') }}">Giày thể thao</a></h5>
                <p class="count">120+ sản phẩm</p>
              </div>
            </div>
            <!--== End Category Item ==-->
          </div>
          <div class="col-md-6 col-lg-3">
            <!--== Start Category Item ==-->
            <div class="category-item" data-aos="fade-up" data-aos-duration="1200">
              <div class="category-thumb-wrap">
                <a href="{{ route('shop') }}">
                  <img src="{{ asset('img/shop/category/2.webp') }}" width="270" height="320" alt="Giày cao gót">
                </a>
              </div>
              <div class="category-content">
                <h5 class="title"><a href="{{ route('shop') }}">Giày cao gót</a></h5>
                <p class="count">85+ sản phẩm</p>
              </div>
            </div>
            <!--== End Category Item ==-->
          </div>
          <div class="col-md-6 col-lg-3">
            <!--== Start Category Item ==-->
            <div class="category-item" data-aos="fade-up" data-aos-duration="1400">
              <div class="category-thumb-wrap">
                <a href="{{ route('shop') }}">
                  <img src="{{ asset('img/shop/category/3.webp') }}" width="270" height="320" alt="Giày boot">
                </a>
              </div>
              <div class="category-content">
                <h5 class="title"><a href="{{ route('shop') }}">Giày boot</a></h5>
                <p class="count">95+ sản phẩm</p>
              </div>
            </div>
            <!--== End Category Item ==-->
          </div>
          <div class="col-md-6 col-lg-3">
            <!--== Start Category Item ==-->
            <div class="category-item" data-aos="fade-up" data-aos-duration="1600">
              <div class="category-thumb-wrap">
                <a href="{{ route('shop') }}">
                  <img src="{{ asset('img/shop/1.webp') }}" width="270" height="320" alt="Giày công sở">
                </a>
              </div>
              <div class="category-content">
                <h5 class="title"><a href="{{ route('shop') }}">Giày công sở</a></h5>
                <p class="count">150+ sản phẩm</p>
              </div>
            </div>
            <!--== End Category Item ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Category Area ==-->

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
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab">Tất cả</button>
                <button class="nav-link" id="men-tab" data-bs-toggle="tab" data-bs-target="#men-tab-pane" type="button" role="tab">Giày nam</button>
                <button class="nav-link" id="women-tab" data-bs-toggle="tab" data-bs-target="#women-tab-pane" type="button" role="tab">Giày nữ</button>
                <button class="nav-link" id="kids-tab" data-bs-toggle="tab" data-bs-target="#kids-tab-pane" type="button" role="tab">Giày trẻ em</button>
              </nav>
            </div>
          </div>
        </div>
        <!--== End Product Tab Menu ==-->

        <!--== Start Product Tab Content ==-->
        <div class="row">
          <div class="col-12">
            <div class="tab-content product-tab-content" id="product-tabContent">
              <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel">
                <div class="row">
                  @for($i = 1; $i <= 8; $i++)
                  <div class="col-sm-6 col-lg-3">
                    <!--== Start Product Item ==-->
                    <div class="product-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($i * 100) }}">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', $i) }}">
                            <img src="{{ asset('img/shop/' . $i . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                          </a>
                          @if($i % 3 == 0)
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-{{ rand(15, 35) }}%</li>
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
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Thời trang' }}</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày sneaker classic', 'Giày boot cổ cao', 'Giày oxford thanh lịch', 'Giày running professional', 'Giày loafer sang trọng', 'Giày high heel elegant', 'Giày canvas casual', 'Giày dress formal'][$i-1] }}</a></h4>
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