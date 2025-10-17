@extends('layouts.frontend')

@section('title', 'Cửa hàng 4 cột - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Cửa hàng</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Cửa hàng 4 cột</li>
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
        <div class="row">
          <div class="col-12">
            <div class="shop-top-bar">
              <div class="shop-top-left">
                <p class="pagination-line"><a href="{{ route('shop') }}">16</a> Sản phẩm được tìm thấy</p>
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
                  <span>Sắp xếp theo :</span>
                  <select class="form-select" aria-label="Sort select example">
                    <option selected>Mặc định</option>
                    <option value="1">Phổ biến</option>
                    <option value="2">Đánh giá trung bình</option>
                    <option value="3">Mới nhất</option>
                    <option value="4">Giá thấp đến cao</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                <div class="row">
                  @for($i = 1; $i <= 16; $i++)
                  <div class="col-sm-6 col-xl-3">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', $i) }}">
                            <img src="{{ asset('img/shop/' . (($i - 1) % 8 + 1) . '.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          @if($i % 5 == 0)
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-{{ rand(15, 35) }}%</li>
                            </ul>
                          </div>
                          @endif
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fas fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fas fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Thời trang' }}</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da nam cao cấp', 'Giày thể thao Nike', 'Giày boot cổ cao', 'Giày thông minh hiện đại', 'Giày nam primitive', 'Giày slip-on da', 'Giày vải đơn giản', 'Giày nam primitive'][(($i - 1) % 8)] }}</a></h4>
                          <div class="prices">
                            @if($i % 5 == 0)
                              <span class="price-old">{{ number_format(rand(2800000, 3800000)) }} VNĐ</span>
                              <span class="sep">-</span>
                            @endif
                            <span class="price">{{ number_format(rand(1800000, 2600000)) }} VNĐ</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  @endfor
                  <div class="col-12">
                    <div class="pagination-items">
                      <ul class="pagination justify-content-center mb--0">
                        <li><a href="{{ route('shop.three-columns') }}">1</a></li>
                        <li><a class="active" href="{{ route('shop.four-columns') }}">2</a></li>
                        <li><a href="{{ route('shop') }}">3</a></li>
                      </ul>                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                <div class="row">
                  @for($i = 1; $i <= 8; $i++)
                  <div class="col-md-12">
                    <!--== Start Product Item ==-->
                    <div class="product-item product-list-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', $i) }}">
                            <img src="{{ asset('img/shop/list-' . (($i - 1) % 6 + 1) . '.webp') }}" width="322" height="360" alt="Image-HasTech">
                          </a>
                          @if($i % 3 == 0)
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-{{ rand(15, 35) }}%</li>
                            </ul>
                          </div>
                          @endif
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fas fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fas fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Thời trang' }}</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da nam cao cấp', 'Giày thể thao Nike', 'Giày boot cổ cao', 'Giày thông minh hiện đại', 'Giày nam primitive', 'Giày slip-on da', 'Giày vải đơn giản', 'Giày nam primitive'][(($i - 1) % 8)] }}</a></h4>
                          <div class="prices">
                            @if($i % 3 == 0)
                              <span class="price-old">{{ number_format(rand(2800000, 3800000)) }} VNĐ</span>
                              <span class="sep">-</span>
                            @endif
                            <span class="price">{{ number_format(rand(1800000, 2600000)) }} VNĐ</span>
                          </div>
                          <p class="desc">Sản phẩm chất lượng cao với thiết kế hiện đại, phù hợp cho nhiều hoạt động khác nhau. Chất liệu bền đẹp, thoải mái khi sử dụng.</p>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  @endfor
                  <div class="col-12">
                    <div class="pagination-items">
                      <ul class="pagination justify-content-center mb--0">
                        <li><a href="{{ route('shop.three-columns') }}">1</a></li>
                        <li><a class="active" href="{{ route('shop.four-columns') }}">2</a></li>
                        <li><a href="{{ route('shop') }}">3</a></li>
                      </ul>                    
                    </div>
                  </div>
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