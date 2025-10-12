@extends('layouts.frontend')

@section('title', 'Kết quả tìm kiếm - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Kết quả tìm kiếm</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Tìm kiếm: "{{ request('q') }}"</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area shop-product-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="shop-product-content">
              <div class="row">
                <div class="col-12">
                  <div class="section-title text-center">
                    <h3 class="title">Kết quả tìm kiếm cho "{{ request('q') }}"</h3>
                    <div class="desc">
                      <p>Tìm thấy {{ rand(8, 20) }} sản phẩm phù hợp</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                @for($i = 1; $i <= 8; $i++)
                <div class="col-sm-6 col-lg-3">
                  <div class="product-item">
                    <div class="inner-content">
                      <div class="product-thumb">
                        <a href="{{ route('product.show', $i) }}">
                          <img src="{{ asset('img/shop/' . $i . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                        </a>
                        @if($i % 3 == 0)
                        <div class="product-flag">
                          <ul>
                            <li class="discount">-{{ rand(5, 25) }}%</li>
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
                        <h4 class="title"><a href="{{ route('product.show', $i) }}">Kết quả tìm kiếm {{ $i }}</a></h4>
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
                </div>
                @endfor
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->
</main>
@endsection