@extends('layouts.frontend')

@section('title', 'Wishlist - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
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
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumb">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-stock-status">Stock Status</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-action">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlistItems as $item)
                                        <tr class="cart-wishlist-item" data-product-id="{{ $item->product->id }}">
                                            <td class="product-remove">
                                                <a href="#" class="remove-from-wishlist" data-product-id="{{ $item->product->id }}">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                            <td class="product-thumb">
                                                <a href="{{ route('product.show', $item->product->id) }}">
                                                    @if($item->product->getFirstMediaUrl('default'))
                                                        <img src="{{ $item->product->getFirstMediaUrl('default') }}" width="90" height="110" alt="{{ $item->product->name }}">
                                                    @else
                                                        <img src="{{ asset('img/shop/placeholder.webp') }}" width="90" height="110" alt="{{ $item->product->name }}">
                                                    @endif
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
                                                <span class="price">${{ number_format($item->product->price, 2) }}</span>
                                            </td>
                                            <td class="product-action">
                                                @if($item->product->qty > 0)
                                                    <button class="btn-cart add-to-cart" data-product-id="{{ $item->product->id }}">Add to cart</button>
                                                @else
                                                    <button class="btn-cart" disabled>Out of Stock</button>
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
@endsection

@push('scripts')
<script src="{{ asset('js/wishlist.js') }}"></script>
@endpush
