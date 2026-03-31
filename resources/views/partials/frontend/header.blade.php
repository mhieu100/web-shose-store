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
                                        <li class="number"><i class="fa fa-phone"></i><a href="tel://0123456789">+84 036
                                                593 536</a></li>
                                        <li class="email"><i class="fa fa-envelope"></i><a
                                                href="mailto://shose@example.com">shose@example.com</a></li>
                                        <li class="account dropdown">
                                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: inherit;">
                                                <i class="fa fa-user"></i>
                                                @auth
                                                    {{ auth()->user()->name }}
                                                @else
                                                    Tài khoản
                                                @endauth
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="min-width: 200px;">
                                                @auth
                                                    @if(Auth::user()->role?->name === 'admin')
                                                        <li><a class="dropdown-item py-2" href="{{ url('/admin') }}">Trang Admin</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                    @endif
                                                    <li><a class="dropdown-item py-2" href="{{ route('account.index') }}">Tài khoản của tôi</a></li>
                                                    @if(Auth::user()->isActiveAffiliate())
                                                        <li><a class="dropdown-item py-2" href="{{ route('affiliate.dashboard') }}">Dashboard CTV</a></li>
                                                    @else
                                                        <li><a class="dropdown-item py-2" href="{{ route('collaborator.register') }}">Đăng ký cộng tác viên</a></li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('logout') }}">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item py-2" style="border: none; background: none; width: 100%; text-align: left;">Đăng xuất</button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li><a class="dropdown-item py-2" href="{{ route('login') }}">Đăng nhập</a></li>
                                                    <li><a class="dropdown-item py-2" href="{{ route('register') }}">Đăng ký</a></li>
                                                @endauth
                                            </ul>
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

                                <li class="has-submenu position-static"><a href="{{ route('shop') }}"><span>Cửa hàng</span></a>
                                    <ul class="submenu-nav submenu-nav-mega column-2">
                                        <li class="mega-menu-item"><a href="{{ route('shop') }}" class="mega-title"><span>Danh mục</span></a>
                                            <ul>
                                                @forelse($headerCategories ?? [] as $category)
                                                    <li>
                                                        <a href="{{ route('shop', ['category' => $category->slug]) }}">
                                                            <span>{{ $category->name }}</span>
                                                            <span style="opacity: 0.6; font-size: 0.9em;">({{ $category->products_count }})</span>
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li><a href="{{ route('shop') }}"><span>Tất cả sản phẩm</span></a></li>
                                                @endforelse
                                                <li><a href="{{ route('shop') }}" style="color: #DC3E37; font-weight: 500;"><span>Xem tất cả danh mục →</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-item"><a href="{{ route('shop') }}" class="mega-title"><span>Thương hiệu</span></a>
                                            <ul>
                                                @forelse($headerBrands ?? [] as $brand)
                                                    <li>
                                                        <a href="{{ route('shop', ['brand' => $brand->slug]) }}">
                                                            <span>{{ $brand->name }}</span>
                                                            <span style="opacity: 0.6; font-size: 0.9em;">({{ $brand->products_count }})</span>
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li><a href="{{ route('shop') }}"><span>Tất cả sản phẩm</span></a></li>
                                                @endforelse
                                                <li><a href="{{ route('shop') }}" style="color: #DC3E37; font-weight: 500;"><span>Xem tất cả thương hiệu →</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('blog') }}"><span>Tin tức</span></a></li>
                                <li><a href="{{ route('contact') }}"><span>Liên hệ</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
