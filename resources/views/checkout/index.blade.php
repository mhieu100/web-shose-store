@extends('layouts.frontend')

@section('title', 'Thanh Toán - Cửa Hàng Giày')

@section('content')
<!--== Start Page Header Area Wrapper ==-->
<div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
    <div class="container pt--0 pb--0">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content">
                    <h2 class="title" data-aos="fade-down" data-aos-duration="1000">
                        <i class="fa fa-credit-card me-2"></i>
                        Thanh Toán Đơn Hàng
                    </h2>
                    <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                            <li><a href="{{ route('cart') }}">Giỏ Hàng</a></li>
                            <li class="breadcrumb-sep">//</li>
                            <li>Thanh Toán</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--== End Page Header Area Wrapper ==-->

<!--== Start Shopping Checkout Area Wrapper ==-->
<section class="shopping-checkout-wrap section-padding">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6><i class="fa fa-exclamation-triangle me-2"></i>Có lỗi xảy ra:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="post" id="checkout-form">
            @csrf
            <div class="row">
                <!-- Left Column - Customer Information -->
                <div class="col-lg-8">
                    <!-- Customer Info Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-user me-2"></i>
                                Thông Tin Khách Hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="customer-info mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="customer-avatar me-3">
                                        <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px; border-radius: 50%;">
                                            <i class="fa fa-user fa-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-truck me-2"></i>
                                Thông Tin Giao Hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="address_line_1" class="form-label">
                                            <i class="fa fa-map-marker me-1"></i>
                                            Địa chỉ <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control @error('address_line_1') is-invalid @enderror"
                                               id="address_line_1"
                                               name="address_line_1"
                                               value="{{ old('address_line_1') }}"
                                               placeholder="Số nhà, tên đường..."
                                               required>
                                        @error('address_line_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="address_line_2" class="form-label">
                                            <i class="fa fa-map-marker-alt me-1"></i>
                                            Địa chỉ bổ sung (tuỳ chọn)
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               id="address_line_2"
                                               name="address_line_2"
                                               value="{{ old('address_line_2') }}"
                                               placeholder="Căn hộ, tầng, tòa nhà...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city" class="form-label">
                                            <i class="fa fa-building me-1"></i>
                                            Thành phố <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control @error('city') is-invalid @enderror"
                                               id="city"
                                               name="city"
                                               value="{{ old('city') }}"
                                               placeholder="Hồ Chí Minh, Hà Nội..."
                                               required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="state" class="form-label">
                                            <i class="fa fa-map me-1"></i>
                                            Tỉnh/Thành <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control @error('state') is-invalid @enderror"
                                                id="state"
                                                name="state"
                                                required>
                                            <option value="">Chọn Tỉnh/Thành</option>
                                            <option value="Ho Chi Minh" {{ old('state') == 'Ho Chi Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                            <option value="Ha Noi" {{ old('state') == 'Ha Noi' ? 'selected' : '' }}>Hà Nội</option>
                                            <option value="Da Nang" {{ old('state') == 'Da Nang' ? 'selected' : '' }}>Đà Nẵng</option>
                                            <option value="Can Tho" {{ old('state') == 'Can Tho' ? 'selected' : '' }}>Cần Thơ</option>
                                            <option value="Hai Phong" {{ old('state') == 'Hai Phong' ? 'selected' : '' }}>Hải Phòng</option>
                                            <option value="Dong Nai" {{ old('state') == 'Dong Nai' ? 'selected' : '' }}>Đồng Nai</option>
                                            <option value="Binh Duong" {{ old('state') == 'Binh Duong' ? 'selected' : '' }}>Bình Dương</option>
                                            <option value="Ba Ria Vung Tau" {{ old('state') == 'Ba Ria Vung Tau' ? 'selected' : '' }}>Bà Rịa - Vũng Tàu</option>
                                        </select>
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="postal_code" class="form-label">
                                            <i class="fa fa-envelope me-1"></i>
                                            Mã bưu chính <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control @error('postal_code') is-invalid @enderror"
                                               id="postal_code"
                                               name="postal_code"
                                               value="{{ old('postal_code') }}"
                                               placeholder="700000, 100000..."
                                               required>
                                        @error('postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country" class="form-label">
                                            <i class="fa fa-flag me-1"></i>
                                            Quốc gia <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control @error('country') is-invalid @enderror"
                                                id="country"
                                                name="country"
                                                required>
                                            <option value="Vietnam" {{ old('country', 'Vietnam') == 'Vietnam' ? 'selected' : '' }}>Việt Nam</option>
                                        </select>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">
                                            <i class="fa fa-phone me-1"></i>
                                            Số điện thoại <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="0909 123 456"
                                               required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-credit-card me-2"></i>
                                Phương Thức Thanh Toán
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="payment-methods">
                                <!-- COD Payment Method -->
                                <div class="form-check payment-option mb-3" data-payment="cod">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="payment_method"
                                           id="cod"
                                           value="cod"
                                           {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label d-flex align-items-center w-100" for="cod">
                                        <div class="payment-icon me-3">
                                            <i class="fa fa-money fa-2x text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <strong>Thanh toán khi nhận hàng (COD)</strong>
                                            <br>
                                            <small class="text-muted">Thanh toán bằng tiền mặt khi nhận được sản phẩm</small>
                                            <div class="payment-details mt-2" style="display: none;">
                                                <div class="alert alert-info mb-0">
                                                    <i class="fa fa-info-circle me-2"></i>
                                                    <strong>Lưu ý:</strong> Bạn sẽ thanh toán cho shipper khi nhận hàng
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Bank Transfer Payment Method -->
                                <div class="form-check payment-option mb-3" data-payment="bank_transfer">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="payment_method"
                                           id="bank_transfer"
                                           value="bank_transfer"
                                           {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center w-100" for="bank_transfer">
                                        <div class="payment-icon me-3">
                                            <i class="fa fa-bank fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <strong>Chuyển khoản ngân hàng</strong>
                                            <br>
                                            <small class="text-muted">Chuyển khoản trực tiếp vào tài khoản ngân hàng</small>
                                            <div class="payment-details mt-2" style="display: none;">
                                                <div class="alert alert-warning mb-0">
                                                    <strong>Thông tin chuyển khoản:</strong><br>
                                                    <strong>Ngân hàng:</strong> Techcombank<br>
                                                    <strong>Số tài khoản:</strong> 1234567890<br>
                                                    <strong>Tên tài khoản:</strong> Cửa Hàng Giày XYZ<br>
                                                    <strong>Nội dung:</strong> Thanh toán đơn hàng [ORDER_NUMBER]
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- PayPal Payment Method -->
                                <div class="form-check payment-option" data-payment="paypal">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="payment_method"
                                           id="paypal"
                                           value="paypal"
                                           {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center w-100" for="paypal">
                                        <div class="payment-icon me-3">
                                            <i class="fab fa-paypal fa-2x text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <strong>PayPal</strong>
                                            <br>
                                            <small class="text-muted">Thanh toán an toàn qua PayPal</small>
                                            <div class="payment-details mt-2" style="display: none;">
                                                <div class="alert alert-info mb-0">
                                                    <i class="fab fa-paypal me-2"></i>
                                                    Bạn sẽ được chuyển đến PayPal để hoàn tất thanh toán
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Payment Method Error -->
                                @error('payment_method')
                                    <div class="alert alert-danger mt-2">
                                        <i class="fa fa-exclamation-triangle me-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-sticky-note me-2"></i>
                                Ghi Chú Đơn Hàng (Tuỳ chọn)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="notes" class="form-label">
                                    <i class="fa fa-comment me-1"></i>
                                    Ghi chú cho đơn hàng
                                </label>
                                <textarea class="form-control"
                                          id="notes"
                                          name="notes"
                                          rows="3"
                                          placeholder="Ghi chú về đơn hàng của bạn, ví dụ: ghi chú đặc biệt cho việc giao hàng...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <!-- Cart Items Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">
                                    <i class="fa fa-shopping-bag me-2"></i>
                                    Đơn Hàng Của Bạn ({{ $cartItems->count() }} sản phẩm)
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="cart-items-list">
                                    @foreach($cartItems as $item)
                                    <div class="cart-item d-flex align-items-center p-3 border-bottom">
                                        <div class="item-image me-3">
                                            @if($item->product->getFirstMediaUrl('gallery'))
                                                <img src="{{ $item->product->getFirstMediaUrl('gallery') }}"
                                                     alt="{{ $item->product->name }}"
                                                     class="rounded"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                     alt="Product"
                                                     class="rounded"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="item-details flex-grow-1">
                                            <h6 class="item-name mb-1">{{ $item->product->name }}</h6>
                                            @if($item->color)
                                                <small class="text-muted d-block">Màu: {{ $item->color }}</small>
                                            @endif
                                            @if($item->size)
                                                <small class="text-muted d-block">Size: {{ $item->size }}</small>
                                            @endif
                                            <div class="item-price-qty mt-1">
                                                <span class="quantity badge bg-light text-dark">{{ $item->quantity }}x</span>
                                                <span class="price text-primary fw-bold ms-2">
                                                    ${{ number_format($item->product->sale_price ?? $item->product->price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Coupon Code Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fa fa-ticket me-2"></i>
                                    Mã Giảm Giá
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($appliedCoupon)
                                    <!-- Applied Coupon Display -->
                                    <div class="applied-coupon alert alert-success d-flex justify-content-between align-items-center mb-0">
                                        <div>
                                            <strong><i class="fa fa-check-circle me-2"></i>{{ $appliedCoupon->code }}</strong>
                                            <br>
                                            <small>{{ $appliedCoupon->name }}</small>
                                            <br>
                                            <span class="text-success fw-bold">
                                                Tiết kiệm: ${{ number_format($couponDiscount, 2) }}
                                            </span>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-coupon-btn">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                @else
                                    <!-- Coupon Input Form -->
                                    <div class="coupon-form">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control coupon-input"
                                                   id="coupon_code"
                                                   placeholder="Nhập mã giảm giá..."
                                                   style="text-transform: uppercase;">
                                            <button type="button" class="btn btn-primary apply-coupon-btn">
                                                <i class="fa fa-check me-1"></i>
                                                Áp dụng
                                            </button>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="fa fa-info-circle me-1"></i>
                                            Nhập mã giảm giá để được ưu đãi thêm
                                        </small>
                                    </div>
                                @endif

                                <!-- Coupon Messages -->
                                <div class="coupon-messages mt-3" style="display: none;">
                                    <div class="alert mb-0"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">
                                    <i class="fa fa-calculator me-2"></i>
                                    Tổng Kết Đơn Hàng
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="order-summary">
                                    <div class="summary-row d-flex justify-content-between mb-2">
                                        <span>Tổng phụ:</span>
                                        <span class="fw-bold subtotal-amount">${{ number_format($subtotal, 2) }}</span>
                                    </div>

                                    @if($appliedCoupon && $couponDiscount > 0)
                                    <div class="summary-row d-flex justify-content-between mb-2 text-success">
                                        <span>
                                            <i class="fa fa-ticket me-1"></i>
                                            Giảm giá ({{ $appliedCoupon->code }}):
                                        </span>
                                        <span class="fw-bold discount-amount">-${{ number_format($couponDiscount, 2) }}</span>
                                    </div>
                                    @endif

                                    <div class="summary-row d-flex justify-content-between mb-2">
                                        <span>Phí vận chuyển:</span>
                                        <span class="fw-bold shipping-amount">
                                            @if($shipping == 0)
                                                <span class="text-success">Miễn phí</span>
                                            @else
                                                ${{ number_format($shipping, 2) }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="summary-row d-flex justify-content-between mb-3">
                                        <span>Thuế VAT (10%):</span>
                                        <span class="fw-bold tax-amount">${{ number_format($tax, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="summary-row d-flex justify-content-between total-row">
                                        <span class="h5 mb-0">Tổng cộng:</span>
                                        <span class="h5 mb-0 text-primary fw-bold total-amount">${{ number_format($total, 2) }}</span>
                                    </div>

                                    @if($subtotal >= 100)
                                        <div class="shipping-notice mt-3">
                                            <div class="alert alert-success mb-0">
                                                <i class="fa fa-truck me-2"></i>
                                                <small>Bạn được miễn phí vận chuyển!</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="shipping-notice mt-3">
                                            <div class="alert alert-info mb-0">
                                                <i class="fa fa-info-circle me-2"></i>
                                                <small>Mua thêm ${{ number_format(100 - $subtotal, 2) }} để được miễn phí vận chuyển!</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100 place-order-btn">
                                    <i class="fa fa-lock me-2"></i>
                                    Đặt Hàng Ngay
                                    <div class="loading-spinner d-none ms-2">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                </button>
                                <small class="text-muted d-block mt-2">
                                    <i class="fa fa-shield me-1"></i>
                                    Thông tin của bạn được bảo mật tuyệt đối
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--== End Shopping Checkout Area Wrapper ==-->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
<style>
/* Checkout Page Styles */
.checkout-sidebar {
    position: sticky;
    top: 20px;
}

.cart-item {
    transition: background-color 0.3s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.payment-option {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.payment-option:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.payment-option .form-check-input:checked ~ .form-check-label {
    color: #007bff;
}

.payment-option .form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.payment-option.has-checked {
    border-color: #007bff;
    background-color: #e7f3ff;
}

.order-summary .summary-row {
    font-size: 16px;
}

.total-row {
    font-size: 18px !important;
    padding-top: 10px;
}

.place-order-btn {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    padding: 15px 20px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.place-order-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.place-order-btn:disabled {
    background: #6c757d;
    transform: none;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
    font-weight: 600;
}

.shipping-notice .alert {
    border-radius: 6px;
    font-size: 14px;
}

.customer-avatar .avatar-circle {
    font-size: 18px;
}

@media (max-width: 991px) {
    .checkout-sidebar {
        position: static;
        margin-top: 30px;
    }
}

/* Loading Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-spinner .fa-spin {
    animation: spin 1s linear infinite;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Handle payment method selection visual feedback
    $('input[name="payment_method"]').change(function() {
        // Remove checked state from all options
        $('.payment-option').removeClass('has-checked');
        $('.payment-details').slideUp(200);

        // Add checked state to selected option
        const $selectedOption = $(this).closest('.payment-option');
        $selectedOption.addClass('has-checked');

        // Show payment details for selected method
        $selectedOption.find('.payment-details').slideDown(300);

        // Update order summary if needed based on payment method
        updatePaymentMethodInfo($(this).val());
    });

    // Initialize first payment method
    const $checkedPayment = $('input[name="payment_method"]:checked');
    if ($checkedPayment.length > 0) {
        $checkedPayment.closest('.payment-option').addClass('has-checked');
        $checkedPayment.closest('.payment-option').find('.payment-details').show();
    }

    // Update payment method info function
    function updatePaymentMethodInfo(method) {
        // You can add specific logic here based on payment method
        console.log('Selected payment method:', method);

        // Example: Show different messages or update fees
        switch(method) {
            case 'cod':
                // COD selected
                break;
            case 'bank_transfer':
                // Bank transfer selected
                break;
            case 'paypal':
                // PayPal selected
                break;
        }
    }

    // Handle form submission
    $('#checkout-form').on('submit', function(e) {
        // Validate payment method selection
        const selectedPayment = $('input[name="payment_method"]:checked');
        if (selectedPayment.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn phương thức thanh toán');
            $('html, body').animate({
                scrollTop: $('.payment-methods').offset().top - 100
            }, 500);
            return false;
        }

        // Validate required fields
        let hasErrors = false;
        const requiredFields = ['address_line_1', 'city', 'state', 'postal_code', 'country', 'phone'];

        requiredFields.forEach(function(fieldName) {
            const $field = $(`input[name="${fieldName}"]`);
            if (!$field.val().trim()) {
                hasErrors = true;
                $field.addClass('is-invalid');
                if (!$field.next('.invalid-feedback').length) {
                    $field.after('<div class="invalid-feedback">Trường này là bắt buộc</div>');
                }
            } else {
                $field.removeClass('is-invalid');
                $field.next('.invalid-feedback').remove();
            }
        });

        if (hasErrors) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin bắt buộc');
            return false;
        }

        const $submitBtn = $('.place-order-btn');

        // Show loading state
        $submitBtn.prop('disabled', true);
        $submitBtn.find('i.fa-lock').removeClass('fa-lock').addClass('fa-spinner fa-spin');

        // Prevent multiple submissions
        $submitBtn.html('<i class="fa fa-spinner fa-spin me-2"></i>Đang xử lý...');

        // Show payment method confirmation
        const paymentText = selectedPayment.closest('.payment-option').find('strong').first().text();
        console.log('Processing order with payment method:', paymentText);
    });

    // Phone number formatting
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 4) {
                value = value;
            } else if (value.length <= 7) {
                value = value.substring(0, 4) + ' ' + value.substring(4);
            } else {
                value = value.substring(0, 4) + ' ' + value.substring(4, 7) + ' ' + value.substring(7, 10);
            }
        }
        $(this).val(value);
    });

    // Auto-format postal code
    $('#postal_code').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        $(this).val(value);
    });

    // Coupon functionality
    $('.apply-coupon-btn').on('click', function() {
        const couponCode = $('#coupon_code').val().trim().toUpperCase();

        if (!couponCode) {
            showCouponMessage('error', 'Vui lòng nhập mã giảm giá.');
            return;
        }

        const $btn = $(this);
        const originalText = $btn.html();

        // Show loading
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i>Đang xử lý...');

        $.ajax({
            url: '{{ route("checkout.apply_coupon") }}',
            method: 'POST',
            data: {
                coupon_code: couponCode,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showCouponMessage('success', response.message);
                    // Reload page to update totals
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showCouponMessage('error', response.message);
                    $btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                const message = response && response.message ? response.message : 'Có lỗi xảy ra khi áp dụng mã giảm giá.';
                showCouponMessage('error', message);
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Remove coupon
    $('.remove-coupon-btn').on('click', function() {
        if (!confirm('Bạn có chắc muốn xóa mã giảm giá này?')) {
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: '{{ route("checkout.remove_coupon") }}',
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showCouponMessage('success', response.message);
                    // Reload page to update totals
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showCouponMessage('error', response.message);
                    $btn.prop('disabled', false).html('<i class="fa fa-times"></i>');
                }
            },
            error: function(xhr) {
                showCouponMessage('error', 'Có lỗi xảy ra khi xóa mã giảm giá.');
                $btn.prop('disabled', false).html('<i class="fa fa-times"></i>');
            }
        });
    });

    // Apply coupon on Enter key
    $('#coupon_code').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('.apply-coupon-btn').click();
        }
    });

    // Auto uppercase coupon code
    $('#coupon_code').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });

    // Show coupon message function
    function showCouponMessage(type, message) {
        const $messages = $('.coupon-messages');
        const $alert = $messages.find('.alert');

        $alert.removeClass('alert-success alert-danger alert-info')
              .addClass(type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info'))
              .html('<i class="fa fa-' + (type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-triangle' : 'info-circle')) + ' me-2"></i>' + message);

        $messages.show();

        // Auto hide after 5 seconds
        setTimeout(() => {
            $messages.fadeOut();
        }, 5000);
    }
});
</script>
@endpush
