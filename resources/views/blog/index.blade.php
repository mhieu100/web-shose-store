@extends('layouts.frontend')

@section('title', 'Blog - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Blog</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Blog</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Blog Area ==-->
    <section class="blog-area blog-inner-area">
      <div class="container">
        <div class="row">
          @for($i = 1; $i <= 9; $i++)
          <div class="col-md-6 col-lg-4">
            <!--== Start Blog Item ==-->
            <div class="post-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($i * 100) }}">
              <div class="inner-content">
                <div class="thumb">
                  <a href="{{ route('blog.details') }}">
                    <img src="{{ asset('img/blog/' . (($i - 1) % 6 + 1) . '.webp') }}" width="370" height="260" alt="Blog {{ $i }}">
                  </a>
                </div>
                <div class="content">
                  <div class="meta-post">
                    <ul>
                      <li class="post-date"><i class="fa fa-calendar"></i><a href="{{ route('blog') }}">{{ now()->subDays($i * 2)->format('d/m/Y') }}</a></li>
                      <li class="author-info"><i class="fa fa-user"></i><a href="{{ route('blog') }}">{{ ['Admin', 'Biên tập viên', 'Chuyên gia'][($i - 1) % 3] }}</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('blog.details') }}">{{ [
                    'Xu hướng giày thể thao 2024 - Những mẫu hot nhất',
                    'Cách chọn giày phù hợp với từng dáng chân',
                    'Bí quyết bảo quản giày da luôn bền đẹp',
                    'Top 10 thương hiệu giày được yêu thích nhất',
                    'Giày cao gót - Từ cổ điển đến hiện đại',
                    'Phong cách street style với giày sneaker',
                    'Giày boot mùa đông - Ấm áp và thời trang',
                    'Cách phối giày với trang phục công sở',
                    'Giày thể thao cho người chạy bộ'
                  ][$i - 1] }}</a></h4>
                  <p>{{ [
                    'Khám phá những xu hướng giày thể thao mới nhất và hot nhất trong năm 2024...',
                    'Hướng dẫn chi tiết cách chọn giày phù hợp với dáng chân của bạn...',
                    'Những mẹo hay để bảo quản giày da luôn bền đẹp và sáng bóng...',
                    'Điểm danh những thương hiệu giày được khách hàng yêu thích nhất...',
                    'Lịch sử và xu hướng phát triển của giày cao gót qua các thời kỳ...',
                    'Cách mix & match giày sneaker với phong cách street style...',
                    'Lựa chọn giày boot phù hợp cho mùa đông ấm áp và thời trang...',
                    'Hướng dẫn phối giày với trang phục công sở chuyên nghiệp...',
                    'Những tiêu chí quan trọng khi chọn giày thể thao cho runner...'
                  ][$i - 1] }}</p>
                  <a class="post-btn" href="{{ route('blog.details') }}">Đọc thêm</a>
                </div>
              </div>
            </div>
            <!--== End Blog Item ==-->
          </div>
          @endfor
        </div>
        
        <!--== Start Pagination ==-->
        <div class="row">
          <div class="col-12">
            <nav class="pagination-area">
              <ul class="page-numbers">
                <li><a class="page-number prev" href="#">Trước</a></li>
                <li><a class="page-number active" href="#">1</a></li>
                <li><a class="page-number" href="#">2</a></li>
                <li><a class="page-number" href="#">3</a></li>
                <li><a class="page-number next" href="#">Sau</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <!--== End Pagination ==-->
      </div>
    </section>
    <!--== End Blog Area -->
</main>
@endsection