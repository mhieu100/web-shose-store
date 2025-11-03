@extends('layouts.frontend')

@section('title', 'Thanh Toán')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
    ['label' => 'Giỏ hàng', 'url' => route('cart.index'), 'icon' => 'shopping-cart'],
    ['label' => 'Thanh toán', 'icon' => 'credit-card', 'active' => true]
]" />

<!--== Start Page Header Area Wrapper ==-->
<div class="page-header-area" data-bg-img="{{ asset('img/bg/page-header.jpg') }}">
    <div class="container pt--0 pb--0">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content">
                    <h2 class="title" data-aos="fade-down" data-aos-duration="1000" style="color: #eb3e32;">Thanh Toán</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--== End Page Header Area Wrapper ==-->

<!--== Start Shopping Checkout Area ==-->
<section class="shopping-checkout-area checkout-page">
    <div class="container">
        @if ($errors->any())
            <input type="hidden" id="validation-errors" value="{{ json_encode($errors->all()) }}">
        @endif

        @if ($cartItems && $cartItems->count() > 0)
            <div class="row">
                <!-- Order Review Section -->
                <div class="col-md-12">
                    <div class="shopping-cart-form table-responsive mb-4">
                        <div class="section-title-cart mb-3">
                            <h5 class="title">Review Your Order</h5>
                        </div>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th class="product-thumb">&nbsp;</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr class="cart-product-item">
                                        <td class="product-thumb">
                                            @if ($item->product->getFirstMediaUrl('product-images'))
                                                <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                                    width="60" height="75"
                                                    alt="{{ $item->product->name }}">
                                            @else
                                                <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                    width="60" height="75"
                                                    alt="{{ $item->product->name }}">
                                            @endif
                                        </td>
                                        <td class="product-name">
                                            <h6 class="title mb-1">{{ $item->product->name }}</h6>
                                            @if ($item->color || $item->size)
                                                <div class="product-variants">
                                                    @if ($item->color)
                                                        <small class="text-muted">Color: {{ $item->color }}</small><br>
                                                    @endif
                                                    @if ($item->size)
                                                        <small class="text-muted">Size: {{ $item->size }}</small>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="product-price">
                                            <span class="price">{{ number_format($item->price, 0, ',', '.') }}₫</span>
                                        </td>
                                        <td class="product-quantity">
                                            <span class="quantity">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="price">
                                                {{ number_format($item->quantity * $item->price, 0, ',', '.') }}₫
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row row-gutter-50">
                <!-- Left Column - Checkout Form -->
                <div class="col-lg-8">
                    <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <!-- Customer Information Section -->
                        <div class="shipping-form-cart-totals mb-4">
                            <div class="section-title-cart">
                                <h5 class="title">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Thông Tin Khách Hàng
                                </h5>
                            </div>
                            <div class="checkout-form-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullname" class="form-label">
                                                Họ và Tên <span class="required text-danger">*</span>
                                            </label>
                                            <input type="text" id="fullname" name="fullname"
                                                   class="form-control" placeholder="Nhập họ và tên đầy đủ" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">
                                                Số Điện Thoại <span class="required text-danger">*</span>
                                            </label>
                                            <input type="tel" id="phone" name="phone"
                                                   class="form-control" placeholder="Nhập số điện thoại" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                Địa Chỉ Email <span class="required text-danger">*</span>
                                            </label>
                                            <input type="email" id="email" name="email"
                                                   class="form-control" placeholder="Nhập địa chỉ email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Information Section -->
                        <div class="shipping-form-cart-totals">
                            <div class="section-title-cart">
                                <h5 class="title">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Thông Tin Giao Hàng
                                </h5>
                            </div>
                            <div class="checkout-form-content">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address_line_1" class="form-label">
                                                Địa chỉ giao hàng <span class="required text-danger">*</span>
                                            </label>
                                            <textarea id="address_line_1" name="address_line_1" rows="2"
                                                      class="form-control" placeholder="Nhập địa chỉ chi tiết (số nhà, tên đường, phường/xã)" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_line_2" class="form-label">
                                                Địa chỉ bổ sung
                                            </label>
                                            <input type="text" id="address_line_2" name="address_line_2"
                                                   class="form-control" placeholder="Tòa nhà, căn hộ, tầng (nếu có)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state" class="form-label">
                                                State/Province <span class="required text-danger">*</span>
                                            </label>
                                            <select id="state" name="state" class="form-control form-select" required>
                                                <option value="">Chọn tỉnh/thành phố</option>
                                                <option value="An Giang">An Giang</option>
                                                <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                                                <option value="Bắc Giang">Bắc Giang</option>
                                                <option value="Bắc Kạn">Bắc Kạn</option>
                                                <option value="Bạc Liêu">Bạc Liêu</option>
                                                <option value="Bắc Ninh">Bắc Ninh</option>
                                                <option value="Bến Tre">Bến Tre</option>
                                                <option value="Bình Định">Bình Định</option>
                                                <option value="Bình Dương">Bình Dương</option>
                                                <option value="Bình Phước">Bình Phước</option>
                                                <option value="Bình Thuận">Bình Thuận</option>
                                                <option value="Cà Mau">Cà Mau</option>
                                                <option value="Cao Bằng">Cao Bằng</option>
                                                <option value="Đắk Lắk">Đắk Lắk</option>
                                                <option value="Đắk Nông">Đắk Nông</option>
                                                <option value="Điện Biên">Điện Biên</option>
                                                <option value="Đồng Nai">Đồng Nai</option>
                                                <option value="Đồng Tháp">Đồng Tháp</option>
                                                <option value="Gia Lai">Gia Lai</option>
                                                <option value="Hà Giang">Hà Giang</option>
                                                <option value="Hà Nam">Hà Nam</option>
                                                <option value="Hà Nội">Hà Nội</option>
                                                <option value="Hà Tĩnh">Hà Tĩnh</option>
                                                <option value="Hải Dương">Hải Dương</option>
                                                <option value="Hải Phòng">Hải Phòng</option>
                                                <option value="Hậu Giang">Hậu Giang</option>
                                                <option value="Hòa Bình">Hòa Bình</option>
                                                <option value="Hưng Yên">Hưng Yên</option>
                                                <option value="Khánh Hòa">Khánh Hòa</option>
                                                <option value="Kiên Giang">Kiên Giang</option>
                                                <option value="Kon Tum">Kon Tum</option>
                                                <option value="Lai Châu">Lai Châu</option>
                                                <option value="Lâm Đồng">Lâm Đồng</option>
                                                <option value="Lạng Sơn">Lạng Sơn</option>
                                                <option value="Lào Cai">Lào Cai</option>
                                                <option value="Long An">Long An</option>
                                                <option value="Nam Định">Nam Định</option>
                                                <option value="Nghệ An">Nghệ An</option>
                                                <option value="Ninh Bình">Ninh Bình</option>
                                                <option value="Ninh Thuận">Ninh Thuận</option>
                                                <option value="Phú Thọ">Phú Thọ</option>
                                                <option value="Phú Yên">Phú Yên</option>
                                                <option value="Quảng Bình">Quảng Bình</option>
                                                <option value="Quảng Nam">Quảng Nam</option>
                                                <option value="Quảng Ngãi">Quảng Ngãi</option>
                                                <option value="Quảng Ninh">Quảng Ninh</option>
                                                <option value="Quảng Trị">Quảng Trị</option>
                                                <option value="Sóc Trăng">Sóc Trăng</option>
                                                <option value="Sơn La">Sơn La</option>
                                                <option value="Tây Ninh">Tây Ninh</option>
                                                <option value="Thái Bình">Thái Bình</option>
                                                <option value="Thái Nguyên">Thái Nguyên</option>
                                                <option value="Thanh Hóa">Thanh Hóa</option>
                                                <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                                                <option value="Tiền Giang">Tiền Giang</option>
                                                <option value="TP Hồ Chí Minh">TP Hồ Chí Minh</option>
                                                <option value="Trà Vinh">Trà Vinh</option>
                                                <option value="Tuyên Quang">Tuyên Quang</option>
                                                <option value="Vĩnh Long">Vĩnh Long</option>
                                                <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                                                <option value="Yên Bái">Yên Bái</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="notes" class="form-label">
                                                Delivery Notes
                                            </label>
                                            <textarea id="notes" name="notes" rows="2"
                                                      class="form-control" placeholder="Example: Call before delivery, leave at reception, contact before delivery..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Column - Order Summary & Payment -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="shipping-form-cart-totals mb-4">
                        <div class="section-title-cart">
                            <h5 class="title">Tổng Đơn Hàng</h5>
                        </div>
                        <div class="cart-total-table">
                            <table class="table">
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <td>
                                            <p class="value">Subtotal</p>
                                        </td>
                                        <td>
                                            <p class="price">${{ number_format($subtotal, 2) }}</p>
                                        </td>
                                    </tr>
                                    <tr class="shipping">
                                        <td>
                                            <p class="value">Shipping</p>
                                        </td>
                                        <td>
                                            <p class="price">
                                                @if(($shipping ?? 0) == 0)
                                                    <span class="text-green-600">Free</span>
                                                @else
                                                    ${{ number_format($shipping ?? 0, 2) }}
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <td>
                                            <p class="value">Total</p>
                                        </td>
                                        <td>
                                            <p class="price">${{ number_format($total, 2) }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="shipping-form-cart-totals">
                        <div class="section-title-cart">
                            <h5 class="title">
                                <i class="fas fa-credit-card me-2"></i>
                                Phương Thức Thanh Toán
                            </h5>
                        </div>
                        <div class="cart-total-table">
                            <div class="payment-methods">
                                    <!-- User Wallet -->
                                    @php
                                        $userWallet = auth()->user()->userWallet ?? null;
                                        $userWalletBalance = $userWallet ? $userWallet->balance : 0;
                                        $canUseUserWallet = $userWalletBalance >= $total;
                                    @endphp
                                    @if($userWallet)
                                    <div class="radio {{ !$canUseUserWallet ? 'disabled' : '' }}">
                                        <input type="radio" name="payment_method" value="user_wallet" id="wallet"
                                               {{ !$canUseUserWallet ? 'disabled' : '' }} form="checkout-form">
                                        <label for="wallet">
                                            <span></span>
                                            <i class="fas fa-wallet me-2"></i>
                                            Personal Wallet
                                            @if($canUseUserWallet)
                                                <small class="text-success">(Balance: ${{ number_format($userWalletBalance, 2) }})</small>
                                            @else
                                                <small class="text-danger">(Insufficient balance: ${{ number_format($userWalletBalance, 2) }})</small>
                                            @endif
                                        </label>
                                    </div>
                                    @endif

                                    <div class="radio">
                                        <input type="radio" name="payment_method" value="cod" id="cod" checked form="checkout-form">
                                        <label for="cod">
                                            <span></span>
                                            <i class="fas fa-hand-holding-usd me-2"></i>
                                            Cash on Delivery (COD)
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <input type="radio" name="payment_method" value="paypal" id="paypal" form="checkout-form">
                                        <label for="paypal">
                                            <span></span>
                                            <i class="fab fa-paypal me-2"></i>
                                            PayPal
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" form="checkout-form">
                                        <label for="bank_transfer">
                                            <span></span>
                                            <i class="fas fa-university me-2"></i>
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="btn-theme btn-flat" id="complete-order-btn" form="checkout-form">
                            <span class="btn-text">
                                <i class="fas fa-lock me-2"></i>
                                Hoàn Tất Đơn Hàng
                            </span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                Đang xử lý...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="cart-empty text-center py-5">
                        <h2>Giỏ hàng của bạn đang trống</h2>
                        <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                        <a href="{{ route('shop') }}" class="btn-theme btn-flat">Tiếp Tục Mua Sắm</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!--== End Shopping Checkout Area ==-->
@endsection

@push('styles')
<style>
/* Checkout Color Theme - #eb3e32 */
:root {
    --checkout-primary: #eb3e32;
    --checkout-primary-hover: #d12c20;
    --checkout-primary-light: #fdf2f1;
}

.checkout-page {
    --bs-primary: var(--checkout-primary);
}

/* Apply #eb3e32 Color Theme */
.checkout-page .section-title-cart .title {
    color: var(--checkout-primary);
    border-bottom: 2px solid var(--checkout-primary);
    padding-bottom: 10px;
    font-weight: 600;
}

.checkout-page .btn-theme.btn-flat {
    background: var(--checkout-primary);
    border-color: var(--checkout-primary);
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.checkout-page .btn-theme.btn-flat:hover {
    background: var(--checkout-primary-hover);
    border-color: var(--checkout-primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(235, 62, 50, 0.3);
}

.checkout-page .form-control:focus {
    border-color: var(--checkout-primary);
    box-shadow: 0 0 0 0.2rem rgba(235, 62, 50, 0.15);
}

.checkout-page .radio input[type="radio"]:checked + label span {
    background: var(--checkout-primary);
    border-color: var(--checkout-primary);
}

.checkout-page .radio input[type="radio"]:checked + label {
    color: var(--checkout-primary);
    font-weight: 600;
}

.checkout-page .price {
    color: var(--checkout-primary);
    font-weight: 600;
}

.checkout-page .order-total .price {
    color: var(--checkout-primary);
    font-size: 18px;
    font-weight: 700;
}

.checkout-page .required {
    color: var(--checkout-primary);
}

.checkout-page .alert-success {
    border-color: var(--checkout-primary);
    background-color: var(--checkout-primary-light);
    color: var(--checkout-primary-hover);
}

/* Beautiful Checkout Styling */
.shopping-checkout-area {
    padding: 60px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.checkout-wrapper {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 40px;
    margin-bottom: 30px;
}

/* Section Styling */
.checkout-section {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.checkout-section:hover {
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.section-header {
    background: linear-gradient(135deg, var(--checkout-primary) 0%, var(--checkout-primary-hover) 100%);
    color: white;
    padding: 20px 25px;
    border-bottom: none;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    font-size: 20px;
    opacity: 0.9;
}

.section-subtitle {
    margin: 5px 0 0 0;
    font-size: 14px;
    opacity: 0.9;
}

.section-content {
    padding: 30px 25px;
}

/* Form Styling */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.form-label i {
    color: var(--checkout-primary);
    width: 16px;
}

.required {
    color: #dc3545;
    font-weight: bold;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control:focus {
    border-color: var(--checkout-primary);
    box-shadow: 0 0 0 0.2rem rgba(235, 62, 50, 0.15);
    background: #fff;
    outline: 0;
}

.form-control::placeholder {
    color: #6c757d;
    font-style: italic;
}

/* Payment Methods */
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.payment-option {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
    overflow: hidden;
    background: #fff;
}

.payment-option:hover {
    border-color: #007bff;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
}

.payment-option.payment-disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: #f8f9fa;
}

.payment-label {
    display: flex;
    align-items: flex-start;
    padding: 20px;
    cursor: pointer;
    margin: 0;
    width: 100%;
}

.payment-radio {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    border-radius: 50%;
    margin-right: 15px;
    margin-top: 2px;
    position: relative;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.payment-radio::after {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #007bff;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.3s ease;
}

input[type="radio"]:checked + .payment-radio {
    border-color: #007bff;
}

input[type="radio"]:checked + .payment-radio::after {
    transform: translate(-50%, -50%) scale(1);
}

input[type="radio"] {
    display: none;
}

.payment-content {
    flex: 1;
}

.payment-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}

.payment-icon {
    font-size: 24px;
    color: #007bff;
    width: 30px;
    text-align: center;
}

.payment-title {
    font-weight: 600;
    color: #212529;
    font-size: 16px;
    flex: 1;
}

.payment-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success {
    background: #d4edda;
    color: #155724;
}

.badge-danger {
    background: #f8d7da;
    color: #721c24;
}

.badge-primary {
    background: #cce7ff;
    color: #004085;
}

.badge-info {
    background: #d1ecf1;
    color: #0c5460;
}

.payment-description {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.5;
}

/* Order Summary */
.order-summary-section {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 20px;
}

.order-summary-content {
    padding: 25px;
}

.order-items {
    margin-bottom: 25px;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f3f4;
}

.order-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 14px;
    font-weight: 600;
    color: #212529;
    margin: 0 0 5px 0;
    line-height: 1.3;
}

.item-variants {
    display: flex;
    gap: 8px;
    margin-bottom: 3px;
}

.variant {
    background: #e9ecef;
    color: #495057;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}

.item-quantity {
    font-size: 12px;
    color: #6c757d;
}

.item-price {
    font-weight: 600;
    color: #007bff;
    font-size: 14px;
}

/* Order Totals */
.order-totals {
    border-top: 2px solid #f1f3f4;
    padding-top: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 14px;
}

.total-row.discount {
    color: #28a745;
}

.total-row.final-total {
    border-top: 2px solid #007bff;
    margin-top: 15px;
    padding-top: 15px;
    font-size: 18px;
    font-weight: 700;
    color: #007bff;
}

/* Place Order Button */
.btn-place-order {
    width: 100%;
    padding: 15px 30px;
    font-size: 16px;
    font-weight: 600;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 10px;
    color: white;
    margin-top: 20px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-place-order:hover {
    background: linear-gradient(135deg, #218838 0%, #1a9d88 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

.btn-place-order:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 991px) {
    .checkout-wrapper {
        padding: 20px;
    }

    .section-content {
        padding: 20px;
    }

    .order-summary-section {
        position: static;
        margin-top: 30px;
    }
}

@media (max-width: 768px) {
    .payment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .item-details {
        margin-right: 10px;
    }

    .total-row.final-total {
        font-size: 16px;
    }
}

/* Loading Animation */
.btn-place-order.loading {
    opacity: 0.7;
    pointer-events: none;
}

.btn-place-order.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    margin-left: 10px;
    border: 2px solid transparent;
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // AJAX Checkout form submission
    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();
        processAjaxCheckout();
    });

    function processAjaxCheckout() {
        // Validate payment method
        const selectedPayment = $('input[name="payment_method"]:checked');
        if (selectedPayment.length === 0) {
            showError('Vui lòng chọn phương thức thanh toán');
            return false;
        }

        // Validate required fields
        let hasErrors = false;
        const requiredFields = ['fullname', 'email', 'phone', 'address_line_1', 'state'];

        requiredFields.forEach(function(fieldName) {
            const $field = $(`input[name="${fieldName}"], textarea[name="${fieldName}"], select[name="${fieldName}"]`);
            if (!$field.val() || !$field.val().trim()) {
                hasErrors = true;
                $field.addClass('is-invalid');
            } else {
                $field.removeClass('is-invalid');
            }
        });

        if (hasErrors) {
            showError('Vui lòng điền đầy đủ thông tin bắt buộc');
            return false;
        }

        // Show loading state
        const $btn = $('#complete-order-btn');
        $btn.prop('disabled', true);
        $btn.find('.btn-text').hide();
        $btn.find('.btn-loading').show();

        // Submit form
        const formData = new FormData($('#checkout-form')[0]);

        $.ajax({
            url: $('#checkout-form').attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Redirect to confirmation page
                    window.location.href = response.redirect_url || '/order/confirmation/' + response.order_id;
                } else {
                    showError(response.message || 'Có lỗi xảy ra, vui lòng thử lại');
                    resetButton();
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showError(response?.message || 'Có lỗi xảy ra, vui lòng thử lại');
                resetButton();
            }
        });
    }

    function resetButton() {
        const $btn = $('#complete-order-btn');
        $btn.prop('disabled', false);
        $btn.find('.btn-text').show();
        $btn.find('.btn-loading').hide();
    }

    function showError(message) {
        // Create or update error alert
        let $alert = $('.checkout-alert-error');
        if ($alert.length === 0) {
            $alert = $('<div class="alert alert-danger alert-dismissible fade show checkout-alert-error" role="alert"></div>');
            $alert.append('<button type="button" class="btn-close" data-bs-dismiss="alert"></button>');
            $('.shopping-checkout-area .container').prepend($alert);
        }
        $alert.html('<i class="fas fa-exclamation-circle me-2"></i>' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>');
        $('html, body').animate({ scrollTop: 0 }, 300);
    }

    // Remove invalid class on input change
    $('input, textarea, select').on('change', function() {
        $(this).removeClass('is-invalid');
    });

    // Initialize with COD selected if no payment method is already selected
    if (!document.querySelector('input[name="payment_method"]:checked')) {
        const codRadio = document.querySelector('input[value="cod"]');
        if (codRadio) {
            codRadio.checked = true;
        }
    }
});
</script>
@endpush
