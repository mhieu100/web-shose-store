@extends('layouts.frontend')

@section('title', 'Tài khoản của tôi - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Tài khoản của tôi</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Tài khoản</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Account Area ==-->
    <section class="account-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            @auth
              <div class="account-content">
                <h3>Chào mừng, {{ auth()->user()->name }}!</h3>
                <div class="account-info">
                  <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                  <p><strong>Vai trò:</strong> {{ auth()->user()->getRoleLabel() }}</p>
                </div>
                <div class="account-actions">
                  <a href="#" class="btn btn-primary">Đơn hàng của tôi</a>
                  <a href="#" class="btn btn-secondary">Cập nhật thông tin</a>
                  @if(auth()->user()->hasRole('admin'))
                    <a href="/admin" class="btn btn-danger">Vào Admin Panel</a>
                  @endif
                </div>
              </div>
            @else
              <div class="account-login">
                <p>Bạn chưa đăng nhập. Vui lòng <a href="{{ route('login') }}">đăng nhập</a> hoặc <a href="{{ route('register') }}">đăng ký</a> tài khoản mới.</p>
              </div>
            @endauth
          </div>
        </div>
      </div>
    </section>
    <!--== End Account Area ==-->
</main>
@endsection