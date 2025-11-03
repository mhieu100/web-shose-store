@extends('layouts.frontend')

@section('title', 'Xác Nhận Đơn Hàng')

@section('content')
<!--== Start Page Header Area Wrapper ==-->
<div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
    <div class="container pt-90 pb-90">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-content text-center">
                    <h2 class="title" style="color: #eb3e32;">Xác Nhận Đơn Hàng</h2>
                    <nav class="breadcrumb-area">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}" style="color: #eb3e32;">Trang chủ</a></li>
                            <li class="breadcrumb-sep">/</li>
                            <li style="color: #eb3e32;">Xác nhận đơn hàng</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--== End Page Header Area Wrapper ==-->

<!--== Start Order Confirmation Area ==-->
<section class="shopping-cart-area section-padding confirmation-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Success Message -->
                <div class="order-success-message text-center mb-5">
                    <div class="success-icon mb-4">
                        <i class="fa fa-check-circle" style="font-size: 4rem; color: #eb3e32;"></i>
                    </div>
                    <h2 class="mb-3" style="color: #eb3e32;">Đặt Hàng Thành Công!</h2>
                    <p class="text-muted mb-4">
                        Cảm ơn bạn đã đặt hàng. Chúng tôi đã nhận được đơn hàng và sẽ xử lý trong thời gian sớm nhất.
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>

                <!-- Order Details Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header text-white" style="background: #eb3e32;">
                        <h5 class="mb-0">
                            <i class="fa fa-file-text-o me-2"></i>
                            Chi Tiết Đơn Hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Mã Đơn Hàng:</strong>
                                <span class="text-primary">{{ $order->order_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Ngày Đặt Hàng:</strong>
                                {{ $order->created_at->format('d/m/Y \l\ú\c H:i') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Phương Thức Thanh Toán:</strong>
                                <span class="badge" style="background: #eb3e32;">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            Thanh toán khi nhận hàng
                                            @break
                                        @case('bank_transfer')
                                            Chuyển khoản ngân hàng
                                            @break
                                        @case('paypal')
                                            PayPal
                                            @break
                                        @case('wallet')
                                        @case('user_wallet')
                                            Thanh toán bằng ví
                                            @break
                                        @default
                                            {{ ucfirst($order->payment_method) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Trạng Thái:</strong>
                                <span class="badge bg-warning">
                                    @if(is_object($order->status))
                                        {{ $order->status->value }}
                                    @else
                                        {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if($order->notes)
                        <div class="row">
                            <div class="col-12">
                                <strong>Ghi Chú Đơn Hàng:</strong>
                                <p class="text-muted mt-1">{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header text-white" style="background: #eb3e32;">
                        <h5 class="mb-0">
                            <i class="fa fa-shopping-bag me-2"></i>
                            Sản Phẩm Đã Đặt
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="color: #eb3e32; font-weight: 600;">Sản Phẩm</th>
                                        <th class="text-center" style="color: #eb3e32; font-weight: 600;">Số Lượng</th>
                                        <th class="text-end" style="color: #eb3e32; font-weight: 600;">Đơn Giá</th>
                                        <th class="text-end" style="color: #eb3e32; font-weight: 600;">Thành Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->getFirstMediaUrl('product-images'))
                                                    <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                                         alt="{{ $item->product_snapshot['name'] ?? $item->product->name }}"
                                                         class="me-3 rounded border"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                @elseif($item->product && $item->product->getFirstMediaUrl('gallery'))
                                                    <img src="{{ $item->product->getFirstMediaUrl('gallery') }}"
                                                         alt="{{ $item->product_snapshot['name'] ?? $item->product->name }}"
                                                         class="me-3 rounded border"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                         alt="Product"
                                                         class="me-3 rounded border"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-1" style="color: #333;">{{ $item->product_snapshot['name'] ?? ($item->product ? $item->product->name : 'Sản phẩm') }}</h6>
                                                    @if(isset($item->product_snapshot['color']) && $item->product_snapshot['color'])
                                                        <small class="text-muted"><strong>Màu sắc:</strong> {{ $item->product_snapshot['color'] }}</small><br>
                                                    @endif
                                                    @if(isset($item->product_snapshot['size']) && $item->product_snapshot['size'])
                                                        <small class="text-muted"><strong>Kích thước:</strong> {{ $item->product_snapshot['size'] }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge text-white" style="background: #eb3e32; font-size: 14px; padding: 8px 12px;">{{ $item->quantity ?? 1 }}</span>
                                        </td>
                                        <td class="text-end align-middle">
                                            <span style="color: #eb3e32; font-weight: 600; font-size: 15px;">{{ number_format($item->price ?? 0, 0, ',', '.') }}₫</span>
                                        </td>
                                        <td class="text-end align-middle">
                                            <strong style="color: #eb3e32; font-size: 16px;">{{ number_format(($item->quantity ?? 1) * ($item->price ?? 0), 0, ',', '.') }}₫</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header text-white" style="background: #eb3e32;">
                        <h5 class="mb-0">
                            <i class="fa fa-calculator me-2"></i>
                            Tổng Kết Đơn Hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="order-summary">
                            <div class="d-flex justify-content-between mb-3 py-2 border-bottom">
                                <span style="font-weight: 500;">Tạm tính:</span>
                                <span style="color: #eb3e32; font-weight: 600;">{{ number_format($order->subtotal ?? 0, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 py-2 border-bottom">
                                <span style="font-weight: 500;">Phí vận chuyển:</span>
                                <span style="color: #eb3e32; font-weight: 600;">
                                    @if(($order->shipping_amount ?? 0) > 0)
                                        {{ number_format($order->shipping_amount, 0, ',', '.') }}₫
                                    @else
                                        Miễn phí
                                    @endif
                                </span>
                            </div>
                            @if(($order->tax_amount ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-3 py-2 border-bottom">
                                <span style="font-weight: 500;">Thuế VAT:</span>
                                <span style="color: #eb3e32; font-weight: 600;">{{ number_format($order->tax_amount, 0, ',', '.') }}₫</span>
                            </div>
                            @endif
                            @if(($order->discount_amount ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-3 py-2 border-bottom" style="color: #28a745;">
                                <span style="font-weight: 500;">Giảm giá:</span>
                                <span style="font-weight: 600;">-{{ number_format($order->discount_amount, 0, ',', '.') }}₫</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between py-3" style="background: #f8f9fa; margin: 0 -1.25rem; padding-left: 1.25rem; padding-right: 1.25rem; border-top: 2px solid #eb3e32;">
                                <strong style="font-size: 18px; color: #333;">Tổng Cộng:</strong>
                                <strong style="font-size: 20px; color: #eb3e32;">{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}₫</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header text-white" style="background: #eb3e32;">
                        <h5 class="mb-0">
                            <i class="fa fa-truck me-2"></i>
                            Địa Chỉ Giao Hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="shipping-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong style="color: #eb3e32;">Địa chỉ nhận hàng:</strong>
                                    <address class="mt-2 mb-0">
                                        {{ $order->shipping_address['address_line_1'] ?? 'Chưa cung cấp' }}<br>
                                        @if(isset($order->shipping_address['address_line_2']) && $order->shipping_address['address_line_2'])
                                            {{ $order->shipping_address['address_line_2'] }}<br>
                                        @endif
                                        {{ $order->shipping_address['city'] ?? '' }}@if(isset($order->shipping_address['city']) && isset($order->shipping_address['state'])), @endif{{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}<br>
                                        {{ $order->shipping_address['country'] ?? 'Việt Nam' }}
                                    </address>
                                </div>
                                @if(isset($order->shipping_address['phone']) && $order->shipping_address['phone'])
                                <div class="col-md-6">
                                    <strong style="color: #eb3e32;">Thông tin liên hệ:</strong>
                                    <div class="mt-2">
                                        <i class="fa fa-phone" style="color: #eb3e32;"></i>
                                        <span class="ms-2">{{ $order->shipping_address['phone'] }}</span>
                                    </div>
                                    @if(isset($order->shipping_address['email']) && $order->shipping_address['email'])
                                    <div class="mt-1">
                                        <i class="fa fa-envelope" style="color: #eb3e32;"></i>
                                        <span class="ms-2">{{ $order->shipping_address['email'] }}</span>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">
                        <i class="fa fa-home me-2"></i>
                        Tiếp Tục Mua Sắm
                    </a>
                    <a href="{{ route('account.index') }}" class="btn btn-primary me-3">
                        <i class="fa fa-user me-2"></i>
                        Xem Đơn Hàng
                    </a>
                    <a href="#" class="btn btn-secondary" onclick="window.print()">
                        <i class="fa fa-print me-2"></i>
                        In Đơn Hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Order Confirmation Area ==-->
@endsection

@push('styles')
<style>
/* Confirmation Page Color Theme - #eb3e32 */
:root {
    --confirmation-primary: #eb3e32;
    --confirmation-primary-hover: #d12c20;
    --confirmation-primary-light: #fdf2f1;
}

.confirmation-page {
    --bs-primary: var(--confirmation-primary);
}

/* Apply #eb3e32 Color Theme */
.confirmation-page .btn-theme,
.confirmation-page .btn-primary,
.confirmation-page .btn-outline-primary {
    background: var(--confirmation-primary);
    border-color: var(--confirmation-primary);
    color: white;
}

.confirmation-page .btn-theme:hover,
.confirmation-page .btn-primary:hover,
.confirmation-page .btn-outline-primary:hover {
    background: var(--confirmation-primary-hover);
    border-color: var(--confirmation-primary-hover);
    color: white;
}

.confirmation-page .btn-outline-primary {
    background: transparent;
    color: var(--confirmation-primary);
}

.confirmation-page .alert-success {
    border-color: var(--confirmation-primary);
    background-color: var(--confirmation-primary-light);
    color: var(--confirmation-primary-hover);
}

.confirmation-page .text-primary,
.confirmation-page .order-info .text-primary {
    color: var(--confirmation-primary) !important;
}

.confirmation-page .card-header {
    background: var(--confirmation-primary);
    border-color: var(--confirmation-primary);
    color: white;
}

.confirmation-page .total-amount,
.confirmation-page .price-highlight {
    color: var(--confirmation-primary);
    font-weight: 600;
}

/* Enhanced Product Display */
.confirmation-page .table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.confirmation-page .table img {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.confirmation-page .table img:hover {
    border-color: var(--confirmation-primary);
    transform: scale(1.05);
}

/* Enhanced Card Styling */
.confirmation-page .card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.confirmation-page .card:hover {
    box-shadow: 0 4px 20px rgba(235, 62, 50, 0.15);
    transform: translateY(-2px);
}

/* Enhanced Typography */
.confirmation-page .card-body strong {
    color: #333;
    font-weight: 600;
}

.confirmation-page .shipping-info {
    font-size: 15px;
    line-height: 1.6;
}

/* Enhanced Badge Styling */
.confirmation-page .badge {
    font-size: 12px;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
}

/* Enhanced Order Summary */
.confirmation-page .order-summary .border-bottom {
    border-color: #e9ecef !important;
}

.success-icon {
    animation: bounceIn 1s;
}

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale3d(0.3, 0.3, 0.3);
    }
    50% {
        opacity: 1;
    }
    100% {
        opacity: 1;
        transform: scale3d(1, 1, 1);
    }
}

.order-summary {
    font-size: 16px;
}

@media print {
    .btn, .breadcrumb-area {
        display: none !important;
    }

    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
