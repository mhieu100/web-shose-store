@extends('layouts.frontend')

@section('title', 'Xác Nhận Đơn Hàng')

@section('content')
<!--== Start Page Header Area Wrapper ==-->
<div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
    <div class="container pt-90 pb-90">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-content text-center">
                    <h2 class="title">Xác Nhận Đơn Hàng</h2>
                    <nav class="breadcrumb-area">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li><a href="{{ route('cart') }}">Giỏ hàng</a></li>
                            <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
                            <li class="breadcrumb-sep">//</li>
                            <li>Xác nhận</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--== End Page Header Area Wrapper ==-->

<!--== Start Order Confirmation Area ==-->
<section class="shopping-cart-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Success Message -->
                <div class="order-success-message text-center mb-5">
                    <div class="success-icon mb-4">
                        <i class="fa fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="text-success mb-3">Đặt Hàng Thành Công!</h2>
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
                    <div class="card-header bg-primary text-white">
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
                                <strong>Ngày Đặt:</strong>
                                {{ $order->created_at->format('d/m/Y \l\ú\c H:i') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Phương Thức Thanh Toán:</strong>
                                <span class="badge bg-info">
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
                                            Ví điện tử
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
                                        {{ $order->status }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if($order->notes)
                        <div class="row">
                            <div class="col-12">
                                <strong>Ghi Chú:</strong>
                                <p class="text-muted mt-1">{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-shopping-bag me-2"></i>
                            Sản Phẩm Đã Đặt
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-end">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->getFirstMediaUrl('gallery'))
                                                    <img src="{{ $item->product->getFirstMediaUrl('gallery') }}"
                                                         alt="{{ $item->product_snapshot['name'] ?? $item->product->name }}"
                                                         class="me-3 rounded"
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                         alt="Product"
                                                         class="me-3 rounded"
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product_snapshot['name'] ?? $item->product->name }}</h6>
                                                    @if(isset($item->product_snapshot['color']) && $item->product_snapshot['color'])
                                                        <small class="text-muted">Màu: {{ $item->product_snapshot['color'] }}</small><br>
                                                    @endif
                                                    @if(isset($item->product_snapshot['size']) && $item->product_snapshot['size'])
                                                        <small class="text-muted">Size: {{ $item->product_snapshot['size'] }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end align-middle">
                                            {{ number_format($item->price) }}₫
                                        </td>
                                        <td class="text-end align-middle">
                                            <strong>{{ number_format($item->total) }}₫</strong>
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
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-calculator me-2"></i>
                            Tổng Quan Đơn Hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="order-summary">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($order->subtotal) }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span>{{ number_format($order->shipping_amount) }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Thuế VAT:</span>
                                <span>{{ number_format($order->tax_amount) }}₫</span>
                            </div>
                            @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá:</span>
                                <span>-{{ number_format($order->discount_amount) }}₫</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-primary">{{ number_format($order->total_amount) }}₫</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-truck me-2"></i>
                            Địa Chỉ Giao Hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <address class="mb-0">
                            {{ $order->shipping_address['address_line_1'] }}<br>
                            @if($order->shipping_address['address_line_2'])
                                {{ $order->shipping_address['address_line_2'] }}<br>
                            @endif
                            {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}<br>
                            {{ $order->shipping_address['country'] }}<br>
                            @if($order->shipping_address['phone'])
                                <strong>Số điện thoại:</strong> {{ $order->shipping_address['phone'] }}
                            @endif
                        </address>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">
                        <i class="fa fa-home me-2"></i>
                        Tiếp Tục Mua Sắm
                    </a>
                    <a href="{{ route('account.index') }}" class="btn btn-info me-3">
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
