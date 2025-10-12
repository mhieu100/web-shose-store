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

    <!--== Start Shopping Compare Area Wrapper ==-->
    <section class="shopping-compare-area">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="shopping-compare-form table-responsive">

              <table class="table">
                <tbody>
                  <tr>
                    <th class="fz-13">Thông tin sản phẩm</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td>
                      <div class="product-remove">
                        <a href="#/"><i class="fa fa-times"></i>Xóa</a>
                      </div>
                      <div class="product-thumb">
                        <a href="{{ route('product.show', $i) }}">
                          <img src="{{ asset('img/shop/product-mini/' . $i . '.webp') }}" width="90" height="110" alt="Image-HasTech">
                        </a>
                      </div>
                      <div class="product-name">
                        <h4 class="title"><a href="{{ route('product.show', $i) }}">{{ ['Giày da nam cao cấp', 'Giày thể thao Nike', 'Giày boot cổ cao'][$i-1] }}</a></h4>
                      </div>
                      <a href="{{ route('cart') }}" class="btn-cart">Thêm vào giỏ</a>
                    </td>
                    @endfor
                  </tr>

                  <tr>
                    <th>Giá</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td class="price">{{ number_format(rand(1500000, 2800000)) }} VNĐ</td>
                    @endfor
                  </tr>

                  <tr>
                    <th>Mã sản phẩm</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td class="product-sku">SP-{{ 790 + $i }}</td>
                    @endfor
                  </tr>

                  <tr>
                    <th>Mô tả</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td class="product-desc">{{ ['Giày da thật cao cấp, thiết kế sang trọng, phù hợp cho công việc và dự tiệc.', 'Giày thể thao hiện đại, êm ái, phù hợp cho hoạt động thể thao và đi bộ hàng ngày.', 'Giày boot cổ cao, phong cách cá tính, thích hợp cho mùa đông và phong cách street.'][$i-1] }}</td>
                    @endfor
                  </tr>

                  <tr>
                    <th>Tình trạng</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td><span class="product-stock">Còn hàng</span></td>
                    @endfor
                  </tr>

                  <tr>
                    <th>Khối lượng</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td class="product-weight">{{ rand(300, 600) }}g</td>
                    @endfor
                  </tr>

                  <tr>
                    <th>Kích thước</th>
                    @for($i = 1; $i <= 3; $i++)
                    <td class="product-dimensions">{{ ['26 x 15 x 10 cm', '28 x 16 x 11 cm', '27 x 15.5 x 12 cm'][$i-1] }}</td>
                    @endfor
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Shopping Compare Area Wrapper ==-->
</main>
@endsection