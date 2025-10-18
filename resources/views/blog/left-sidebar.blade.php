@extends('layouts.frontend')

@section('title', 'Blog Left Sidebar - Shoe Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/blog-styles.css') }}">
@endpush

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
  <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Blog</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Blog Left Sidebar</li>
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
          <div class="col-lg-4">
            <!--== Start Sidebar Area ==-->
            <div class="sidebar-area blog-sidebar-area">
              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Tìm kiếm</h4>
                <div class="sidebar-body">
                  <div class="sidebar-search">
                    <form action="{{ route('blog.left-sidebar') }}" method="GET">
                      @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                      @endif
                      <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
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
                      @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories as $category)
                        <li>
                          <a href="{{ route('blog.left-sidebar', ['category' => $category->id]) }}">
                            {{ $category->name }}
                            <span>({{ $category->posts_count }})</span>
                          </a>
                        </li>
                        @endforeach
                      @else
                        <li><a href="{{ route('blog') }}">Xu hướng thời trang <span>({{ rand(5, 20) }})</span></a></li>
                        <li><a href="{{ route('blog') }}">Cách chọn giày <span>({{ rand(3, 15) }})</span></a></li>
                        <li><a href="{{ route('blog') }}">Bảo quản giày <span>({{ rand(2, 10) }})</span></a></li>
                        <li><a href="{{ route('blog') }}">Phối đồ <span>({{ rand(4, 18) }})</span></a></li>
                        <li><a href="{{ route('blog') }}">Thương hiệu giày <span>({{ rand(1, 8) }})</span></a></li>
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              <div class="sidebar-item">
                <h4 class="sidebar-title">Bài viết mới nhất</h4>
                <div class="sidebar-body">
                  <div class="sidebar-recent-posts">
                    @if(isset($recentPosts) && $recentPosts->count() > 0)
                      @foreach($recentPosts as $recentPost)
                      <div class="recent-post-item">
                        <div class="recent-post-thumb">
                          <a href="{{ route('blog.details', $recentPost->slug) }}">
                            @if($recentPost->getFirstMediaUrl('post-images'))
                              <img src="{{ $recentPost->getFirstMediaUrl('post-images') }}" width="80" height="80" alt="{{ $recentPost->title }}">
                            @else
                              <img src="{{ asset('img/blog/recent-' . (($loop->index % 4) + 1) . '.webp') }}" width="80" height="80" alt="{{ $recentPost->title }}">
                            @endif
                          </a>
                        </div>
                        <div class="recent-post-content">
                          <h6 class="title">
                            <a href="{{ route('blog.details', $recentPost->slug) }}">
                              {{ Str::limit($recentPost->title, 50) }}
                            </a>
                          </h6>
                          <span class="date">{{ $recentPost->published_at ? $recentPost->published_at->format('d/m/Y') : $recentPost->created_at->format('d/m/Y') }}</span>
                        </div>
                      </div>
                      @endforeach
                    @else
                      @for($i = 1; $i <= 4; $i++)
                      <div class="recent-post-item">
                        <div class="recent-post-thumb">
                          <a href="{{ route('blog.details') }}">
                            <img src="{{ asset('img/blog/recent-' . $i . '.webp') }}" width="80" height="80" alt="Recent Post">
                          </a>
                        </div>
                        <div class="recent-post-content">
                          <h6 class="title"><a href="{{ route('blog.details') }}">{{ ['Cách chọn giày phù hợp với dáng chân', 'Xu hướng thời trang giày 2024', 'Bảo quản giày da hiệu quả', 'Phối đồ với giày sneaker'][($i-1)] }}</a></h6>
                          <span class="date">{{ now()->subDays($i * 3)->format('d/m/Y') }}</span>
                        </div>
                      </div>
                      @endfor
                    @endif
                  </div>
                </div>
              </div>
              <!--== End Sidebar Item ==-->
            </div>
            <!--== End Sidebar Area ==-->
          </div>
          <div class="col-lg-8">
            <div class="row">
              @if(isset($posts) && $posts->count() > 0)
                @foreach($posts as $post)
                <div class="col-md-6">
                  <!--== Start Blog Item ==-->
                  <div class="post-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($loop->index * 100) }}">
                    <div class="inner-content">
                      <div class="thumb">
                        <a href="{{ route('blog.details', $post->slug) }}">
                          @if($post->getFirstMediaUrl('post-images'))
                            <img src="{{ $post->getFirstMediaUrl('post-images') }}" width="370" height="260" alt="{{ $post->title }}">
                          @else
                            <img src="{{ asset('img/blog/' . (($loop->index % 6) + 1) . '.webp') }}" width="370" height="260" alt="{{ $post->title }}">
                          @endif
                        </a>
                      </div>
                      <div class="content">
                        <div class="meta-post">
                          <ul>
                            <li class="post-date">
                              <i class="fa fa-calendar"></i>
                              <a href="{{ route('blog') }}">
                                {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                              </a>
                            </li>
                            <li class="author-info">
                              <i class="fa fa-user"></i>
                              <a href="{{ route('blog') }}">
                                {{ $post->author ? $post->author->name : 'Admin' }}
                              </a>
                            </li>
                            @if($post->category)
                            <li class="category-info">
                              <i class="fa fa-folder"></i>
                              <a href="{{ route('blog.left-sidebar', ['category' => $post->category->id]) }}">
                                {{ $post->category->name }}
                              </a>
                            </li>
                            @endif
                          </ul>
                        </div>
                        <h4 class="title">
                          <a href="{{ route('blog.details', $post->slug) }}">
                            {{ Str::limit($post->title, 60) }}
                          </a>
                        </h4>
                        <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                        <a class="post-btn" href="{{ route('blog.details', $post->slug) }}">Đọc thêm</a>
                      </div>
                    </div>
                  </div>
                  <!--== End Blog Item ==-->
                </div>
                @endforeach
              @else
                <div class="col-12">
                  <div class="empty-state">
                    <i class="fa fa-newspaper-o" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
                    <h3>Không tìm thấy bài viết</h3>
                    <p>Hiện tại chưa có bài viết nào được đăng hoặc không có bài viết nào khớp với từ khóa tìm kiếm của bạn.</p>
                    <a href="{{ route('blog.left-sidebar') }}">Xem tất cả bài viết</a>
                  </div>
                </div>
              @endif
            </div>

            <!--== Start Pagination ==-->
            @if(isset($posts) && $posts->hasPages())
            <div class="row">
              <div class="col-12">
                <nav class="pagination-area">
                  <ul class="page-numbers">
                    {{-- Previous Page Link --}}
                    @if ($posts->onFirstPage())
                        <li><span class="page-number prev disabled">Trước</span></li>
                    @else
                        <li><a class="page-number prev" href="{{ $posts->previousPageUrl() }}">Trước</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <li><span class="page-number active">{{ $page }}</span></li>
                        @else
                            <li><a class="page-number" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($posts->hasMorePages())
                        <li><a class="page-number next" href="{{ $posts->nextPageUrl() }}">Sau</a></li>
                    @else
                        <li><span class="page-number next disabled">Sau</span></li>
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
            @endif
            <!--== End Pagination ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Blog Area ==-->
</main>
@endsection
