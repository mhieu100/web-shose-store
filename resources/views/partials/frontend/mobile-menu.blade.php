<!--== Start Aside Menu ==-->
<div class="aside-menu-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header">
    <h1 id="offcanvasMenuLabel" class="d-none"></h1>
    <button class="btn-aside-menu-close" data-bs-dismiss="offcanvas" aria-label="Close">Menu <i class="fa fa-chevron-left"></i></button>
  </div>
  <div class="offcanvas-body">
    <!--== Start Mobile Menu ==-->
    <nav class="aside-menu">
      <ul class="aside-menu-nav">
        <li class="menu-item-has-children">
          <a href="{{ route('home') }}">Trang chủ</a>
          <ul class="sub-menu">
            <li><a href="{{ route('home') }}">Trang chủ 1</a></li>
            <li><a href="{{ route('home.two') }}">Trang chủ 2</a></li>
          </ul>
        </li>
        <li><a href="{{ route('about') }}">Về chúng tôi</a></li>
        <li class="menu-item-has-children">
          <a href="#/">Trang</a>
          <ul class="sub-menu">
            <li><a href="{{ route('account') }}">Tài khoản</a></li>
            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
            <li><a href="{{ route('register') }}">Đăng ký</a></li>
            <li><a href="{{ route('404') }}">404</a></li>
          </ul>
        </li>
        <li class="menu-item-has-children">
          <a href="#/">Cửa hàng</a>
          <ul class="sub-menu">
            <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
            <li><a href="{{ route('shop.three-columns') }}">Cửa hàng 3 cột</a></li>
            <li><a href="{{ route('shop.four-columns') }}">Cửa hàng 4 cột</a></li>
            <li><a href="{{ route('cart') }}">Giỏ hàng</a></li>
            <li><a href="{{ route('checkout') }}">Thanh toán</a></li>
            <li><a href="{{ route('wishlist') }}">Yêu thích</a></li>
            <li><a href="{{ route('compare') }}">So sánh</a></li>
          </ul>
        </li>
        <li class="menu-item-has-children">
          <a href="#/">Blog</a>
          <ul class="sub-menu">
            <li><a href="{{ route('blog') }}">Blog</a></li>
            <li><a href="{{ route('blog.left-sidebar') }}">Blog trái</a></li>
            <li><a href="{{ route('blog.right-sidebar') }}">Blog phải</a></li>
          </ul>
        </li>
        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
      </ul>
    </nav>
    <!--== End Mobile Menu ==-->
    
    <!--== Start Mobile Menu Info ==-->
    <div class="aside-menu-info">
      <div class="aside-menu-contact">
        <p>Liên hệ: <a href="tel:0123456789">0123 456 789</a></p>
        <p>Email: <a href="mailto:info@shoestore.com">info@shoestore.com</a></p>
      </div>
      <div class="aside-menu-social">
        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
        <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
        <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
      </div>
    </div>
    <!--== End Mobile Menu Info ==-->
  </div>
</div>
<!--== End Aside Menu ==>