@extends('layouts.frontend')

@section('title', 'Cửa hàng Right Sidebar - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Cửa hàng</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Cửa hàng Right Sidebar</li>
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
          <div class="col-lg-9 order-lg-first">
            <!--== Start Shop Product Content ==-->
            <div class="shop-product-content">
              <div class="row">
                <div class="col-12">
                  <div class="shop-product-wrap">
                    <div class="shop-product-top">
                      <h4 class="title">Hiển thị {{ rand(20, 50) }} trong tổng số {{ rand(100, 200) }} kết quả</h4>
                      <div class="shop-product-top-sidebar">
                        <div class="shop-product-view-mode">
                          <a class="active" href="#"><i class="fa fa-th"></i></a>
                          <a href="#"><i class="fa fa-list"></i></a>
                        </div>
                        <div class="shop-product-short">
                          <select class="form-control">
                            <option>Sắp xếp mặc định</option>
                            <option>Theo tên A-Z</option>
                            <option>Theo tên Z-A</option>
                            <option>Giá thấp đến cao</option>
                            <option>Giá cao đến thấp</option>
                            <option>Mới nhất</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                @for($i = 1; $i <= 12; $i++)
                <div class="col-sm-6 col-lg-4">
                  <!--== Start Product Item ==-->
                  <div class="product-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($i * 100) }}">
                    <div class="inner-content">
                      <div class="product-thumb">
                        <a href="{{ route('product.show', $i) }}">
                          <img src="{{ asset('img/shop/' . (($i - 1) % 8 + 1) . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
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
                      </div>
                      <div class="product-info">
                        <div class="category">
                          <ul>
                            <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                            <li class="sep">/</li>
                            <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Thời trang' }}</a></li>
                          </ul>
                        </div>
                        <h4 class="title"><a href="{{ route('product.show', $i) }}">Sản phẩm thời trang {{ $i }}</a></h4>
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
              
              <!--== Start Pagination ==-->
              <div class="row">
                <div class="col-12">
                  <nav class="pagination-area">
                    <ul class="page-numbers">
                      <li><a class="page-number prev" href="#">Trước</a></li>
                      <li><a class="page-number active" href="#">1</a></li>
                      <li><a class="page-number" href="#">2</a></li>
                      <li><a class="page-number" href="#">3</a></li>
                      <li><a class="page-number next" href="#">Sau</a></li>
                    </ul>
                  </nav>
                </div>
              </div>
              <!--== End Pagination ==-->
            </div>
            <!--== End Shop Product Content ==-->
          </div>
          <div class="col-lg-3">
            <!--== Start Sidebar Area ==-->
            <div class="sidebar-area shop-sidebar-area">
              
              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Danh mục</h4>
                <div class="sidebar-body">
                  <div class="sidebar-category">
                    <ul class="category-list">
                      <li><a href="{{ route('shop') }}">Giày nam <span>({{ rand(20, 50) }})</span></a></li>
                      <li><a href="{{ route('shop') }}">Giày nữ <span>({{ rand(30, 60) }})</span></a></li>
                      <li><a href="{{ route('shop') }}">Giày thể thao <span>({{ rand(25, 45) }})</span></a></li>
                      <li><a href="{{ route('shop') }}">Giày cao gót <span>({{ rand(15, 35) }})</span></a></li>
                      <li><a href="{{ route('shop') }}">Giày boot <span>({{ rand(10, 25) }})</span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Lọc theo giá</h4>
                <div class="sidebar-body">
                  <div class="sidebar-price">
                    <div class="price-filter">
                      <div id="slider-range"></div>
                      <div class="price-slider-amount">
                        <input type="text" id="amount" readonly>
                        <button type="submit">Lọc</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Thương hiệu</h4>
                <div class="sidebar-body">
                  <div class="sidebar-brand">
                    <ul class="brand-list">
                      <li><label><input type="checkbox"> Nike <span>({{ rand(15, 30) }})</span></label></li>
                      <li><label><input type="checkbox"> Adidas <span>({{ rand(10, 25) }})</span></label></li>
                      <li><label><input type="checkbox"> Converse <span>({{ rand(8, 20) }})</span></label></li>
                      <li><label><input type="checkbox"> Vans <span>({{ rand(12, 22) }})</span></label></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

            </div>
            <!--== End Sidebar Area ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->
</main>
@endsection