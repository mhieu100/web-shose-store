@extends('layouts.frontend')

@section('title', 'Cửa hàng - Shoe Store')
@section('description', 'Khám phá bộ sưu tập giày đa dạng với chất lượng cao')

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
                      <p class="pagination-line"><a href="{{ route('shop') }}">{{ rand(20, 50) }}</a> Product Found of <a href="{{ route('shop') }}">{{ rand(100, 200) }}</a></p>
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
                        <span>Sắp xếp :</span>
                        <select class="form-select" aria-label="Sort select example">
                          <option selected>Mặc định</option>
                          <option value="1">Phổ biến</option>
                          <option value="2">Đánh giá cao</option>
                          <option value="3">Mới nhất</option>
                          <option value="4">Giá thấp đến cao</option>
                        </select>
                      </div>
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
                  <div class="product-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($i * 100) }}">
                    <div class="inner-content">
                      <div class="product-thumb">
                        <a href="{{ route('product.show', $i) }}">
                          <img src="{{ asset('img/shop/' . (($i - 1) % 8 + 1) . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                          <img class="second-image" src="{{ asset('img/shop/' . (($i % 8) + 1) . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                        </a>
                        @if($i % 3 == 0)
                        <div class="product-flag">
                          <ul>
                            <li class="discount">-{{ rand(10, 30) }}%</li>
                          </ul>
                        </div>
                        @endif
                        @if($i % 5 == 0)
                        <div class="product-flag">
                          <ul>
                            <li class="new">Mới</li>
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
                </div>
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
          </div>
          <div class="col-xl-3">
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
                      <li><a href="{{ route('shop') }}">Giày sandal <span>({{ rand(20, 40) }})</span></a></li>
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
                <h4 class="sidebar-title">Kích thước</h4>
                <div class="sidebar-body">
                  <div class="sidebar-size">
                    <ul class="size-list">
                      <li><a href="#">35</a></li>
                      <li><a href="#">36</a></li>
                      <li><a href="#">37</a></li>
                      <li><a href="#">38</a></li>
                      <li><a href="#">39</a></li>
                      <li><a href="#">40</a></li>
                      <li><a href="#">41</a></li>
                      <li><a href="#">42</a></li>
                      <li><a href="#">43</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Màu sắc</h4>
                <div class="sidebar-body">
                  <div class="sidebar-color">
                    <ul class="color-list">
                      <li><a href="#" data-bg-color="#000000" title="Đen"></a></li>
                      <li><a href="#" data-bg-color="#ffffff" title="Trắng"></a></li>
                      <li><a href="#" data-bg-color="#8b4513" title="Nâu"></a></li>
                      <li><a href="#" data-bg-color="#ff0000" title="Đỏ"></a></li>
                      <li><a href="#" data-bg-color="#0000ff" title="Xanh dương"></a></li>
                      <li><a href="#" data-bg-color="#808080" title="Xám"></a></li>
                    </ul>
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
                      <li><label><input type="checkbox"> Puma <span>({{ rand(5, 15) }})</span></label></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Sản phẩm bán chạy</h4>
                <div class="sidebar-body">
                  <div class="sidebar-product">
                    @for($i = 1; $i <= 3; $i++)
                    <div class="sidebar-product-item">
                      <div class="sidebar-product-thumb">
                        <a href="{{ route('product.show', $i) }}">
                          <img src="{{ asset('img/shop/product-mini/' . $i . '.webp') }}" width="68" height="84" alt="Sản phẩm">
                        </a>
                      </div>
                      <div class="sidebar-product-content">
                        <h5 class="title"><a href="{{ route('product.show', $i) }}">Sản phẩm bán chạy {{ $i }}</a></h5>
                        <div class="price">{{ number_format(rand(1200000, 2500000)) }} VNĐ</div>
                      </div>
                    </div>
                    @endfor
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
    <!--== End Product Area Wrapper -->
</main>
@endsection