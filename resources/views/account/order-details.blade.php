@extends('layouts.frontend')

@section('title', 'Chi Tiết Đơn Hàng #' . $order->order_number ?? $order->id)

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Chi Tiết Đơn Hàng</h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li><a href="{{ route('account.index') }}">Tài Khoản</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li>Đơn Hàng #{{ $order->order_number ?? $order->id }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Order Details Area ==-->
    <section class="order-details-area">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="order-details-wrapper">
                        <!-- Order Header -->
                        <div class="order-header d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3>Đơn Hàng #{{ $order->order_number ?? $order->id }}</h3>
                                <p class="text-muted">Đặt ngày {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-end">
                                <span class="badge badge-{{ $order->status_color }} badge-lg">
                                    {{ $order->status->getLabel() }}
                                </span>
                                @if($order->canBeCancelled())
                                    <form method="POST" action="{{ route('account.order.cancel', $order->id) }}" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm ml-2">Hủy Đơn Hàng</button>
                                    </form>
                                @endif
                                @if($order->canBeConfirmedAsDelivered())
                                    <form method="POST" action="{{ route('account.order.confirm-delivery', $order->id) }}" style="display: inline;" onsubmit="return confirm('Bạn có chắc đã nhận được hàng? Hành động này không thể hoàn tác.')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm ml-2">✓ Đã Nhận Hàng</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items mb-4">
                            <h4>Sản Phẩm Đã Đặt</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sản Phẩm</th>
                                            <th>Kích Cỡ</th>
                                            <th>Màu Sắc</th>
                                            <th>Số Lượng</th>
                                            <th>Đơn Giá</th>
                                            <th>Thành Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->getFirstMediaUrl('images'))
                                                        <img src="{{ $item->product->getFirstMediaUrl('images') }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="img-thumbnail me-2" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</h6>
                                                        @if($item->product)
                                                            <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->size ?? 'N/A' }}</td>
                                            <td>{{ $item->color ?? 'N/A' }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ number_format($item->unit_price) }}₫</td>
                                            <td>{{ number_format($item->total_price) }}₫</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Order Summary & Addresses -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Billing Address -->
                                @if($order->billing_address)
                                <div class="order-address mb-4">
                                    <h4>Địa Chỉ Thanh Toán</h4>
                                    <div class="address-card">
                                        <p><strong>{{ $order->billing_address['name'] ?? '' }}</strong></p>
                                        <p>{{ $order->billing_address['address'] ?? '' }}</p>
                                        <p>{{ $order->billing_address['city'] ?? '' }}, {{ $order->billing_address['state'] ?? '' }}</p>
                                        <p>{{ $order->billing_address['zip'] ?? '' }}</p>
                                        @if(isset($order->billing_address['phone']))
                                            <p>Điện thoại: {{ $order->billing_address['phone'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <!-- Shipping Address -->
                                @if($order->shipping_address)
                                <div class="order-address mb-4">
                                    <h4>Địa Chỉ Giao Hàng</h4>
                                    <div class="address-card">
                                        <p><strong>{{ $order->shipping_address['name'] ?? '' }}</strong></p>
                                        <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                        <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}</p>
                                        <p>{{ $order->shipping_address['zip'] ?? '' }}</p>
                                        @if(isset($order->shipping_address['phone']))
                                            <p>Điện thoại: {{ $order->shipping_address['phone'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <!-- Order Summary -->
                                <div class="order-summary">
                                    <h4>Tóm Tắt Đơn Hàng</h4>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Tạm tính:</td>
                                            <td class="text-end">{{ number_format($order->subtotal) }}₫</td>
                                        </tr>
                                        @if($order->shipping_amount > 0)
                                        <tr>
                                            <td>Phí vận chuyển:</td>
                                            <td class="text-end">{{ number_format($order->shipping_amount) }}₫</td>
                                        </tr>
                                        @endif
                                        @if($order->tax_amount > 0)
                                        <tr>
                                            <td>Thuế:</td>
                                            <td class="text-end">{{ number_format($order->tax_amount) }}₫</td>
                                        </tr>
                                        @endif
                                        @if($order->discount_amount > 0)
                                        <tr>
                                            <td>Giảm giá:</td>
                                            <td class="text-end text-success">-{{ number_format($order->discount_amount) }}₫</td>
                                        </tr>
                                        @endif
                                        @if($order->coupon_discount > 0)
                                        <tr>
                                            <td>Mã giảm giá ({{ $order->coupon_code }}):</td>
                                            <td class="text-end text-success">-{{ number_format($order->coupon_discount) }}₫</td>
                                        </tr>
                                        @endif
                                        <tr class="border-top">
                                            <td><strong>Tổng cộng:</strong></td>
                                            <td class="text-end"><strong>{{ number_format($order->total_price) }}₫</strong></td>
                                        </tr>
                                    </table>

                                    <!-- Payment Info -->
                                    <div class="payment-info mt-3">
                                        <h5>Thông Tin Thanh Toán</h5>
                                        <p>Phương thức: <strong>{{ $order->payment_method ?? 'Chưa xác định' }}</strong></p>
                                        <p>Trạng thái: 
                                            <span class="badge badge-{{ $order->payment_status_color }}">
                                                {{ ucfirst($order->payment_status ?? 'pending') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="order-actions text-center mt-4">
                            <a href="{{ route('account.index') }}" class="btn btn-secondary">Quay Lại Tài Khoản</a>
                            @if($order->isPaid())
                                <a href="#" class="btn btn-primary">In Hóa Đơn</a>
                            @endif
                            
                            @if($order->canBeConfirmedAsDelivered())
                                <div class="alert alert-info mt-3 delivery-confirmation">
                                    <h5><i class="fas fa-truck"></i> Đơn hàng đã được gửi đi</h5>
                                    <p>Bạn đã nhận được hàng? Vui lòng xác nhận để hoàn tất đơn hàng.</p>
                                    <form method="POST" action="{{ route('account.order.confirm-delivery', $order->id) }}" style="display: inline;" onsubmit="return confirm('Bạn có chắc đã nhận được hàng?\n\nSau khi xác nhận:\n- Trạng thái đơn hàng: ĐÃ GIAO\n- Trạng thái thanh toán: ĐÃ THANH TOÁN\n- Hoa hồng affiliate sẽ được xử lý (nếu có)\n\nHành động này không thể hoàn tác!')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check-circle"></i> Xác Nhận Đã Nhận Hàng
                                        </button>
                                    </form>
                                </div>
                            @endif
                            
                            @if($order->isAwaitingDeliveryConfirmation())
                                <div class="alert alert-warning mt-3">
                                    <h6><i class="fas fa-clock"></i> Đang chờ xác nhận giao hàng</h6>
                                    <p class="mb-0">Đơn hàng đã được gửi đi. Vui lòng xác nhận khi bạn nhận được hàng.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Order Details Area ==-->
@endsection

@section('styles')
<style>
.order-details-wrapper {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.address-card {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #007bff;
}

.badge-lg {
    font-size: 14px;
    padding: 8px 12px;
}

.order-summary {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
}

.payment-info {
    background: #fff;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #dee2e6;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.delivery-confirmation {
    text-align: center;
    padding: 20px;
    margin: 20px 0;
    border: 2px dashed #28a745;
    border-radius: 10px;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
}

.delivery-confirmation h5 {
    color: #155724;
    margin-bottom: 15px;
}

.delivery-confirmation .btn {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endsection