@extends('layouts.frontend')

@section('title', 'Order Confirmation')

@section('content')
<!--== Start Page Header Area Wrapper ==-->
<div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
    <div class="container pt-90 pb-90">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-content text-center">
                    <h2 class="title">Order Confirmation</h2>
                    <nav class="breadcrumb-area">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('cart') }}">Cart</a></li>
                            <li><a href="{{ route('checkout') }}">Checkout</a></li>
                            <li class="breadcrumb-sep">//</li>
                            <li>Confirmation</li>
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
                    <h2 class="text-success mb-3">Order Placed Successfully!</h2>
                    <p class="text-muted mb-4">
                        Thank you for your order. We've received your order and will process it shortly.
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
                            Order Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Order Number:</strong>
                                <span class="text-primary">{{ $order->order_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Order Date:</strong>
                                {{ $order->created_at->format('M d, Y \a\t H:i A') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Payment Method:</strong>
                                <span class="badge bg-info">
                                    @switch($order->payment_method)
                                        @case('cod')
                                            Cash on Delivery
                                            @break
                                        @case('bank_transfer')
                                            Bank Transfer
                                            @break
                                        @case('paypal')
                                            PayPal
                                            @break
                                        @default
                                            {{ ucfirst($order->payment_method) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                <span class="badge bg-warning">{{ ucfirst($order->status->value ?? $order->status) }}</span>
                            </div>
                        </div>
                        @if($order->notes)
                        <div class="row">
                            <div class="col-12">
                                <strong>Order Notes:</strong>
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
                            Order Items
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
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
                                                        <small class="text-muted">Color: {{ $item->product_snapshot['color'] }}</small><br>
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
                                            ${{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="text-end align-middle">
                                            <strong>${{ number_format($item->total, 2) }}</strong>
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
                            Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="order-summary">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>${{ number_format($order->shipping_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tax:</span>
                                <span>${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="text-primary">${{ number_format($order->total_amount, 2) }}</strong>
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
                            Shipping Address
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
                                <strong>Phone:</strong> {{ $order->shipping_address['phone'] }}
                            @endif
                        </address>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">
                        <i class="fa fa-home me-2"></i>
                        Continue Shopping
                    </a>
                    <a href="#" class="btn btn-secondary" onclick="window.print()">
                        <i class="fa fa-print me-2"></i>
                        Print Order
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
