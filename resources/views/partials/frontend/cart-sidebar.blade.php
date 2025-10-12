<!--== Start Aside Cart Menu ==-->
<div class="aside-cart-wrapper offcanvas offcanvas-end" tabindex="-1" id="AsideOffcanvasCart" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h1 id="offcanvasRightLabel"></h1>
    <button class="btn-aside-cart-close" data-bs-dismiss="offcanvas" aria-label="Close">Shopping Cart <i class="fa fa-chevron-right"></i></button>
  </div>
  <div class="offcanvas-body">
    <ul class="aside-cart-product-list">
      <li class="product-list-item">
        <a href="#/" class="remove">×</a>
        <a href="{{ route('product.show', 1) }}">
          <img src="{{ asset('img/shop/product-mini/1.webp') }}" width="90" height="110" alt="Image-HasTech">
          <span class="product-title">Leather Mens Slipper</span>
        </a>
        <span class="product-price">1 × £69.99</span>
      </li>
      <li class="product-list-item">
        <a href="#/" class="remove">×</a>
        <a href="{{ route('product.show', 2) }}">
          <img src="{{ asset('img/shop/product-mini/2.webp') }}" width="90" height="110" alt="Image-HasTech">
          <span class="product-title">Quickiin Mens shoes</span>
        </a>
        <span class="product-price">1 × £20.00</span>
      </li>
    </ul>
    <p class="cart-total"><span>Subtotal:</span><span class="amount">£89.99</span></p>
    <a class="btn-theme" data-margin-bottom="10" href="{{ route('cart') }}">View cart</a>
    <a class="btn-theme" href="{{ route('checkout') }}">Checkout</a>
    <a class="d-block text-end lh-1" href="{{ route('checkout') }}"><img src="{{ asset('img/photos/paypal.webp') }}" width="133" height="26" alt="Has-image"></a>
  </div>
</div>
<!--== End Aside Cart Menu ==>