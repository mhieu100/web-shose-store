<!--== Start Side Menu ==-->
<div class="off-canvas-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h1 id="offcanvasExampleLabel"></h1>
        <button class="btn-menu-close" data-bs-dismiss="offcanvas" aria-label="Close">menu <i
                class="fa fa-chevron-left"></i></button>
    </div>
    <div class="offcanvas-body">
        <div class="info-items">
            <ul>
                <li class="number"><a href="tel://0123456789"><i class="fa fa-phone"></i>+00 123 456 789</a></li>
                <li class="email"><a href="mailto://demo@example.com"><i
                            class="fa fa-envelope"></i>demo@example.com</a></li>
                <li class="account"><a href="{{ route('login') }}"><i class="fa fa-user"></i>Account</a></li>
            </ul>
        </div>
        <!-- Mobile Menu Start -->
        <div class="mobile-menu-items">
            <ul class="nav-menu">

                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="#">Pages</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('account.index') }}">Account</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        <li><a href="{{ route('404') }}">Page Not Found</a></li>
                    </ul>
                </li>
                <li><a href="#">Shop</a>
                    <ul class="sub-menu">
                        <li><a href="#">Shop Layout</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('shop.three-columns') }}">Shop 3 Column</a></li>
                                <li><a href="{{ route('shop.four-columns') }}">Shop 4 Column</a></li>
                                <li><a href="{{ route('shop') }}">Shop Left Sidebar</a></li>
                                <li><a href="{{ route('shop.right-sidebar') }}">Shop Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Single Product</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('product.normal') }}">Single Product Normal</a></li>
                                <li><a href="{{ route('product.variable') }}">Single Product Variable</a></li>
                                <li><a href="{{ route('product.group') }}">Single Product Group</a></li>
                                <li><a href="{{ route('product.affiliate') }}">Single Product Affiliate</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Others Pages</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('cart') }}">Shopping Cart</a></li>
                                <li><a href="{{ route('checkout') }}">Checkout</a></li>
                                <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                <li><a href="{{ route('compare') }}">Compare</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Blog</a>
                    <ul class="sub-menu">
                        <li><a href="#">Blog Layout</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('blog') }}">Blog Grid</a></li>
                                <li><a href="{{ route('blog.left-sidebar') }}">Blog Left Sidebar</a></li>
                                <li><a href="{{ route('blog.right-sidebar') }}">Blog Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Single Blog</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('blog.details') }}">Blog Details</a></li>
                                <li><a href="{{ route('blog.details-left') }}">Blog Details Left Sidebar</a></li>
                                <li><a href="{{ route('blog.details-right') }}">Blog Details Right Sidebar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
        <!-- Mobile Menu End -->
    </div>
</div>
<!--== End Side Menu ==-->
