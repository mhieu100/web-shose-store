@extends('layouts.frontend')

@section('title', 'Thanh toán - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Thanh toán</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li><a href="{{ route('cart') }}">Giỏ hàng</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Thanh toán</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Checkout Area Wrapper ==-->
    <section class="checkout-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="coupon-accordion">
              <!--== Start Accordion Item ==-->
              <div class="coupon-content">
                <h3>Bạn đã có mã giảm giá? <span id="showcoupon">Nhấp vào đây để nhập mã</span></h3>
              </div>
              <div id="checkout_coupon" class="coupon-checkout-content">
                <div class="coupon-info">
                  <form action="#" method="post">
                    @csrf
                    <p>Nếu bạn có mã giảm giá, vui lòng nhập ở bên dưới.</p>
                    <input type="text" placeholder="Mã giảm giá" required>
                    <button type="submit">Áp dụng mã giảm giá</button>
                  </form>
                </div>
              </div>
              <!--== End Accordion Item ==-->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-xl-7">
            <div class="checkout-form">
              <form class="checkout-form-list" action="#" method="post">
                @csrf
                <div class="checkout-form-list-wrap">
                  <h3>Thông tin thanh toán</h3>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="checkout-form-list-single">
                        <label>Họ <span class="required">*</span></label>
                        <input type="text" name="first_name" placeholder="Nhập họ" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list-single">
                        <label>Tên <span class="required">*</span></label>
                        <input type="text" name="last_name" placeholder="Nhập tên" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="checkout-form-list-single">
                        <label>Công ty</label>
                        <input type="text" name="company" placeholder="Tên công ty (không bắt buộc)">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="checkout-form-list-single">
                        <label>Tỉnh/Thành phố <span class="required">*</span></label>
                        <div class="checkout-form-list-single-select">
                          <select name="country" class="form-control" required>
                            <option value="">Chọn tỉnh/thành phố</option>
                            <option value="ho-chi-minh">TP. Hồ Chí Minh</option>
                            <option value="ha-noi">Hà Nội</option>
                            <option value="da-nang">Đà Nẵng</option>
                            <option value="can-tho">Cần Thơ</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="checkout-form-list-single">
                        <label>Địa chỉ <span class="required">*</span></label>
                        <input type="text" name="address_1" placeholder="Số nhà, tên đường" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="checkout-form-list-single">
                        <input type="text" name="address_2" placeholder="Phường/Xã, Quận/Huyện (không bắt buộc)">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list-single">
                        <label>Quận/Huyện <span class="required">*</span></label>
                        <input type="text" name="city" placeholder="Nhập quận/huyện" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list-single">
                        <label>Mã bưu điện</label>
                        <input type="text" name="postcode" placeholder="Mã bưu điện">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list-single">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" placeholder="Địa chỉ email" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list-single">
                        <label>Số điện thoại <span class="required">*</span></label>
                        <input type="text" name="phone" placeholder="Số điện thoại" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="checkout-form-list-single">
                        <input type="checkbox" id="create_account">
                        <label for="create_account">Tạo tài khoản?</label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="checkout-form-list-single">
                        <input type="checkbox" id="ship_to_different">
                        <label for="ship_to_different">Giao hàng đến địa chỉ khác?</label>
                      </div>
                    </div>
                  </div>
                  <div class="order-notes">
                    <div class="checkout-form-list-single">
                      <label>Ghi chú đơn hàng</label>
                      <textarea name="order_notes" placeholder="Ghi chú về đơn hàng của bạn, ví dụ: ghi chú đặc biệt cho việc giao hàng."></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6 col-xl-5">
            <div class="checkout-order-wrap">
              <div class="checkout-order-details">
                <h3>Đơn hàng của bạn</h3>
                <div class="checkout-order-details-item">
                  <div class="checkout-order-details-item-list">
                    <h4>Sản phẩm <span>Tổng tiền</span></h4>
                    <ul>
                      <li>Giày da nam cao cấp <strong>× 1</strong> <span>2.500.000 VNĐ</span></li>
                      <li>Giày thể thao năng động <strong>× 2</strong> <span>3.600.000 VNĐ</span></li>
                    </ul>
                  </div>
                  <div class="checkout-order-details-subtotal">
                    <h4>Tạm tính <span>6.100.000 VNĐ</span></h4>
                  </div>
                  <div class="checkout-order-details-shipping">
                    <h4>Phí vận chuyển</h4>
                    <div class="checkout-order-details-shipping-item">
                      <div class="checkout-order-details-shipping-item-list">
                        <label>
                          <input type="radio" name="shipping" value="free" checked>
                          Miễn phí vận chuyển
                        </label>
                        <label>
                          <input type="radio" name="shipping" value="flat">
                          Giao hàng tiêu chuẩn: <span>30.000 VNĐ</span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="checkout-order-details-total">
                    <h4>Tổng cộng <span>6.100.000 VNĐ</span></h4>
                  </div>
                </div>
                <div class="checkout-payment">
                  <h4>Phương thức thanh toán</h4>
                  <div class="checkout-payment-item">
                    <div class="checkout-payment-item-list">
                      <label>
                        <input type="radio" name="payment_method" value="bank_transfer" checked>
                        Chuyển khoản ngân hàng
                      </label>
                      <div class="payment-description">
                        <p>Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng Mã đơn hàng của bạn trong phần Nội dung thanh toán.</p>
                      </div>
                    </div>
                    <div class="checkout-payment-item-list">
                      <label>
                        <input type="radio" name="payment_method" value="cod">
                        Thanh toán khi nhận hàng (COD)
                      </label>
                    </div>
                    <div class="checkout-payment-item-list">
                      <label>
                        <input type="radio" name="payment_method" value="paypal">
                        PayPal
                      </label>
                    </div>
                  </div>
                  <div class="checkout-payment-item-terms">
                    <input type="checkbox" id="accept_terms" required>
                    <label for="accept_terms">Tôi đã đọc và đồng ý với <a href="#">các điều khoản và điều kiện</a> của website <span class="required">*</span></label>
                  </div>
                  <div class="checkout-payment-item-btn">
                    <button type="submit" class="checkout-btn">Đặt hàng</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Checkout Area Wrapper ==-->
</main>
@endsection