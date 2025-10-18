@extends('layouts.frontend')

@section('title', 'Wishlist - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Wishlist</h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li>Wishlist</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Wishlist Area Wrapper ==-->
    <section class="shopping-wishlist-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(count($wishlistItems) > 0)
                        <div class="shopping-wishlist-table table-responsive">
                            <table class="table wishlist-table text-center">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumb">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-stock-status">Stock Status</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlistItems as $item)
                                        <tr class="cart-wishlist-item wishlist-item" data-product-id="{{ $item->product->id }}">
                                            <td class="product-remove">
                                                <a href="#" class="remove-from-wishlist" data-product-id="{{ $item->product->id }}">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                            <td class="product-thumb">
                                                <a href="{{ route('product.show', $item->product->id) }}" class="product-image-link">
                                                    <div class="product-image-wrapper">
                                                        @if($item->product->getFirstMediaUrl('product-images'))
                                                            <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                                                 class="product-image"
                                                                 alt="{{ $item->product->name }}"
                                                                 loading="lazy">
                                                        @else
                                                            <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                                 class="product-image placeholder-image"
                                                                 alt="{{ $item->product->name }}"
                                                                 loading="lazy">
                                                        @endif
                                                        <div class="image-overlay">
                                                            <i class="fa fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <h4 class="title">
                                                    <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                </h4>
                                            </td>
                                            <td class="product-stock-status">
                                                @if($item->product->qty > 0)
                                                    <span class="stock in-stock">In Stock</span>
                                                @else
                                                    <span class="stock out-of-stock">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td class="product-price">
                                                <span class="price">{{ number_format($item->product->price, 0, ',', '.') }} VNĐ</span>
                                            </td>
                                            <td class="product-action">
                                                @if($item->product->qty > 0)
                                                    <div class="action-buttons">
                                                        <button class="btn btn-primary add-to-cart"
                                                                style="background-color: #007bff !important; color: white !important; border: 1px solid #007bff !important; padding: 10px 16px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;"
                                                                data-product-id="{{ $item->product->id }}"
                                                                data-product-name="{{ $item->product->name }}"
                                                                data-product-price="{{ $item->product->sale_price ?? $item->product->price }}"
                                                                data-product-colors='{!! $item->product->colors ? json_encode($item->product->colors) : "[]" !!}'
                                                                data-product-sizes='{!! $item->product->sizes ? json_encode($item->product->sizes) : "[]" !!}'
                                                                title="Add to Cart">
                                                            <i class="fa fa-shopping-cart"></i>
                                                            Add to Cart
                                                        </button>
                                                        <button class="btn btn-outline-secondary quick-view-btn"
                                                                style="background-color: transparent !important; color: #6c757d !important; border: 1px solid #6c757d !important; padding: 10px 12px; font-size: 13px; display: inline-flex; align-items: center;"
                                                                data-product-id="{{ $item->product->id }}"
                                                                title="Quick View">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                @else
                                                    <button class="btn btn-secondary" disabled
                                                            style="background-color: #6c757d !important; color: white !important; padding: 10px 16px; font-size: 13px;">
                                                        <i class="fa fa-times"></i>
                                                        Out of Stock
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-wishlist-area text-center">
                            <div class="empty-wishlist-content">
                                <i class="pe-7s-like" style="font-size: 80px; color: #ddd; margin-bottom: 20px;"></i>
                                <h3>Your wishlist is empty</h3>
                                <p>You haven't added any products to your wishlist yet.</p>
                                <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--== End Wishlist Area Wrapper ==-->

    <!-- Include Product Options Modal -->
    @include('components.product-options-modal')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
<style>
    /* Force table layout and column visibility */
    .shopping-wishlist-table {
        overflow-x: auto !important;
        width: 100% !important;
    }

    .wishlist-table {
        width: 100% !important;
        table-layout: auto !important;
        min-width: 900px !important;
    }

    .wishlist-table th,
    .wishlist-table td {
        display: table-cell !important;
        visibility: visible !important;
    }

    /* Force button visibility */
    .action-buttons {
        display: flex !important;
        gap: 8px !important;
        justify-content: center !important;
        flex-wrap: nowrap !important;
    }

    .action-buttons .btn,
    .action-buttons button {
        display: inline-flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        white-space: nowrap !important;
    }

    .action-buttons .btn-primary,
    .action-buttons button.btn-primary,
    .action-buttons .add-to-cart {
        background-color: #007bff !important;
        color: #ffffff !important;
        border: 1px solid #007bff !important;
    }

    .action-buttons .btn-outline-secondary,
    .action-buttons button.btn-outline-secondary {
        background-color: transparent !important;
        color: #6c757d !important;
        border: 1px solid #6c757d !important;
    }

    /* Ensure product-action column is visible */
    .product-action {
        width: 250px !important;
        min-width: 250px !important;
        display: table-cell !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/wishlist.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/product-options.js') }}"></script>
@endpush
