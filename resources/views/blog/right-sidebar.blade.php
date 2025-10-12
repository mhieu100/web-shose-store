@extends('layouts.frontend')

@section('title', 'Blog Right Sidebar - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Blog</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Blog Right Sidebar</li>
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
          <div class="col-lg-8">
            <div class="row">
              @for($i = 1; $i <= 6; $i++)
              <div class="col-md-6">
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
                        'Xu hướng giày thể thao mới nhất',
                        'Cách chọn giày phù hợp',
                        'Bí quyết bảo quản giày da',
                        'Top thương hiệu giày hot',
                        'Giày cao gót thời trang',
                        'Phong cách street style'
                      ][$i - 1] }}</a></h4>
                      <p>{{ [
                        'Khám phá những xu hướng giày thể thao được yêu thích nhất năm nay...',
                        'Hướng dẫn chi tiết cách chọn giày phù hợp với từng dáng chân...',
                        'Những mẹo hay để bảo quản giày da luôn bền đẹp...',
                        'Điểm danh những thương hiệu giày được ưa chuộng...',
                        'Lịch sử và xu hướng phát triển của giày cao gót...',
                        'Cách mix & match giày với phong cách street style...'
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
          <div class="col-lg-4">
            <!--== Start Sidebar Area ==-->
            <div class="sidebar-area blog-sidebar-area">
              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Tìm kiếm</h4>
                <div class="sidebar-body">
                  <div class="sidebar-search">
                    <form action="{{ route('blog') }}" method="GET">
                      <input type="text" name="search" placeholder="Tìm kiếm bài viết...">
                      <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Danh mục</h4>
                <div class="sidebar-body">
                  <div class="sidebar-category">
                    <ul class="category-list">
                      <li><a href="{{ route('blog') }}">Xu hướng thời trang <span>({{ rand(5, 20) }})</span></a></li>
                      <li><a href="{{ route('blog') }}">Cách chọn giày <span>({{ rand(3, 15) }})</span></a></li>
                      <li><a href="{{ route('blog') }}">Bảo quản giày <span>({{ rand(2, 10) }})</span></a></li>
                      <li><a href="{{ route('blog') }}">Phối đồ <span>({{ rand(4, 18) }})</span></a></li>
                      <li><a href="{{ route('blog') }}">Thương hiệu giày <span>({{ rand(1, 8) }})</span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Tags</h4>
                <div class="sidebar-body">
                  <div class="sidebar-tags">
                    <div class="tags-cloud">
                      <a href="{{ route('blog') }}">Sneakers</a>
                      <a href="{{ route('blog') }}">Giày thể thao</a>
                      <a href="{{ route('blog') }}">Thời trang</a>
                      <a href="{{ route('blog') }}">Nike</a>
                      <a href="{{ route('blog') }}">Adidas</a>
                      <a href="{{ route('blog') }}">Xu hướng 2024</a>
                      <a href="{{ route('blog') }}">Street style</a>
                      <a href="{{ route('blog') }}">Giày cao gót</a>
                    </div>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->
            </div>
            <!--== End Sidebar Area ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Blog Area ==-->
</main>
@endsection