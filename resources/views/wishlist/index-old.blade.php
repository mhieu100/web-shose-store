@extends('layouts.frontend')

@section('title', 'Danh sách yêu thích - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Danh sách yêu thích</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Yêu thích</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Wishlist Area ==-->
    <section class="wishlist-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <form class="wishlist-form" action="#" method="post">
              @csrf
              <div class="wishlist-table-wrap">
                <div class="wishlist-table table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="width-thumbnail"></th>
                        <th class="width-name">Sản phẩm</th>
                        <th class="width-price">Giá</th>
                        <th class="width-stock-status">Tình trạng</th>
                        <th class="width-add-cart"></th>
                        <th class="width-remove"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Sample wishlist items -->
                      @for($i = 1; $i <= 3; $i++)
                      <tr class="wishlist-item">
                        <td class="product-thumbnail">
                          <a href="{{ route('product.show', $i) }}">
                            <img src="{{ asset('img/shop/' . $i . '.webp') }}" width="90" height="90" alt="Sản phẩm">
                          </a>
                        </td>
                        <td class="product-name">
                          <h5 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da nam cao cấp', 'Giày thể thao nữ', 'Giày boot phong cách'][$i-1] }}</a></h5>
                        </td>
                        <td class="product-price">
                          <span class="price">{{ number_format(rand(1500000, 2800000)) }} VNĐ</span>
                        </td>
                        <td class="product-stock-status">
                          <span class="stock-status in-stock">Còn hàng</span>
                        </td>
                        <td class="product-add-cart">
                          <a href="{{ route('cart') }}" class="btn-add-cart">Thêm vào giỏ</a>
                        </td>
                        <td class="product-remove">
                          <a href="#" class="remove-wishlist"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      @endfor
                    </tbody>
                  </table>
                </div>
                <div class="row">
                  <div class="col-md-8 col-lg-6">
                    <div class="wishlist-actions">
                      <a class="btn-wishlist-continue" href="{{ route('shop') }}">Tiếp tục mua sắm</a>
                      <button class="btn-wishlist-clear" type="submit">Xóa tất cả</button>
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-6">
                    <div class="wishlist-share">
                      <h5>Chia sẻ danh sách:</h5>
                      <div class="social-share">
                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-email"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!--== End Wishlist Area ==-->
</main>
@endsection