@extends('layouts.frontend')

@section('title', 'Cửa hàng Right Sidebar - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
  <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
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
    <section class="product-area product-default-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-9 order-lg-first">
            <div class="row">
              <div class="col-12">
                <div class="shop-top-bar">
                  <div class="shop-top-left">
                    <p class="pagination-line"><a href="{{ route('shop') }}">12</a> Sản phẩm được tìm thấy</p>
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
                      @for($i = 1; $i <= 12; $i++)
                      <div class="col-sm-6 col-lg-4">
                        <!--== Start Product Item ==-->
                        <div class="product-item">
                          <div class="inner-content">
                            <div class="product-thumb">
                              <a href="{{ route('product.show', $i) }}">
                                <img src="{{ asset('img/shop/' . (($i - 1) % 8 + 1) . '.webp') }}" width="270" height="274" alt="Image-HasTech">
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
                                  <i class="fa fa-expand"></i>
                                </button>
                                <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
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
                      <div class="col-12">
                        <div class="pagination-items">
                          <ul class="pagination justify-content-end mb--0">
                            <li><a class="active" href="{{ route('shop.right-sidebar') }}">1</a></li>
                            <li><a href="{{ route('shop.four-columns') }}">2</a></li>
                            <li><a href="{{ route('shop.three-columns') }}">3</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                    <div class="row">
                      @for($i = 1; $i <= 6; $i++)
                      <div class="col-md-12">
                        <!--== Start Product Item ==-->
                        <div class="product-item product-list-item">
                          <div class="inner-content">
                            <div class="product-thumb">
                              <a href="{{ route('product.show', $i) }}">
                                <img src="{{ asset('img/shop/list-' . $i . '.webp') }}" width="322" height="360" alt="Image-HasTech">
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
                                  <i class="fa fa-expand"></i>
                                </button>
                                <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
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
                              <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da nam cao cấp', 'Giày thể thao Nike', 'Giày boot cổ cao', 'Giày thông minh hiện đại', 'Giày nam primitive', 'Giày slip-on da'][$i-1] }}</a></h4>
                              <div class="prices">
                                @if($i % 3 == 0)
                                  <span class="price-old">{{ number_format(rand(2500000, 3500000)) }} VNĐ</span>
                                  <span class="sep">-</span>
                                @endif
                                <span class="price">{{ number_format(rand(1500000, 2400000)) }} VNĐ</span>
                              </div>
                              <p>Sản phẩm chất lượng cao với thiết kế hiện đại, phù hợp cho nhiều hoạt động khác nhau. Chất liệu bền đẹp, thoải mái khi sử dụng.</p>
                              <a class="btn-theme btn-sm" href="{{ route('cart') }}">Thêm vào giỏ</a>
                            </div>
                          </div>
                        </div>
                        <!--== End Product Item ==-->
                      </div>
                      @endfor
                      <div class="col-12">
                        <div class="pagination-items">
                          <ul class="pagination justify-content-end mb--0">
                            <li><a class="active" href="{{ route('shop.right-sidebar') }}">1</a></li>
                            <li><a href="{{ route('shop.four-columns') }}">2</a></li>
                            <li><a href="{{ route('shop.three-columns') }}">3</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3">
            <div class="shop-sidebar">
              <div class="shop-sidebar-category">
                <h4 class="sidebar-title">Danh mục hàng đầu</h4>
                <div class="sidebar-category">
                  <ul class="category-list mb--0">
                    <li><a href="{{ route('shop') }}">Giày <span>({{ rand(20, 50) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày thể thao <span>({{ rand(15, 30) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày cao gót <span>({{ rand(10, 25) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày boot <span>({{ rand(8, 20) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Giày da thật <span>({{ rand(12, 28) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Phụ kiện <span>({{ rand(5, 15) }})</span></a></li>
                  </ul>
                </div>
              </div>

              <div class="shop-sidebar-price-range">
                <h4 class="sidebar-title">Lọc theo giá</h4>
                <div class="sidebar-price-range">
                  <div id="price-range"></div>
                </div>
              </div>

              <div class="shop-sidebar-color">
                <h4 class="sidebar-title">Màu sắc</h4>
                <div class="sidebar-color">
                  <ul class="color-list">
                    <li data-bg-color="#39ed8c" class="active"></li>
                    <li data-bg-color="#a6ed42"></li>
                    <li data-bg-color="#daed39"></li>
                    <li data-bg-color="#eed739"></li>
                    <li data-bg-color="#eca23a"></li>
                    <li data-bg-color="#f36768"></li>
                    <li data-bg-color="#e14755"></li>
                    <li data-bg-color="#dc83a3"></li>
                    <li data-bg-color="#dc82da"></li>
                    <li data-bg-color="#9a82dd"></li>
                    <li data-bg-color="#82c2db"></li>
                    <li data-bg-color="#6bd6b0"></li>
                    <li data-bg-color="#9ed76b"></li>
                    <li data-bg-color="#c8c289"></li>
                  </ul>
                </div>
              </div>

              <div class="shop-sidebar-size">
                <h4 class="sidebar-title">Kích cỡ</h4>
                <div class="sidebar-size">
                  <ul class="size-list">
                    <li><a href="{{ route('shop') }}">38 <span>({{ rand(5, 15) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">39 <span>({{ rand(8, 18) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">40 <span>({{ rand(10, 20) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">41 <span>({{ rand(12, 22) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">42 <span>({{ rand(8, 16) }})</span></a></li>
                  </ul>
                </div>
              </div>

              <div class="shop-sidebar-brand">
                <h4 class="sidebar-title">Thương hiệu</h4>
                <div class="sidebar-brand">
                  <ul class="brand-list mb--0">
                    <li><a href="{{ route('shop') }}">Nike <span>({{ rand(15, 30) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Adidas <span>({{ rand(10, 25) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Converse <span>({{ rand(8, 20) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Vans <span>({{ rand(12, 22) }})</span></a></li>
                    <li><a href="{{ route('shop') }}">Puma <span>({{ rand(6, 18) }})</span></a></li>
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
