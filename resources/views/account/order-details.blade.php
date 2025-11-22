@extends('layouts.frontend')

@section('title', 'Chi Tiết Đơn Hàng #' . $order->order_number ?? $order->id)

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0;">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content text-center">
                        <h2 class="title text-white" data-aos="fade-down" data-aos-duration="1000">
                            <i class="fas fa-receipt me-2"></i>Chi Tiết Đơn Hàng
                        </h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb justify-content-center">
                                <li><a href="{{ route('home') }}" class="text-white">Trang Chủ</a></li>
                                <li class="breadcrumb-sep text-white">//</li>
                                <li><a href="{{ route('account.index') }}" class="text-white">Tài Khoản</a></li>
                                <li class="breadcrumb-sep text-white">//</li>
                                <li class="text-white">Đơn Hàng #{{ $order->order_number ?? $order->id }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->


    <!--== Start Order Details Area ==-->
    <section class="order-details-area" style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Left Column: Order Info & Products -->
                <div class="col-lg-8">
                    <!-- Order Header Card -->
                    <div class="modern-card animate-slide-up">
                        <div class="card-header-gradient">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div class="order-info">
                                    <h3 class="order-number mb-2">
                                        <i class="fas fa-shopping-bag me-2"></i>
                                        Đơn Hàng #{{ $order->order_number ?? $order->id }}
                                    </h3>
                                    <p class="order-date mb-0">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        Đặt ngày {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="order-status-badge">
                                    @php
                                        $statusValue = is_object($order->status) ? $order->status->value : $order->status;
                                        $statusColors = [
                                            'new' => 'info',
                                            'processing' => 'warning',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                        $statusColor = $statusColors[$statusValue] ?? 'secondary';
                                    @endphp
                                    <span class="status-badge status-{{ $statusColor }}">
                                        <i class="fas fa-circle status-dot"></i>
                                        {{ $order->status->getLabel() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if($order->canBeCancelled() || $order->canBeConfirmedAsDelivered())
                        <div class="action-buttons-section">
                            @if($order->canBeCancelled())
                                <button type="button" class="action-btn btn-cancel" onclick="confirmCancelOrder()">
                                    <i class="fas fa-times-circle me-2"></i>
                                    Hủy Đơn Hàng
                                </button>
                                <form id="cancel-order-form" method="POST" action="{{ route('account.order.cancel', $order->id) }}" style="display: none;">
                                    @csrf
                                </form>
                            @endif

                            @if($order->canBeConfirmedAsDelivered())
                                <button type="button" class="action-btn btn-confirm" onclick="confirmDelivery()">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Xác Nhận Đã Nhận Hàng
                                </button>
                                <form id="confirm-delivery-form" method="POST" action="{{ route('account.order.confirm-delivery', $order->id) }}" style="display: none;">
                                    @csrf
                                </form>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Products Card -->
                    <div class="modern-card animate-slide-up" style="animation-delay: 0.1s;">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="fas fa-box-open me-2"></i>
                                Sản Phẩm Đã Đặt
                            </h4>
                        </div>
                        <div class="products-list">
                            @foreach($order->items as $item)
                            <div class="product-item">
                                <div class="product-image">
                                    @if($item->product && $item->product->getFirstMediaUrl('images'))
                                        <img src="{{ $item->product->getFirstMediaUrl('images') }}"
                                             alt="{{ $item->product->name }}"
                                             loading="lazy">
                                    @else
                                        <div class="product-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-details">
                                    <h5 class="product-name">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</h5>
                                    @if($item->product)
                                        <p class="product-sku">SKU: {{ $item->product->sku }}</p>
                                    @endif
                                    <div class="product-variants">
                                        @if($item->size)
                                            <span class="variant-badge">
                                                <i class="fas fa-ruler me-1"></i>{{ $item->size }}
                                            </span>
                                        @endif
                                        @if($item->color)
                                            <span class="variant-badge">
                                                <i class="fas fa-palette me-1"></i>{{ $item->color }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-pricing">
                                    <p class="product-quantity">x{{ $item->qty }}</p>
                                    <p class="product-price">{{ number_format($item->unit_price) }}₫</p>
                                    <p class="product-total">{{ number_format($item->total_price) }}₫</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column: Address & Summary -->
                <div class="col-lg-4">
                    <!-- Delivery Confirmation Alert -->
                    @if($order->canBeConfirmedAsDelivered())
                    <div class="modern-card delivery-alert animate-slide-up">
                        <div class="text-center">
                            <div class="delivery-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <h5 class="mb-3">Đơn hàng đã được gửi đi!</h5>
                            <p class="mb-4">Bạn đã nhận được hàng? Vui lòng xác nhận để hoàn tất đơn hàng.</p>
                            <button type="button" class="btn btn-success btn-lg w-100" onclick="confirmDelivery()">
                                <i class="fas fa-check-circle me-2"></i>
                                Xác Nhận Đã Nhận Hàng
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Shipping Address Card -->
                    @if($order->shipping_address)
                    <div class="modern-card animate-slide-up" style="animation-delay: 0.2s;">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="fas fa-shipping-fast me-2"></i>
                                Địa Chỉ Giao Hàng
                            </h4>
                        </div>
                        <div class="address-content">
                            <p class="address-name">{{ $order->shipping_address['name'] ?? '' }}</p>
                            <p class="address-line">{{ $order->shipping_address['address'] ?? '' }}</p>
                            <p class="address-line">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}</p>
                            <p class="address-line">{{ $order->shipping_address['zip'] ?? '' }}</p>
                            @if(isset($order->shipping_address['phone']))
                                <p class="address-phone">
                                    <i class="fas fa-phone me-2"></i>{{ $order->shipping_address['phone'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Order Summary Card -->
                    <div class="modern-card animate-slide-up" style="animation-delay: 0.3s;">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Tóm Tắt Đơn Hàng
                            </h4>
                        </div>
                        <div class="summary-content">
                            <div class="summary-row">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($order->subtotal) }}₫</span>
                            </div>
                            @if($order->shipping_amount > 0)
                            <div class="summary-row">
                                <span>Phí vận chuyển:</span>
                                <span>{{ number_format($order->shipping_amount) }}₫</span>
                            </div>
                            @endif
                            @if($order->tax_amount > 0)
                            <div class="summary-row">
                                <span>Thuế:</span>
                                <span>{{ number_format($order->tax_amount) }}₫</span>
                            </div>
                            @endif
                            @if($order->discount_amount > 0)
                            <div class="summary-row discount">
                                <span>Giảm giá:</span>
                                <span>-{{ number_format($order->discount_amount) }}₫</span>
                            </div>
                            @endif
                            @if($order->coupon_discount > 0)
                            <div class="summary-row discount">
                                <span>Mã giảm giá ({{ $order->coupon_code }}):</span>
                                <span>-{{ number_format($order->coupon_discount) }}₫</span>
                            </div>
                            @endif
                            <div class="summary-row total">
                                <span>Tổng cộng:</span>
                                <span>{{ number_format($order->total_price) }}₫</span>
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div class="payment-info-section">
                            <h5 class="mb-3">
                                <i class="fas fa-credit-card me-2"></i>
                                Thông Tin Thanh Toán
                            </h5>
                            <div class="payment-details">
                                <div class="payment-row">
                                    <span>Phương thức:</span>
                                    <strong>{{ $order->payment_method ?? 'Chưa xác định' }}</strong>
                                </div>
                                <div class="payment-row">
                                    <span>Trạng thái:</span>
                                    @php
                                        $paymentColors = [
                                            'pending' => 'warning',
                                            'completed' => 'success',
                                            'failed' => 'danger',
                                            'refunded' => 'info',
                                        ];
                                        $paymentColor = $paymentColors[$order->payment_status ?? 'pending'] ?? 'secondary';
                                    @endphp
                                    <span class="payment-badge badge-{{ $paymentColor }}">
                                        {{ ucfirst($order->payment_status ?? 'pending') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="text-center mt-4">
                        <a href="{{ route('account.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Quay Lại Tài Khoản
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Order Details Area ==-->
@endsection

@push('styles')
<style>
    /* Modern Card Styles */
    .modern-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    /* Card Header Gradient */
    .card-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 24px 30px;
    }

    .card-header {
        padding: 20px 30px;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-header h4 {
        color: #2d3748;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    /* Order Info */
    .order-number {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .order-date {
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
    }

    /* Status Badge */
    .order-status-badge {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-badge {
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        backdrop-filter: blur(10px);
    }

    .status-dot {
        font-size: 8px;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .status-badge.status-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .status-badge.status-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .status-badge.status-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .status-badge.status-success { background: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%); }
    .status-badge.status-danger { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

    /* Action Buttons Section */
    .action-buttons-section {
        padding: 20px 30px;
        background: #f8f9fa;
        border-top: 2px solid #e9ecef;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: #fff;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
    }

    .btn-confirm {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: #fff;
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(56, 239, 125, 0.4);
    }

    /* Products List */
    .products-list {
        padding: 0;
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
        transition: background 0.3s ease;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-item:hover {
        background: #f8f9fa;
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f8f9fa;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e0;
        font-size: 32px;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 8px 0;
    }

    .product-sku {
        font-size: 13px;
        color: #718096;
        margin: 0 0 8px 0;
    }

    .product-variants {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .variant-badge {
        padding: 4px 12px;
        background: #e8eaf6;
        color: #5e35b1;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    .product-pricing {
        text-align: right;
        min-width: 120px;
    }

    .product-quantity {
        font-size: 14px;
        color: #718096;
        margin: 0 0 4px 0;
    }

    .product-price {
        font-size: 14px;
        color: #718096;
        margin: 0 0 4px 0;
        text-decoration: line-through;
    }

    .product-total {
        font-size: 18px;
        font-weight: 700;
        color: #667eea;
        margin: 0;
    }

    /* Address Content */
    .address-content {
        padding: 20px 30px;
    }

    .address-name {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin: 0 0 12px 0;
    }

    .address-line {
        font-size: 14px;
        color: #718096;
        margin: 0 0 8px 0;
        line-height: 1.6;
    }

    .address-phone {
        font-size: 14px;
        color: #667eea;
        font-weight: 600;
        margin: 12px 0 0 0;
    }

    /* Summary Content */
    .summary-content {
        padding: 20px 30px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-row.discount {
        color: #38ef7d;
        font-weight: 600;
    }

    .summary-row.total {
        padding: 16px 0;
        border-top: 2px solid #667eea;
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-top: 8px;
    }

    .summary-row.total span:last-child {
        color: #667eea;
        font-size: 24px;
    }

    /* Payment Info Section */
    .payment-info-section {
        padding: 20px 30px;
        background: #f8f9fa;
        border-top: 2px solid #e9ecef;
    }

    .payment-info-section h5 {
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
    }

    .payment-details {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }

    .payment-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    /* Delivery Alert */
    .delivery-alert {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: 2px solid #28a745;
        padding: 30px;
    }

    .delivery-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #28a745;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin: 0 auto 20px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .delivery-alert h5 {
        color: #155724;
        font-weight: 700;
        font-size: 20px;
    }

    .delivery-alert p {
        color: #155724;
        font-size: 14px;
    }

    /* Animations */
    .animate-slide-up {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header-gradient {
            padding: 20px;
        }

        .order-number {
            font-size: 20px;
        }

        .order-status-badge {
            margin-top: 12px;
        }

        .action-buttons-section {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
            justify-content: center;
        }

        .product-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-pricing {
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-row.total span:last-child {
            font-size: 20px;
        }
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        padding: 16px 20px;
        border: none;
        margin-bottom: 24px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    .btn-close {
        opacity: 0.5;
    }

    .btn-close:hover {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmCancelOrder() {
        if (confirm('Bạn có chắc muốn hủy đơn hàng này?\n\nSau khi hủy:\n- Đơn hàng sẽ không thể khôi phục\n- Số tiền sẽ được hoàn lại (nếu đã thanh toán)')) {
            document.getElementById('cancel-order-form').submit();
        }
    }

    function confirmDelivery() {
        if (confirm('Bạn có chắc đã nhận được hàng?\n\nSau khi xác nhận:\n- Trạng thái đơn hàng: ĐÃ GIAO\n- Trạng thái thanh toán: ĐÃ THANH TOÁN\n- Hoa hồng affiliate sẽ được xử lý (nếu có)\n\nHành động này không thể hoàn tác!')) {
            document.getElementById('confirm-delivery-form').submit();
        }
    }

    // Auto dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });
    });
</script>
@endpush
