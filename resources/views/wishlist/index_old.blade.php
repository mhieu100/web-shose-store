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

    <!--== Start Shopping Cart Area ==-->
    <section class="shopping-cart-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart-form table-responsive">
                        <form action="#" method="post">
                            @csrf
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumb">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-stock">Stock Status</th>
                                        <th class="product-action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wishlistItems as $item)
                                        <tr class="cart-product-item" data-product-id="{{ $item->product->id }}">
                                            <td class="product-remove">
                                                <a href="#" class="remove-from-wishlist" data-product-id="{{ $item->product->id }}">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                            <td class="product-thumb">
                                                <a href="{{ route('product.show', $item->product->id) }}">
                                                    @if($item->product->getFirstMediaUrl('product-images'))
                                                        <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}" 
                                                             width="90" height="110" alt="{{ $item->product->name }}">
                                                    @else
                                                        <img src="{{ asset('img/shop/placeholder.webp') }}" 
                                                             width="90" height="110" alt="{{ $item->product->name }}">
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <h4 class="title">
                                                    <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                </h4>
                                                @if($item->product->brand)
                                                    <small class="text-muted">{{ $item->product->brand->name }}</small>
                                                @endif
                                            </td>
                                            <td class="product-price">
                                                <span class="price">
                                                    @if($item->product->old_price && $item->product->old_price > $item->product->price)
                                                        <del class="text-muted">${{ number_format($item->product->old_price, 2) }}</del><br>
                                                    @endif
                                                    ${{ number_format($item->product->price, 2) }}
                                                </span>
                                            </td>
                                            <td class="product-stock">
                                                @if($item->product->qty > 0)
                                                    <span class="stock in-stock">In Stock ({{ $item->product->qty }})</span>
                                                @else
                                                    <span class="stock out-of-stock">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td class="product-action">
                                                @if($item->product->qty > 0)
                                                    <button type="button" class="btn-cart add-to-cart-btn" data-product-id="{{ $item->product->id }}">
                                                        Add to Cart
                                                    </button>
                                                @else
                                                    <button type="button" class="btn-cart disabled" disabled>
                                                        Out of Stock
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-wishlist">
                                                    <i class="fa fa-heart-o fa-3x text-muted mb-3"></i>
                                                    <h4>Your wishlist is empty</h4>
                                                    <p class="text-muted">Add products you love to your wishlist for easy access later.</p>
                                                    <a href="{{ route('shop') }}" class="btn-theme btn-flat">Continue Shopping</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    @if($wishlistItems->count() > 0)
                                        <tr class="actions">
                                            <td class="border-0" colspan="6">
                                                <button type="button" class="clear-wishlist">Clear Wishlist</button>
                                                <a href="{{ route('shop') }}" class="btn-theme btn-flat">Continue Shopping</a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Shopping Cart Area ==-->
@endsection

@push('scripts')
<script src="{{ asset('js/wishlist.js') }}"></script>
<style>
/* Wishlist Styling to match Cart */
.shopping-cart-area .shopping-cart-form {
    margin-bottom: 50px;
}

.shopping-cart-area .table thead th {
    border-top: none;
    border-bottom: 2px solid #f1f1f1;
    padding: 20px 15px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: #f8f9fa;
}

.shopping-cart-area .table tbody tr {
    border-bottom: 1px solid #f1f1f1;
}

.shopping-cart-area .table tbody td {
    padding: 25px 15px;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f1f1;
}

.product-thumb img {
    border-radius: 4px;
    transition: all 0.3s ease;
}

.product-thumb:hover img {
    transform: scale(1.05);
}

.product-name .title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

.product-name .title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name .title a:hover {
    color: #eb3e32;
}

.product-price .price {
    font-size: 16px;
    font-weight: 600;
    color: #eb3e32;
}

.product-price del {
    color: #999;
    font-size: 14px;
    font-weight: 400;
}

.product-stock .stock {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-stock .in-stock {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.product-stock .out-of-stock {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.btn-cart {
    background-color: #eb3e32;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-cart:hover {
    background-color: #d63384;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(235, 62, 50, 0.4);
}

.btn-cart.disabled {
    background-color: #6c757d;
    cursor: not-allowed;
}

.btn-cart.disabled:hover {
    background-color: #6c757d;
    transform: none;
    box-shadow: none;
}

.product-remove a {
    color: #dc3545;
    font-size: 18px;
    transition: all 0.3s ease;
}

.product-remove a:hover {
    color: #c82333;
    transform: scale(1.2);
}

/* Actions Row */
.actions td {
    text-align: center;
    padding: 30px 15px;
}

.clear-wishlist {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right: 15px;
}

.clear-wishlist:hover {
    background-color: #c82333;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
}

.btn-theme.btn-flat {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-theme.btn-flat:hover {
    background-color: #555;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    color: #fff;
}

/* Empty Wishlist */
.empty-wishlist {
    padding: 60px 20px;
    text-align: center;
}

.empty-wishlist i {
    color: #eb3e32;
    opacity: 0.6;
    margin-bottom: 20px;
}

.empty-wishlist h4 {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.empty-wishlist p {
    color: #666;
    margin-bottom: 30px;
    font-size: 16px;
}

/* Responsive */
@media (max-width: 768px) {
    .shopping-cart-area .table thead th,
    .shopping-cart-area .table tbody td {
        padding: 15px 8px;
        font-size: 12px;
    }
    
    .product-thumb img {
        max-width: 60px;
        height: auto;
    }
    
    .product-name .title {
        font-size: 14px;
    }
    
    .btn-cart {
        padding: 8px 16px;
        font-size: 11px;
    }
    
    .clear-wishlist,
    .btn-theme.btn-flat {
        padding: 10px 20px;
        font-size: 12px;
        margin: 5px;
    }
}

/* Animation for item removal */
.cart-product-item {
    transition: all 0.3s ease;
}

.cart-product-item.removing {
    opacity: 0;
    transform: translateX(-100%);
}
</style>
@endpush