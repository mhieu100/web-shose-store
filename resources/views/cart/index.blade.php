@extends('layouts.frontend')

@section('title', 'Shopping Cart - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Shopping Cart</h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li>Shopping Cart</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Cart Area ==-->
    <section class="cart-area section-padding">
        <div class="container">
            @if($cartItems && $cartItems->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="cart-header d-flex justify-content-between align-items-center">
                            <div class="cart-info">
                                <h5 class="mb-1">My Shopping Cart</h5>
                                <p class="text-muted mb-0">{{ $cartCount }} {{ $cartCount == 1 ? 'item' : 'items' }} in your cart</p>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm clear-cart">
                                <i class="fa fa-trash-o me-1"></i>
                                Clear All
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <!-- Desktop Table Layout -->
                    <div class="cart-table-wrapper d-none d-lg-block">
                        @if($cartItems && $cartItems->count() > 0)
                            <table class="table cart-table">
                                <thead>
                                    <tr>
                                        <th width="8%">Remove</th>
                                        <th width="15%">Product</th>
                                        <th width="25%">Details</th>
                                        <th width="15%">Price</th>
                                        <th width="12%">Quantity</th>
                                        <th width="15%">Total</th>
                                        <th width="10%">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cartItems as $item)
                                        <tr class="cart-item" data-product-id="{{ $item->product->id }}">
                                            <td class="remove-col">
                                                <button type="button" class="btn-remove remove-from-cart"
                                                        data-product-id="{{ $item->product->id }}"
                                                        title="Remove from cart">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                            <td class="product-thumb">
                                                <div class="thumb-wrapper">
                                                    <a href="{{ route('product.show', $item->product->id) }}">
                                                        @if($item->product->getFirstMediaUrl('product-images'))
                                                            <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                                                 alt="{{ $item->product->name }}" class="img-fluid">
                                                        @else
                                                            <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                                 alt="{{ $item->product->name }}" class="img-fluid">
                                                        @endif
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="product-details">
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                    </h6>
                                                    @if($item->product->brand)
                                                        <p class="brand-name mb-1">{{ $item->product->brand->name }}</p>
                                                    @endif
                                                    
                                                    @if($item->color || $item->size)
                                                        <div class="product-variants mb-2">
                                                            @if($item->color)
                                                                <span class="variant-item">
                                                                    <i class="fas fa-circle" style="color: {{ $item->color_code ?? '#666' }};"></i>
                                                                    <small class="text-muted">{{ $item->color }}</small>
                                                                </span>
                                                            @endif
                                                            @if($item->size)
                                                                <span class="variant-item {{ $item->color ? 'ms-3' : '' }}">
                                                                    <i class="fas fa-ruler text-muted"></i>
                                                                    <small class="text-muted">Size {{ $item->size }}</small>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="product-meta">
                                                        <small class="added-date text-muted">
                                                            Added: {{ $item->created_at->format('M d, Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="price-col">
                                                <div class="price-wrapper">
                                                    @if($item->product->sale_price && $item->product->sale_price != $item->product->price)
                                                        <span class="old-price">${{ number_format($item->product->price, 2) }}</span>
                                                        <span class="current-price">${{ number_format($item->price, 2) }}</span>
                                                    @else
                                                        <span class="current-price">${{ number_format($item->price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="quantity-col">
                                                <div class="quantity-wrapper">
                                                    <button type="button" class="quantity-btn quantity-minus" data-product-id="{{ $item->product->id }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="quantity-input"
                                                           value="{{ $item->quantity }}"
                                                           min="1" max="100"
                                                           data-product-id="{{ $item->product->id }}">
                                                    <button type="button" class="quantity-btn quantity-plus" data-product-id="{{ $item->product->id }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="total-col">
                                                <span class="item-total" data-product-id="{{ $item->product->id }}">
                                                    ${{ number_format($item->quantity * $item->price, 2) }}
                                                </span>
                                            </td>
                                            <td class="stock-col">
                                                @if($item->product->stock > 0)
                                                    <span class="stock-badge in-stock">In Stock</span>
                                                @else
                                                    <span class="stock-badge out-of-stock">Out of Stock</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- Empty state will be handled below -->
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Mobile Card Layout -->
                    <div class="cart-mobile d-block d-lg-none">
                        @forelse($cartItems as $item)
                            <div class="cart-card mb-3" data-product-id="{{ $item->product->id }}">
                                <div class="card">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <div class="product-image">
                                                <a href="{{ route('product.show', $item->product->id) }}">
                                                    @if($item->product->getFirstMediaUrl('product-images'))
                                                        <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                                             alt="{{ $item->product->name }}" class="img-fluid">
                                                    @else
                                                        <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                             alt="{{ $item->product->name }}" class="img-fluid">
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-content p-3">
                                                <button type="button" class="btn-remove-mobile remove-from-cart"
                                                        data-product-id="{{ $item->product->id }}"
                                                        title="Remove from cart">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <h6 class="product-title mb-1">
                                                    <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                </h6>

                                                @if($item->product->brand)
                                                    <p class="brand-small mb-2">{{ $item->product->brand->name }}</p>
                                                @endif

                                                @if($item->color || $item->size)
                                                    <div class="product-variants-mobile mb-2">
                                                        @if($item->color)
                                                            <span class="variant-item-mobile">
                                                                <i class="fas fa-circle" style="color: {{ $item->color_code ?? '#666' }}; font-size: 10px;"></i>
                                                                <small class="text-muted">{{ $item->color }}</small>
                                                            </span>
                                                        @endif
                                                        @if($item->size)
                                                            <span class="variant-item-mobile {{ $item->color ? 'ms-2' : '' }}">
                                                                <i class="fas fa-ruler text-muted" style="font-size: 10px;"></i>
                                                                <small class="text-muted">{{ $item->size }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="price-mobile mb-2">
                                                    @if($item->product->sale_price && $item->product->sale_price != $item->product->price)
                                                        <span class="old-price-mobile">${{ number_format($item->product->price, 2) }}</span>
                                                        <span class="current-price-mobile">${{ number_format($item->price, 2) }}</span>
                                                    @else
                                                        <span class="current-price-mobile">${{ number_format($item->price, 2) }}</span>
                                                    @endif
                                                </div>

                                                <div class="quantity-mobile mb-2">
                                                    <div class="quantity-wrapper-mobile">
                                                        <button type="button" class="quantity-btn-mobile quantity-minus" data-product-id="{{ $item->product->id }}">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="quantity-input-mobile"
                                                               value="{{ $item->quantity }}"
                                                               min="1" max="100"
                                                               data-product-id="{{ $item->product->id }}">
                                                        <button type="button" class="quantity-btn-mobile quantity-plus" data-product-id="{{ $item->product->id }}">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <span class="item-total-mobile" data-product-id="{{ $item->product->id }}">
                                                        Total: ${{ number_format($item->quantity * $item->price, 2) }}
                                                    </span>
                                                </div>

                                                <div class="stock-mobile">
                                                    @if($item->product->stock > 0)
                                                        <span class="stock-badge-mobile in-stock">In Stock</span>
                                                    @else
                                                        <span class="stock-badge-mobile out-of-stock">Out of Stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty state will be handled below -->
                        @endforelse
                    </div>

                    <!-- Cart Summary -->
                    @if($cartItems && $cartItems->count() > 0)
                        <div class="cart-summary-wrapper mt-4">
                            <div class="row justify-content-end">
                                <div class="col-lg-6 col-md-8">
                                    <div class="cart-summary">
                                        <h5 class="summary-title">Cart Summary</h5>
                                        <div class="summary-row">
                                            <span class="summary-label">Subtotal ({{ $cartCount }} items):</span>
                                            <span class="summary-value cart-subtotal">${{ number_format($cartTotal, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Shipping:</span>
                                            <span class="summary-value">Free</span>
                                        </div>
                                        <div class="summary-row summary-total">
                                            <span class="summary-label">Total:</span>
                                            <span class="summary-value cart-grand-total">${{ number_format($cartTotal, 2) }}</span>
                                        </div>
                                        <div class="summary-actions">
                                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-continue">
                                                <i class="fa fa-arrow-left me-2"></i>
                                                Continue Shopping
                                            </a>
                                            <a href="#" class="btn btn-primary btn-checkout">
                                                <i class="fa fa-credit-card me-2"></i>
                                                Proceed to Checkout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Empty State -->
                    @if(!$cartItems || $cartItems->count() == 0)
                        <div class="empty-cart-state">
                            <div class="text-center py-5">
                                <div class="empty-icon mb-4">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <h4 class="empty-title">Your cart is empty</h4>
                                <p class="empty-subtitle">Browse our products and add items to your cart</p>
                                <a href="{{ route('shop') }}" class="btn-continue-shopping">
                                    <i class="fa fa-shopping-bag me-2"></i>
                                    Start Shopping
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--== End Cart Area ==-->

    <!-- Clear Cart Confirmation Modal -->
    <div class="modal fade" id="clearCartModal" tabindex="-1" aria-labelledby="clearCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clearCartModalLabel">
                        <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                        Confirm Clear Cart
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="fa fa-shopping-cart fa-3x text-muted"></i>
                        </div>
                        <h6 class="mb-3">Are you sure you want to clear your entire cart?</h6>
                        <p class="text-muted mb-0">
                            This action will remove all <strong><span id="modal-item-count">{{ $cartCount ?? 0 }}</span> <span id="modal-item-text">{{ $cartCount && $cartCount == 1 ? 'item' : 'items' }}</span></strong> from your cart and cannot be undone.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmClearCart">
                        <i class="fa fa-trash-o me-1"></i>
                        Yes, Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
