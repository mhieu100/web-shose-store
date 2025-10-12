@extends('layouts.frontend')

@section('title', 'So sánh sản phẩm - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">So sánh sản phẩm</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>So sánh</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Compare Area ==-->
    <section class="compare-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="compare-table-wrap">
              <div class="compare-table table-responsive">
                <table class="table">
                  <tbody>
                    <tr class="compare-remove">
                      <th>Xóa</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <a href="#" class="remove-compare"><i class="fa fa-trash"></i></a>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-thumbnail">
                      <th>Hình ảnh</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <a href="{{ route('product.show', $i) }}">
                          <img src="{{ asset('img/shop/' . $i . '.webp') }}" width="200" height="200" alt="Sản phẩm {{ $i }}">
                        </a>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-title">
                      <th>Tên sản phẩm</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <h5><a href="{{ route('product.show', $i) }}">{{ ['Giày da nam cao cấp', 'Giày thể thao Nike', 'Giày boot cổ cao'][$i-1] }}</a></h5>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-rating">
                      <th>Đánh giá</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <div class="rating">
                          @for($j = 1; $j <= 5; $j++)
                            <i class="fa fa-star{{ $j > (4 + $i % 2) ? '-o' : '' }}"></i>
                          @endfor
                        </div>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-price">
                      <th>Giá</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <span class="price">{{ number_format(rand(1500000, 2800000)) }} VNĐ</span>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-description">
                      <th>Mô tả</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <p>{{ ['Giày da thật cao cấp, thiết kế sang trọng, phù hợp cho công việc và dự tiệc.', 'Giày thể thao hiện đại, êm ái, phù hợp cho hoạt động thể thao và đi bộ hàng ngày.', 'Giày boot cổ cao, phong cách cá tính, thích hợp cho mùa đông và phong cách street.'][$i-1] }}</p>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-stock">
                      <th>Tình trạng</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <span class="stock-status in-stock">Còn hàng</span>
                      </td>
                      @endfor
                    </tr>
                    <tr class="compare-addcart">
                      <th>Thêm vào giỏ</th>
                      @for($i = 1; $i <= 3; $i++)
                      <td>
                        <a href="{{ route('cart') }}" class="btn-compare-cart">Thêm vào giỏ</a>
                      </td>
                      @endfor
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="compare-action">
                <a href="{{ route('shop') }}" class="btn-compare-continue">Tiếp tục mua sắm</a>
                <button type="submit" class="btn-compare-clear">Xóa tất cả</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Compare Area ==-->
</main>
@endsection