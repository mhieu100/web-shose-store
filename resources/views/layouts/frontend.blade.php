<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="@yield('description', 'Cửa hàng giày online hàng đầu Việt Nam - Chất lượng cao, giá cả hợp lý')"/>
    <meta name="keywords" content="@yield('keywords', 'giày dép, giày thể thao, giày cao gót, giày nam, giày nữ, cửa hàng giày, mua giày online, giày chính hãng')"/>
    <meta name="author" content="codecarnival"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Shoe Store'))</title>

    <!--== Favicon ==-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />

    <!--== Google Fonts ==-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">

    <!--== Bootstrap CSS ==-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <!--== Font Awesome Min Icon CSS ==-->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />
    <!--== Pe7 Stroke Icon CSS ==-->
    <link href="{{ asset('css/pe-icon-7-stroke.css') }}" rel="stylesheet" />
    <!--== Swiper CSS ==-->
    <link href="{{ asset('css/swiper.min.css') }}" rel="stylesheet" />
    <!--== Fancybox Min CSS ==-->
    <link href="{{ asset('css/fancybox.min.css') }}" rel="stylesheet" />
    <!--== Aos Min CSS ==-->
    <link href="{{ asset('css/aos.min.css') }}" rel="stylesheet" />

    <!--== Main Style CSS ==-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!--== Custom Tabs CSS ==-->
    <link href="{{ asset('css/custom-tabs.css') }}" rel="stylesheet" />
    <!--== Product Detail CSS ==-->
    <link href="{{ asset('css/product-detail.css') }}" rel="stylesheet" />

    @stack('styles')

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!--wrapper start-->
<div class="wrapper">
  <!--== Start Header Wrapper ==-->
  @include('partials.frontend.header')
  <!--== End Header Wrapper ==-->

  <!--== Start Main Content ==-->
  <main class="main-content">
    @yield('content')
  </main>
  <!--== End Main Content ==-->

  <!--== Start Footer Wrapper ==-->
  @include('partials.frontend.footer')
  <!--== End Footer Wrapper ==-->
</div>
<!--wrapper end-->

<!--== Scroll Top Button ==-->
<div id="scroll-to-top" class="scroll-to-top"><span class="fa fa-angle-up"></span></div>

<!--== Start Side Menu ==-->
@include('partials.frontend.side-menu')

<!--== Start Aside Cart Menu ==-->
@include('partials.frontend.cart-sidebar')

<!--== Start Aside Search Menu ==-->
@include('partials.frontend.search-sidebar')

<!--== Start Quick View Menu ==-->
@include('partials.frontend.quick-view')

<!--== Start Product Options Modal ==-->
@include('components.product-options-modal')

<!--== Javascript Files ==-->
<!--== Modernizr js ==-->
<script src="{{ asset('js/modernizr.js') }}"></script>
<!--== jQuery ==-->
<script src="{{ asset('js/jquery-main.js') }}"></script>
<!--== jQuery-migrate ==-->
<script src="{{ asset('js/jquery-migrate.js') }}"></script>
<!--== Popper ==-->
<script src="{{ asset('js/popper.min.js') }}"></script>
<!--== Bootstrap ==-->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!--== Aos ==-->
<script src="{{ asset('js/aos.min.js') }}"></script>
<!--== Parallax ==-->
<script src="{{ asset('js/parallax.min.js') }}"></script>
<!--== Swiper ==-->
<script src="{{ asset('js/swiper.min.js') }}"></script>
<!--== Appear ==-->
<script src="{{ asset('js/jquery.appear.js') }}"></script>
<!--== Fancybox ==-->
<script src="{{ asset('js/fancybox.min.js') }}"></script>
<!--== Waypoint ==-->
<script src="{{ asset('js/waypoint.js') }}"></script>
<!--== jQuery-ui ==-->
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>

<!--== Custom Scripts ==-->
<script src="{{ asset('js/custom.js') }}"></script>
<!--== Custom Tabs Scripts ==-->
<script src="{{ asset('js/custom-tabs.js') }}"></script>
<!--== Product Options Scripts ==-->
<script src="{{ asset('js/product-options.js') }}"></script>

<!--== Cart Sidebar Scripts ==-->
<script src="{{ asset('js/cart-sidebar.js') }}"></script>

<!--== Cart Animations CSS ==-->
<link rel="stylesheet" href="{{ asset('css/cart-animations.css') }}">

<!--== Cart Variants CSS ==-->
<link rel="stylesheet" href="{{ asset('css/cart-variants.css') }}">

@stack('scripts')

</body>
</html>
