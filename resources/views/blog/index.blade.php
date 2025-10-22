@extends('layouts.frontend')

@section('title', 'Blog - Shoe Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/blog-modern.css') }}">
@endpush

@section('content')
<div class="blog-modern">
  <div class="blog-container">
    
    <!-- Blog Header -->
    <div class="blog-header">
      <h1>Blog Giày Dép</h1>
      <p>Khám phá xu hướng thời trang và bí quyết chọn giày phù hợp</p>
    </div>

    <!-- Search Bar -->
    <div class="blog-search">
      <form action="{{ route('blog') }}" method="GET">
        <input type="search" 
               name="search" 
               placeholder="Tìm kiếm bài viết..." 
               value="{{ request('search') }}">
        <button type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>

    <!-- Main Content Grid -->
    <div class="blog-grid">
      
      <!-- Posts Section -->
      <div class="posts-section">
        <div class="posts-grid">
          @forelse($posts as $index => $post)
          <article class="blog-card">
            <div class="blog-card-image">
              <a href="{{ route('blog.details', $post->slug) }}">
                @if($post->getFirstMediaUrl('post-images'))
                  <img src="{{ $post->getFirstMediaUrl('post-images') }}" alt="{{ $post->title }}">
                @else
                  <img src="{{ asset('img/blog/' . (($index % 8) + 1) . '.webp') }}" alt="{{ $post->title }}">
                @endif
              </a>
            </div>
            
            <div class="blog-card-content">
              <div class="blog-card-meta">
                <span>
                  <i class="fas fa-calendar-alt"></i>
                  {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                </span>
                <span>
                  <i class="fas fa-user"></i>
                  {{ $post->author ? $post->author->name : 'Admin' }}
                </span>
              </div>
              
              <h2 class="blog-card-title">
                <a href="{{ route('blog.details', $post->slug) }}">{{ $post->title }}</a>
              </h2>
              
              <p class="blog-card-excerpt">{{ Str::limit(strip_tags($post->content), 120) }}</p>
              
              <div style="display: flex; justify-content: space-between; align-items: center;">
                @if($post->category)
                <a href="{{ route('blog', ['category' => $post->category->id]) }}" class="blog-card-category">
                  {{ $post->category->name }}
                </a>
                @endif
                
                <a href="{{ route('blog.details', $post->slug) }}" class="blog-read-more">
                  Đọc thêm <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </article>
          @empty
          <div class="blog-empty">
            <h3>Chưa có bài viết nào</h3>
            <p>Hãy quay lại sau để xem các bài viết mới nhất từ chúng tôi.</p>
          </div>
          @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="blog-pagination">
          <nav class="pagination-nav">
            {{-- Previous Page Link --}}
            @if ($posts->onFirstPage())
                <span class="page-number disabled">
                  <i class="fas fa-chevron-left"></i> Trước
                </span>
            @else
                <a class="page-number" href="{{ $posts->previousPageUrl() }}">
                  <i class="fas fa-chevron-left"></i> Trước
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                @if ($page == $posts->currentPage())
                    <span class="page-number active">{{ $page }}</span>
                @else
                    <a class="page-number" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($posts->hasMorePages())
                <a class="page-number" href="{{ $posts->nextPageUrl() }}">
                  Sau <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-number disabled">
                  Sau <i class="fas fa-chevron-right"></i>
                </span>
            @endif
          </nav>
        </div>
        @endif
      </div>

      <!-- Sidebar -->
      <aside class="blog-sidebar">
        
        <!-- Recent Posts Widget -->
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">Bài viết gần đây</h3>
          @foreach($recentPosts as $recent)
          <div class="recent-post-item">
            <div class="recent-post-thumb">
              <a href="{{ route('blog.details', $recent->slug) }}">
                @if($recent->getFirstMediaUrl('post-images'))
                  <img src="{{ $recent->getFirstMediaUrl('post-images') }}" alt="{{ $recent->title }}">
                @else
                  <img src="{{ asset('img/blog/s1.webp') }}" alt="{{ $recent->title }}">
                @endif
              </a>
            </div>
            <div class="recent-post-content">
              <h4 class="recent-post-title">
                <a href="{{ route('blog.details', $recent->slug) }}">{{ Str::limit($recent->title, 50) }}</a>
              </h4>
              <p class="recent-post-date">{{ $recent->published_at ? $recent->published_at->format('d/m/Y') : $recent->created_at->format('d/m/Y') }}</p>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Categories Widget -->
        <div class="sidebar-widget">
          <h3 class="sidebar-widget-title">Danh mục</h3>
          <ul class="categories-list">
            <li>
              <a href="{{ route('blog') }}">
                Tất cả
                <span class="category-count">{{ $posts->total() }}</span>
              </a>
            </li>
            @foreach($categories as $category)
            <li>
              <a href="{{ route('blog', ['category' => $category->id]) }}">
                {{ $category->name }}
                <span class="category-count">{{ $category->posts_count }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>

      </aside>
    </div>
  </div>
</div>
@endsection
