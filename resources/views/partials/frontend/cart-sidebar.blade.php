<!--== Start Aside Cart Menu ==-->
<div class="aside-cart-wrapper offcanvas offcanvas-end" tabindex="-1" id="AsideOffcanvasCart" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h1 id="offcanvasRightLabel"></h1>
    <button class="btn-aside-cart-close" data-bs-dismiss="offcanvas" aria-label="Close">Shopping Cart <i class="fa fa-chevron-right"></i></button>
  </div>
  <div class="offcanvas-body">
    @php
        $cartItems = collect([]);
        $cartTotal = 0;
        $cartCount = 0;

        if (auth()->check()) {
            $cartItems = auth()->user()->carts()
                ->with(['product.media'])
                ->latest()
                ->get();

            $cartTotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $cartCount = $cartItems->sum('quantity');
        }
    @endphp

    <div id="cart-sidebar-content">
        @if($cartItems->count() > 0)
            <ul class="aside-cart-product-list" id="sidebar-cart-items">
                @foreach($cartItems as $item)
                    <li class="product-list-item" data-cart-item-id="{{ $item->id }}">
                        <a href="#" class="remove" data-product-id="{{ $item->shop_product_id }}" title="Xóa sản phẩm">×</a>
                        <a href="{{ route('product.show', $item->shop_product_id) }}">
                            @if($item->product->getFirstMediaUrl('product-images'))
                                <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                     width="90" height="110" alt="{{ $item->product->name }}">
                            @else
                                <img src="{{ asset('img/shop/placeholder.webp') }}"
                                     width="90" height="110" alt="{{ $item->product->name }}">
                            @endif
                            <span class="product-title">{{ $item->product->name }}</span>
                            @if($item->color || $item->size)
                                <span class="product-variants">
                                    @if($item->color)
                                        <small>Màu: {{ $item->color }}</small>
                                    @endif
                                    @if($item->size)
                                        <small>{{ $item->color ? ' | ' : '' }}Size: {{ $item->size }}</small>
                                    @endif
                                </span>
                            @endif
                        </a>
                        <span class="product-price">{{ $item->quantity }} × {{ number_format($item->price, 0, ',', '.') }} VNĐ</span>
                    </li>
                @endforeach
            </ul>

            <p class="cart-total">
                <span>Tổng cộng:</span>
                <span class="amount" id="sidebar-cart-total">{{ number_format($cartTotal, 0, ',', '.') }} VNĐ</span>
            </p>

            <a class="btn-theme" data-margin-bottom="10" href="{{ route('cart') }}">Xem giỏ hàng</a>
            <a class="btn-theme" href="{{ route('checkout') }}">Thanh toán</a>
            <a class="d-block text-end lh-1" href="{{ route('checkout') }}">
                <img src="{{ asset('img/photos/paypal.webp') }}" width="133" height="26" alt="PayPal">
            </a>
        @else
            <div class="empty-cart-message" id="empty-cart-message">
                <div class="text-center py-4">
                    <i class="pe-7s-shopbag" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                    <h5>Giỏ hàng trống</h5>
                    <p class="text-muted">Chưa có sản phẩm nào trong giỏ hàng của bạn.</p>
                    <a href="{{ route('shop') }}" class="btn-theme">Tiếp tục mua sắm</a>
                </div>
            </div>
        @endif
    </div>
  </div>
</div>
<!--== End Aside Cart Menu ==>
