<x-filament-panels::page>
    @php
        // Convert Enum to value for easy comparison
        use App\Enums\OrderStatus;
        $statusValue = $record->status instanceof OrderStatus ? $record->status->value : $record->status;
    @endphp

    <style>
        /* Modern Order View Styling */
        .order-view-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .card-body {
            padding: 2rem;
        }

        .order-header-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 1.5rem;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: translateX(5px);
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .info-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: #212529;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .status-new { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .status-processing { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .status-shipped { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
        .status-delivered { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; }
        .status-cancelled { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }

        .customer-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .customer-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .customer-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-center;
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 1rem;
        }

        .product-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .product-item:hover {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
            transform: translateX(10px);
        }

        .product-grid {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1.5rem;
            align-items: center;
        }

        .product-image {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-details h4 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .product-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .product-badge {
            background: #e9ecef;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #495057;
        }

        .price-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
        }

        .price-row:last-child {
            border-bottom: none;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 2px solid #667eea;
        }

        .price-label {
            font-weight: 600;
            color: #495057;
        }

        .price-value {
            font-weight: 700;
            color: #212529;
        }

        .total-price {
            font-size: 1.5rem;
            color: #667eea;
        }

        .address-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 1.5rem;
            border-left: 4px solid #667eea;
        }

        .icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #667eea;
            color: white;
            margin-right: 0.75rem;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #667eea, #764ba2);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-dot {
            position: absolute;
            left: -2rem;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-center;
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            z-index: 1;
        }

        .timeline-content {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-action {
            flex: 1;
            min-width: 200px;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(67, 233, 123, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(240, 147, 251, 0.4);
        }

        .payment-info {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            border: 2px solid #e9ecef;
        }

        .payment-method-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            background: #e9ecef;
            color: #495057;
        }

        @media (max-width: 768px) {
            .order-header-grid {
                grid-template-columns: 1fr;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .btn-action {
                min-width: 100%;
            }
        }
    </style>

    <div class="order-view-container">
        {{-- Order Header Card --}}
        <div class="order-card">
            <div class="card-header">
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                                Đơn hàng #{{ $record->order_number }}
                            </h2>
                            <p style="opacity: 0.9;">Ngày đặt: {{ $record->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            @php
                                $statusValue = $record->status instanceof \App\Enums\OrderStatus ? $record->status->value : $record->status;
                                $statusClasses = [
                                    'new' => 'status-new',
                                    'processing' => 'status-processing',
                                    'shipped' => 'status-shipped',
                                    'delivered' => 'status-delivered',
                                    'cancelled' => 'status-cancelled',
                                ];
                                $statusClass = $statusClasses[$statusValue] ?? 'status-new';
                                $statusLabel = $record->status instanceof \App\Enums\OrderStatus ? $record->status->getLabel() : __($record->status);
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="4"/>
                                </svg>
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="order-header-grid">
                    <div class="info-box">
                        <div class="info-label">
                            <svg style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                            Tổng Tiền
                        </div>
                        <div class="info-value">{{ number_format($record->total_amount, 0, ',', '.') }}₫</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            <svg style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"/>
                            </svg>
                            Trạng Thái Thanh Toán
                        </div>
                        <div class="info-value">{{ __($record->payment_status) }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            <svg style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"/>
                            </svg>
                            Phương Thức
                        </div>
                        <div class="info-value">{{ __($record->payment_method) }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            <svg style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                            </svg>
                            Số Sản Phẩm
                        </div>
                        <div class="info-value">{{ $record->items->count() }} sản phẩm</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            {{-- Left Column --}}
            <div>
                {{-- Customer Info Card --}}
                <div class="order-card">
                    <div class="card-body">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #212529;">
                            <span class="icon-badge">
                                <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </span>
                            Thông Tin Khách Hàng
                        </h3>

                        @if($record->user)
                            <div class="customer-card">
                                <div style="position: relative; z-index: 1;">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($record->user->name, 0, 2)) }}
                                    </div>
                                    <h4 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $record->user->name }}</h4>
                                    <p style="opacity: 0.9; margin-bottom: 1rem;">
                                        <svg style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                        {{ $record->user->email }}
                                    </p>
                                    @if($record->user->phone)
                                        <p style="opacity: 0.9;">
                                            <svg style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                            {{ $record->user->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p style="color: #6c757d;">Khách vãng lai</p>
                        @endif
                    </div>
                </div>

                {{-- Products List Card --}}
                <div class="order-card" style="margin-top: 2rem;">
                    <div class="card-body">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #212529;">
                            <span class="icon-badge">
                                <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"/>
                                </svg>
                            </span>
                            Sản Phẩm Đã Đặt
                        </h3>

                        @foreach($record->items as $item)
                            <div class="product-item">
                                <div class="product-grid">
                                    <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') ?: asset('img/shop/placeholder.webp') }}"
                                         alt="{{ $item->product->name }}"
                                         class="product-image">

                                    <div class="product-details">
                                        <h4>{{ $item->product->name }}</h4>
                                        <div class="product-meta">
                                            <span class="product-badge">Số lượng: {{ $item->quantity }}</span>
                                            <span class="product-badge">Đơn giá: {{ number_format($item->unit_price, 0, ',', '.') }}₫</span>
                                            @if($item->color)
                                                <span class="product-badge">Màu: {{ $item->color }}</span>
                                            @endif
                                            @if($item->size)
                                                <span class="product-badge">Size: {{ $item->size }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div style="text-align: right;">
                                        <div style="font-size: 0.75rem; color: #6c757d; margin-bottom: 0.5rem;">Thành tiền</div>
                                        <div style="font-size: 1.25rem; font-weight: 700; color: #667eea;">
                                            {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}₫
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Price Summary --}}
                        <div class="price-summary">
                            <div class="price-row">
                                <span class="price-label">Tạm tính:</span>
                                <span class="price-value">{{ number_format($record->subtotal ?? 0, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Phí vận chuyển:</span>
                                <span class="price-value">{{ number_format($record->shipping_amount ?? 0, 0, ',', '.') }}₫</span>
                            </div>
                            @if($record->discount_amount && $record->discount_amount > 0)
                                <div class="price-row">
                                    <span class="price-label">Giảm giá:</span>
                                    <span class="price-value" style="color: #28a745;">-{{ number_format($record->discount_amount, 0, ',', '.') }}₫</span>
                                </div>
                            @endif
                            <div class="price-row">
                                <span class="price-label" style="font-size: 1.25rem;">TỔNG CỘNG:</span>
                                <span class="price-value total-price">{{ number_format($record->total_amount ?? 0, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div>
                {{-- Shipping Address Card --}}
                <div class="order-card">
                    <div class="card-body">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #212529;">
                            <span class="icon-badge">
                                <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </span>
                            Địa Chỉ Giao Hàng
                        </h3>

                        @if($record->address)
                            <div class="address-card">
                                @if($record->address->fullname)
                                    <p style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">{{ $record->address->fullname }}</p>
                                @endif
                                @if($record->address->phone)
                                    <p style="margin-bottom: 0.5rem;">
                                        <svg style="width: 14px; height: 14px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                        </svg>
                                        {{ $record->address->phone }}
                                    </p>
                                @endif
                                @if($record->address->street)
                                    <p style="margin-bottom: 0.25rem;">{{ $record->address->street }}</p>
                                @endif
                                @if($record->address->city || $record->address->state)
                                    <p style="margin-bottom: 0.25rem;">
                                        {{ $record->address->city }}
                                        @if($record->address->city && $record->address->state), @endif
                                        {{ $record->address->state }}
                                    </p>
                                @endif
                                @if($record->address->country)
                                    <p style="margin-bottom: 0.25rem;">{{ $record->address->country }}</p>
                                @endif
                            </div>
                        @else
                            <p style="color: #6c757d;">Chưa có thông tin địa chỉ giao hàng</p>
                        @endif
                    </div>
                </div>

                {{-- Order Timeline Card --}}
                <div class="order-card" style="margin-top: 2rem;">
                    <div class="card-body">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #212529;">
                            <span class="icon-badge">
                                <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                </svg>
                            </span>
                            Lịch Sử Đơn Hàng
                        </h3>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot">
                                    <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                </div>
                                <div class="timeline-content">
                                    <div style="font-weight: 700; margin-bottom: 0.25rem;">Đơn hàng được tạo</div>
                                    <div style="color: #6c757d; font-size: 0.875rem;">{{ $record->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>

                            @if(in_array($statusValue, ['processing', 'shipped', 'delivered']))
                                <div class="timeline-item">
                                    <div class="timeline-dot">
                                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                    </div>
                                    <div class="timeline-content">
                                        <div style="font-weight: 700; margin-bottom: 0.25rem;">Đang xử lý</div>
                                        <div style="color: #6c757d; font-size: 0.875rem;">Đơn hàng đang được xử lý</div>
                                    </div>
                                </div>
                            @endif

                            @if(in_array($statusValue, ['shipped', 'delivered']))
                                <div class="timeline-item">
                                    <div class="timeline-dot">
                                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                    </div>
                                    <div class="timeline-content">
                                        <div style="font-weight: 700; margin-bottom: 0.25rem;">Đang giao hàng</div>
                                        <div style="color: #6c757d; font-size: 0.875rem;">
                                            @if($record->shipped_at)
                                                {{ $record->shipped_at->format('d/m/Y H:i') }}
                                            @else
                                                Đơn hàng đã được giao cho đơn vị vận chuyển
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($statusValue === 'delivered')
                                <div class="timeline-item">
                                    <div class="timeline-dot" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                    </div>
                                    <div class="timeline-content">
                                        <div style="font-weight: 700; margin-bottom: 0.25rem;">Đã giao hàng</div>
                                        <div style="color: #6c757d; font-size: 0.875rem;">
                                            @if($record->delivered_at)
                                                {{ $record->delivered_at->format('d/m/Y H:i') }}
                                            @else
                                                Đơn hàng đã được giao thành công
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($statusValue === 'cancelled')
                                <div class="timeline-item">
                                    <div class="timeline-dot" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                        </svg>
                                    </div>
                                    <div class="timeline-content">
                                        <div style="font-weight: 700; margin-bottom: 0.25rem;">Đã hủy</div>
                                        <div style="color: #6c757d; font-size: 0.875rem;">Đơn hàng đã bị hủy</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Notes Card (if any) --}}
                @if($record->notes)
                    <div class="order-card" style="margin-top: 2rem;">
                        <div class="card-body">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #212529;">
                                <span class="icon-badge">
                                    <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </span>
                                Ghi Chú
                            </h3>
                            <div style="background: #f8f9fa; border-radius: 10px; padding: 1rem; color: #495057;">
                                {{ $record->notes }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
