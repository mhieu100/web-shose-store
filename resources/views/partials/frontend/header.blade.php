<header class="main-header-wrapper position-relative">
    <div class="header-top">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="header-top-align">
                        <div class="header-top-align-start">
                            <div class="desc">
                                <p>Trên toàn thế giới Hoàn trả hàng miễn phí và giao hàng miễn phí</p>
                            </div>
                        </div>
                        <div class="header-top-align-end">
                            <div class="header-info-items">
                                <div class="info-items">
                                    <ul>
                                        <li class="number"><i class="fa fa-phone"></i><a href="tel://0123456789">+00 123
                                                456 789</a></li>
                                        <li class="email"><i class="fa fa-envelope"></i><a
                                                href="mailto://shose@example.com">shose@example.com</a></li>
                                        <li class="account">
                                            <i class="fa fa-user"></i>
                                            @auth
                                                <a href="{{ route('account.index') }}">{{ auth()->user()->name }}</a>
                                            @else
                                                <a href="{{ route('login') }}">Tài khoản</a>
                                            @endauth
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container pt--0 pb--0">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="header-middle-align">
                        <div class="header-middle-align-start">
                            <div class="header-logo-area">
                                <a href="{{ route('home') }}">
                                    <img class="logo-main" src="{{ asset('img/logo.webp') }}" width="131"
                                        height="34" alt="Logo" />
                                    <img class="logo-light" src="{{ asset('img/logo-light.webp') }}" width="131"
                                        height="34" alt="Logo" />
                                </a>
                            </div>
                        </div>
                        <div class="header-middle-align-center">
                            <div class="header-search-area">
                                <form class="header-searchbox" action="{{ route('shop.search') }}" method="GET">
                                    <input type="search" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm..."
                                        value="{{ request('q') }}">
                                    <button class="btn-submit" type="submit"><i class="pe-7s-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="header-middle-align-end">
                            <div class="header-action-area">
                                <div class="shopping-search">
                                    <button class="shopping-search-btn" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#AsideOffcanvasSearch" aria-controls="AsideOffcanvasSearch"><i
                                            class="pe-7s-search icon"></i></button>
                                </div>
                                <div class="shopping-wishlist">
                                    <a class="shopping-wishlist-btn" href="{{ route('wishlist') }}">
                                        <i class="pe-7s-like icon"></i>
                                    </a>
                                </div>
                                <div class="shopping-cart">
                                    <button class="shopping-cart-btn" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#AsideOffcanvasCart" aria-controls="offcanvasRightLabel">
                                        <i class="pe-7s-shopbag icon"></i>
                                        <sup class="shop-count" id="cart-count">
                                            @php
                                                $cartCount = 0;
                                                if (auth()->check()) {
                                                    $cartCount = \App\Models\Shop\Cart::where('user_id', auth()->id())->sum('quantity') ?? 0;
                                                }
                                            @endphp
                                            {{ $cartCount }}
                                        </sup>
                                    </button>
                                </div>
                                <button class="btn-menu" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
                                    <i class="pe-7s-menu"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-area header-default">
        <div class="container">
            <div class="row no-gutter align-items-center position-relative">
                <div class="col-12">
                    <div class="header-align">
                        <div class="header-navigation-area position-relative">
                            <ul class="main-menu nav">
                                <li><a href="{{ route('home') }}"><span>Trang chủ</span></a></li>
                                <li><a href="{{ route('about') }}"><span>Giới thiệu</span></a></li>
                                <li class="has-submenu"><a href="#/"><span>Trang</span></a>
                                    <ul class="submenu-nav">
                                        <li><a href="{{ route('account.index') }}"><span>Tài khoản</span></a></li>
                                        <li><a href="{{ route('login') }}"><span>Đăng nhập</span></a></li>
                                        <li><a href="{{ route('register') }}"><span>Đăng ký</span></a></li>
                                        <li><a href="{{ route('collaborator.register') }}"><span>Đăng ký cộng tác viên</span></a></li>
                                        @auth
                                            @if(Auth::user()->isActiveAffiliate())
                                                <li><a href="{{ route('affiliate.dashboard') }}"><span>Dashboard CTV</span></a></li>
                                            @endif
                                        @endauth
                                    
                                    </ul>
                                </li>
                                <li class="has-submenu position-static"><a href="#/"><span>Cửa hàng</span></a>
                                    <ul class="submenu-nav submenu-nav-mega column-3">
                                        <li class="mega-menu-item"><a href="#/" class="mega-title"><span>Bố cục
                                                    cửa hàng</span></a>
                                            <ul>
                                                <li><a href="{{ route('shop.three-columns') }}"><span>Shop 3
                                                            cột</span></a></li>
                                                <li><a href="{{ route('shop.four-columns') }}"><span>Shop 4
                                                            cột</span></a></li>
                                                <li><a href="{{ route('shop') }}"><span>Shop thanh bên trái</span></a>
                                                </li>
                                                <li><a href="{{ route('shop.right-sidebar') }}"><span>Shop thanh bên
                                                            phải</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a href="#/" class="mega-title"><span>Chi tiết
                                                    sản phẩm</span></a>
                                            <ul>
                                                <li><a href="{{ route('product.normal') }}"><span>Sản phẩm
                                                            thường</span></a></li>
                                                <li><a href="{{ route('product.variable') }}"><span>Sản phẩm
                                                            biến thể</span></a></li>
                                                <li><a href="{{ route('product.group') }}"><span>Sản phẩm
                                                            nhóm</span></a></li>
                                                <li><a href="{{ route('product.affiliate') }}"><span>Sản phẩm
                                                            liên kết</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a href="#/" class="mega-title"><span>Trang
                                                    khác</span></a>
                                            <ul>
                                                <li><a href="{{ route('cart') }}"><span>Giỏ hàng</span></a></li>
                                                <li><a href="{{ route('checkout') }}"><span>Thanh toán</span></a></li>
                                                <li><a href="{{ route('wishlist') }}"><span>Yêu thích</span></a></li>
                                                <li><a href="{{ route('compare') }}"><span>So sánh</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-submenu"><a href="#/"><span>Tin tức</span></a>
                                    <ul class="submenu-nav submenu-nav-mega">
                                        <li class="mega-menu-item"><a href="#/" class="mega-title">Bố cục
                                                tin tức</a>
                                            <ul>
                                                <li><a href="{{ route('blog') }}">Tin tức lưới</a></li>
                                                <li><a href="{{ route('blog.left-sidebar') }}">Tin tức thanh bên trái</a>
                                                </li>
                                                <li><a href="{{ route('blog.right-sidebar') }}">Tin tức thanh bên phải</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a href="#/" class="mega-title">Chi tiết
                                                tin tức</a>
                                            <ul>
                                                <li><a href="{{ route('blog.details') }}">Chi tiết tin tức</a></li>
                                                <li><a href="{{ route('blog.details-left') }}">Chi tiết thanh bên
                                                        trái</a></li>
                                                <li><a href="{{ route('blog.details-right') }}">Chi tiết thanh bên
                                                        phải</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('contact') }}"><span>Liên hệ</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
