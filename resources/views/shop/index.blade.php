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
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Cửa hàng</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Cửa hàng</li>
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
                  <div class="shop-top-left">
                    <p class="pagination-line"><a href="{{ route('shop') }}">{{ rand(12, 24) }}</a> Product Found of <a href="{{ route('shop') }}">{{ rand(50, 100) }}</a></p>
                  </div>
                  <div class="shop-top-center">
                    <nav class="product-nav">
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true"><i class="fa fa-th"></i></button>
                        <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list" aria-selected="false"><i class="fa fa-list"></i></button>
                      </div>
                    </nav>
                  </div>
                  <div class="shop-top-right">
                    <div class="shop-sort">
                      <span>Sort By :</span>
                      <select class="form-select" aria-label="Sort select example">
                        <option selected>Default</option>
                        <option value="1">Popularity</option>
                        <option value="2">Average Rating</option>
                        <option value="3">Newsness</option>
                        <option value="4">Price Low to High</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                    <div class="row">
                      @for($i = 1; $i <= 12; $i++)
                      <div class="col-sm-6 col-lg-4">
                        <!--== Start Product Item ==-->
                        <div class="product-item">
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
                              <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da đen cao cấp', 'Giày thể thao trắng', 'Giày boot da nâu', 'Giày sneaker xanh', 'Giày oxford đen', 'Giày cao gót nude', 'Giày canvas xám', 'Giày running đỏ', 'Giày loafer nâu', 'Giày sandal vàng', 'Giày formal đen', 'Giày casual xanh'][($i-1) % 12] }}</a></h4>
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
                  <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                    <div class="row">
                      @for($i = 1; $i <= 6; $i++)
                      <div class="col-12">
                        <!--== Start Product Item ==-->
                        <div class="product-item product-item-list">
                          <div class="inner-content">
                            <div class="product-thumb">
                              <a href="{{ route('product.show', $i) }}">
                                <img src="{{ asset('img/shop/' . (($i - 1) % 8 + 1) . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                              </a>
                            </div>
                            <div class="product-info">
                              <h4 class="title"><a href="{{ route('product.show', $i) }}">Sản phẩm list view {{ $i }}</a></h4>
                              <div class="prices">
                                <span class="price">{{ number_format(rand(1500000, 2400000)) }} VNĐ</span>
                              </div>
                              <p>Mô tả ngắn về sản phẩm {{ $i }} trong chế độ xem danh sách...</p>
                              <div class="product-action">
                                <a class="btn-product-cart" href="{{ route('cart') }}">Thêm vào giỏ</a>
                                <a class="btn-product-wishlist" href="{{ route('wishlist') }}">Yêu thích</a>
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
          </div>
          <div class="col-xl-3">
            <div class="shop-sidebar">
              <div class="shop-sidebar-category">
                <h4 class="sidebar-title">Top Categories</h4>
                <div class="sidebar-category">
                  <ul class="category-list mb--0">
                    <li><a href="{{ route('shop') }}">Giày thể thao <span>({{ rand(15, 25) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày cao gót <span>({{ rand(10, 20) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày boot <span>({{ rand(8, 15) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày oxford <span>({{ rand(12, 18) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày sneaker <span>({{ rand(20, 30) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày sandal <span>({{ rand(5, 12) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày công sở <span>({{ rand(8, 16) }})</span></a></li>
                  </ul>
                </div>
              </div>

              <div class="shop-sidebar-price-range">
                <h4 class="sidebar-title">Price Filter</h4>
                <div class="sidebar-price-range">   
                  <div id="price-range"></div>
                </div>
              </div>

              <div class="shop-sidebar-color">
                <h4 class="sidebar-title">Color</h4>
                <div class="sidebar-color">
                  <ul class="color-list">
                    <li data-bg-color="#000000" title="Đen"></li>
                    <li data-bg-color="#ffffff" title="Trắng"></li>
                    <li data-bg-color="#8b4513" title="Nâu"></li>
                    <li data-bg-color="#ff0000" title="Đỏ"></li>
                    <li data-bg-color="#0000ff" title="Xanh dương"></li>
                    <li data-bg-color="#008000" title="Xanh lá"></li>
                    <li data-bg-color="#ffff00" title="Vàng"></li>
                    <li data-bg-color="#ffc0cb" title="Hồng"></li>
                    <li data-bg-color="#808080" title="Xám"></li>
                    <li data-bg-color="#800080" title="Tím"></li>
                    <li data-bg-color="#ffa500" title="Cam"></li>
                    <li data-bg-color="#a52a2a" title="Nâu đỏ"></li>
                  </ul>
                </div>
              </div>

              <div class="shop-sidebar-size">
                <h4 class="sidebar-title">Size</h4>
                <div class="sidebar-size">
                  <ul class="size-list">
                    <li><a href="{{ route('shop') }}">35 <span>({{ rand(2, 8) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">36 <span>({{ rand(3, 10) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">37 <span>({{ rand(5, 12) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">38 <span>({{ rand(8, 15) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">39 <span>({{ rand(10, 18) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">40 <span>({{ rand(12, 20) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">41 <span>({{ rand(10, 16) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">42 <span>({{ rand(8, 14) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">43 <span>({{ rand(5, 10) }})</span></a></li>
                  </ul>
                </div>
              </div>

              <div class="shop-sidebar-brand">
                <h4 class="sidebar-title">Brand</h4>
                <div class="sidebar-brand">
                  <ul class="brand-list">
                    <li><a href="{{ route('shop') }}">Nike <span>({{ rand(15, 25) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Adidas <span>({{ rand(12, 22) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Converse <span>({{ rand(8, 18) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Vans <span>({{ rand(10, 20) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Puma <span>({{ rand(6, 16) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">New Balance <span>({{ rand(4, 12) }})</span></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->
</main>
@endsection