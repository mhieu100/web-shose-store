@extends('layouts.frontend')

@section('title', 'Trang không tìm thấy - 404')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">404 - Không tìm thấy trang</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>404</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Page Not Found Area ==-->
    <section class="page-not-found-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="page-not-found-content text-center">
              <h1 class="title">404</h1>
              <h2 class="sub-title">Rất tiếc! Trang bạn tìm kiếm không tồn tại.</h2>
              <p class="desc">Trang bạn đang tìm kiếm có thể đã bị xóa, đổi tên hoặc tạm thời không khả dụng.</p>
              <a href="{{ route('home') }}" class="btn-theme">Về trang chủ</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Page Not Found Area ==-->
</main>
@endsection

@push('styles')
<style>
.page-not-found-content .title {
    font-size: 150px;
    font-weight: bold;
    color: #f1f1f1;
    line-height: 1;
    margin-bottom: 20px;
}
.page-not-found-content .sub-title {
    font-size: 28px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}
.page-not-found-content .desc {
    font-size: 16px;
    color: #666;
    margin-bottom: 30px;
}
</style>
@endpush