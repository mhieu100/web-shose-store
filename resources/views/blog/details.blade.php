@extends('layouts.frontend')

@section('title', 'Chi tiết bài viết - Shoe Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/blog-details.css') }}">
@endpush

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Chi tiết bài viết</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li><a href="{{ route('blog') }}">Blog</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Chi tiết bài viết</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Blog Details Area ==-->
    <section class="blog-details-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="blog-details-content">
              <div class="blog-details-thumb">
                @if($post->getFirstMediaUrl('post-images'))
                  <img src="{{ $post->getFirstMediaUrl('post-images') }}" alt="{{ $post->title }}">
                @else
                  <img src="{{ asset('img/blog/blog-details-1.webp') }}" alt="{{ $post->title }}">
                @endif
              </div>
              <div class="blog-details-info">
                <div class="blog-details-meta">
                  <div class="meta-info">
                    <ul>
                      <li class="post-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                      </li>
                      <li class="author-info">
                        <i class="fas fa-user"></i>
                        {{ $post->author ? $post->author->name : 'Admin' }}
                      </li>
                      @if($post->category)
                      <li class="post-category">
                        <i class="fas fa-folder"></i>
                        <a href="{{ route('blog', ['category' => $post->category->id]) }}">{{ $post->category->name }}</a>
                      </li>
                      @endif
                      <li class="post-comments">
                        <i class="fas fa-comments"></i>
                        <a href="#comments">Bình luận</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <h2 class="title">{{ $post->title }}</h2>
                <div class="blog-details-desc">
                  {!! $post->content !!}

                  <div class="blog-share">
                    <h5>Chia sẻ bài viết:</h5>
                    <div class="social-share">
                      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                      </a>
                      <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(request()->fullUrl()) }}" target="_blank">
                        <i class="fas fa-envelope"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!--== Start Blog Tags ==-->
              @if($post->tags && $post->tags->count() > 0)
              <div class="blog-details-tags">
                <div class="tags-wrap">
                  <h6>Tags:</h6>
                  <div class="tags-item">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('blog', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
                    @endforeach
                  </div>
                </div>
              </div>
              @endif
              <!--== End Blog Tags ==-->

              <!--== Start Author Info ==-->
              @if($post->author)
              <div class="blog-author-info">
                <div class="author-thumb">
                  @if($post->author->photo)
                    <img src="{{ asset('storage/' . $post->author->photo) }}" alt="{{ $post->author->name }}">
                  @else
                    <img src="{{ asset('img/blog/author.webp') }}" alt="{{ $post->author->name }}">
                  @endif
                </div>
                <div class="author-content">
                  <h5 class="name">{{ $post->author->name }}</h5>
                  <p class="designation">Tác giả</p>
                  <p class="desc">{{ $post->author->bio ?? 'Tác giả chia sẻ những kiến thức và kinh nghiệm về thời trang giày dép.' }}</p>
                </div>
              </div>
              @endif
              <!--== End Author Info ==-->

              <!--== Start Comments Area ==-->
              <div class="blog-comments-area" id="comments">
                <h4 class="comments-title">5 bình luận</h4>
                <div class="blog-comments-wrap">
                  @for($i = 1; $i <= 3; $i++)
                  <div class="comment-item">
                    <div class="comment-thumb">
                      <img src="{{ asset('img/blog/comment-' . $i . '.webp') }}" width="60" height="60" alt="Commenter">
                    </div>
                    <div class="comment-content">
                      <h6 class="comment-author">{{ ['Anh Minh', 'Chị Hương', 'Anh Tuấn'][$i-1] }}</h6>
                      <span class="comment-date">{{ now()->subDays($i)->format('d/m/Y H:i') }}</span>
                      <p>{{ ['Bài viết rất hay và bổ ích! Mình đã học được nhiều kiến thức về xu hướng giày thể thao mới.', 'Cảm ơn admin đã chia sẻ những thông tin hữu ích. Mình sẽ áp dụng ngay những gợi ý này.', 'Rất thích phong cách viết của blog này. Nội dung chi tiết và dễ hiểu.'][$i-1] }}</p>
                      <a href="#" class="comment-reply">Trả lời</a>
                    </div>
                  </div>
                  @endfor
                </div>

                <!--== Start Comment Form ==-->
                <div class="comment-form-wrap">
                  <h4 class="comment-form-title">Để lại bình luận</h4>
                  <form class="comment-form" action="#" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" name="name" placeholder="Họ tên *" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="email" name="email" placeholder="Email *" required>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <textarea name="comment" rows="6" placeholder="Nội dung bình luận *" required></textarea>
                        </div>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn-theme">Gửi bình luận</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!--== End Comment Form ==-->
              </div>
              <!--== End Comments Area ==-->
            </div>
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
              @if($recentPosts && $recentPosts->count() > 0)
              <div class="sidebar-item">
                <h4 class="sidebar-title">Bài viết mới nhất</h4>
                <div class="sidebar-body">
                  <div class="sidebar-recent-posts">
                    @foreach($recentPosts as $recent)
                    <div class="recent-post-item">
                      <div class="recent-post-thumb">
                        <a href="{{ route('blog.details', $recent->slug) }}">
                          @if($recent->getFirstMediaUrl('post-images'))
                            <img src="{{ $recent->getFirstMediaUrl('post-images') }}" alt="{{ $recent->title }}">
                          @else
                            <img src="{{ asset('img/blog/recent-1.webp') }}" alt="{{ $recent->title }}">
                          @endif
                        </a>
                      </div>
                      <div class="recent-post-content">
                        <h6 class="title">
                          <a href="{{ route('blog.details', $recent->slug) }}">{{ Str::limit($recent->title, 50) }}</a>
                        </h6>
                        <span class="date">{{ $recent->published_at ? $recent->published_at->format('d/m/Y') : $recent->created_at->format('d/m/Y') }}</span>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              @endif
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              @if($categories && $categories->count() > 0)
              <div class="sidebar-item">
                <h4 class="sidebar-title">Danh mục</h4>
                <div class="sidebar-body">
                  <div class="sidebar-category">
                    <ul class="category-list">
                      <li>
                        <a href="{{ route('blog') }}">
                          Tất cả 
                          <span>({{ $totalPosts ?? 0 }})</span>
                        </a>
                      </li>
                      @foreach($categories as $category)
                      <li>
                        <a href="{{ route('blog', ['category' => $category->id]) }}">
                          {{ $category->name }} 
                          <span>({{ $category->posts_count ?? 0 }})</span>
                        </a>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
              @endif
              <!--== End Sidebar Item ==-->

              <!--== Start Sidebar Item ==-->
              @if($popularTags && $popularTags->count() > 0)
              <div class="sidebar-item">
                <h4 class="sidebar-title">Tags</h4>
                <div class="sidebar-body">
                  <div class="sidebar-tags">
                    <div class="tags-cloud">
                      @foreach($popularTags as $tag)
                      <a href="{{ route('blog', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
              @endif
              <!--== End Sidebar Item ==-->

            </div>
            <!--== End Sidebar Area ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Blog Details Area ==-->
</main>
@endsection
