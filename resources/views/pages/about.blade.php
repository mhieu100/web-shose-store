@extends('layouts.frontend')

@section('title', 'Giới thiệu - Cửa hàng giày')

@section('content')
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
        ['label' => 'Giới thiệu', 'icon' => 'info-circle', 'active' => true]
    ]" />

    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Giới thiệu</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start About Area Wrapper ==-->
    <section class="about-area about-default-wrapper">
      <div class="container">
        <div class="about-item position-relative">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="about-thumb">
                <div class="shape-one scene">
                  <span class="scene-layer" data-depth=".2">
                    <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" width="570" height="368" alt="Premium Sneakers Collection">
                  </span>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="about-content">
                <h4 class="sub-title">Cuộc sống thông minh</h4>
                <h3 class="title">Với những đôi giày thông minh</h3>
                <p class="desc">Chúng tôi tự hào là một trong những cửa hàng giày hàng đầu, chuyên cung cấp các sản phẩm giày dép chất lượng cao từ các thương hiệu nổi tiếng. Với nhiều năm kinh nghiệm trong ngành, chúng tôi hiểu rõ nhu cầu và sở thích của khách hàng Việt Nam. Sứ mệnh của chúng tôi là mang đến cho khách hàng những sản phẩm tốt nhất với giá cả hợp lý và dịch vụ chăm sóc khách hàng xuất sắc.</p>
                <a class="btn-theme" href="{{ route('contact') }}">Liên hệ với chúng tôi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End About Area Wrapper ==-->

    <!--== Start Divider Area Wrapper ==-->
    <section class="bg-color-f2 position-relative z-index-1">
      <div class="container pt--0 pb--0">
        <div class="row divider-wrap divider-style1">
          <div class="col-lg-6">
            <div class="divider-content" data-title="MỚI">
              <h4 class="sub-title">Tiết kiệm đến 50%</h4>
              <h2 class="title">Toàn bộ cửa hàng online</h2>
              <p class="desc">Ưu đãi áp dụng cho tất cả giày dép & sản phẩm</p>
              <a class="btn-theme" href="{{ route('shop') }}">Mua ngay</a>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-layer-wrap">
        <div class="bg-layer-style z-index--1 parallax" data-speed="1.05" data-bg-img="https://images.unsplash.com/photo-1552346154-21d32810aba3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"></div>
      </div>
    </section>
    <!--== End Divider Area Wrapper ==-->

    <!--== Start Team Area Wrapper ==-->
    <section class="team-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Đội ngũ của chúng tôi</h3>
              <div class="desc">
                <p>Đội ngũ chuyên nghiệp, tận tâm và giàu kinh nghiệm trong ngành giày dép</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @if($teamMembers->count() > 0)
            @foreach($teamMembers as $index => $member)
            <div class="col-sm-6 col-lg-3">
              <!--== Start Team Item ==-->
              <div class="team-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('about') }}">
                      @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" width="270" height="270" alt="{{ $member->name }}">
                      @else
                        @php
                          $teamImages = [
                            'https://imgs.search.brave.com/ZWAQZlqGXbyX4ch2jiiGiEB0UXy6jVhtcsCOoEnun-E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/ZnJlZS1wc2QvM2Qt/cmVuZGVyLWF2YXRh/ci1jaGFyYWN0ZXJf/MjMtMjE1MDYxMTcy/OC5qcGc_c2VtdD1h/aXNfaHlicmlkJnc9/NzQwJnE9ODA',
                             'https://imgs.search.brave.com/ZWAQZlqGXbyX4ch2jiiGiEB0UXy6jVhtcsCOoEnun-E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/ZnJlZS1wc2QvM2Qt/cmVuZGVyLWF2YXRh/ci1jaGFyYWN0ZXJf/MjMtMjE1MDYxMTcy/OC5qcGc_c2VtdD1h/aXNfaHlicmlkJnc9/NzQwJnE9ODA', 'https://imgs.search.brave.com/ZWAQZlqGXbyX4ch2jiiGiEB0UXy6jVhtcsCOoEnun-E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/ZnJlZS1wc2QvM2Qt/cmVuZGVyLWF2YXRh/ci1jaGFyYWN0ZXJf/MjMtMjE1MDYxMTcy/OC5qcGc_c2VtdD1h/aXNfaHlicmlkJnc9/NzQwJnE9ODA', 'https://imgs.search.brave.com/ZWAQZlqGXbyX4ch2jiiGiEB0UXy6jVhtcsCOoEnun-E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/ZnJlZXBpay5jb20v/ZnJlZS1wc2QvM2Qt/cmVuZGVyLWF2YXRh/ci1jaGFyYWN0ZXJf/MjMtMjE1MDYxMTcy/OC5qcGc_c2VtdD1h/aXNfaHlicmlkJnc9/NzQwJnE9ODA',
                          ];
                        @endphp
                        <img src="{{ $teamImages[$index % count($teamImages)] }}" width="270" height="270" alt="{{ $member->name }}">
                      @endif
                    </a>
                    <div class="member-icons">
                      <a href="https://www.facebook.com/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                      <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                      <a href="https://www.pinterest.com/" target="_blank" rel="noopener"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                  </div>
                  <div class="content">
                    <h4 class="title"><a href="{{ route('about') }}">{{ $member->name }}</a></h4>
                    <p>Thành viên đội ngũ</p>
                  </div>
                </div>
              </div>
              <!--== End Team Item ==-->
            </div>
            @endforeach
          @else
            {{-- Fallback static team members if no data --}}
            <div class="col-sm-6 col-lg-3">
              <div class="team-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('about') }}"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" width="270" height="270" alt="Nguyễn Văn A"></a>
                    <div class="member-icons">
                      <a href="https://www.facebook.com/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                      <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                      <a href="https://www.pinterest.com/" target="_blank" rel="noopener"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                  </div>
                  <div class="content">
                    <h4 class="title"><a href="{{ route('about') }}">Nguyễn Văn A</a></h4>
                    <p>Giám đốc điều hành</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="team-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('about') }}"><img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" width="270" height="270" alt="Trần Thị B"></a>
                    <div class="member-icons">
                      <a href="https://www.facebook.com/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                      <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                      <a href="https://www.pinterest.com/" target="_blank" rel="noopener"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                  </div>
                  <div class="content">
                    <h4 class="title"><a href="{{ route('about') }}">Trần Thị B</a></h4>
                    <p>Trưởng phòng kinh doanh</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="team-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('about') }}"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" width="270" height="270" alt="Lê Văn C"></a>
                    <div class="member-icons">
                      <a href="https://www.facebook.com/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                      <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                      <a href="https://www.pinterest.com/" target="_blank" rel="noopener"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                  </div>
                  <div class="content">
                    <h4 class="title"><a href="{{ route('about') }}">Lê Văn C</a></h4>
                    <p>Chuyên gia sản phẩm</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="team-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('about') }}"><img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" width="270" height="270" alt="Phạm Thị D"></a>
                    <div class="member-icons">
                      <a href="https://www.facebook.com/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                      <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                      <a href="https://www.pinterest.com/" target="_blank" rel="noopener"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                  </div>
                  <div class="content">
                    <h4 class="title"><a href="{{ route('about') }}">Phạm Thị D</a></h4>
                    <p>Chăm sóc khách hàng</p>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
    <!--== End Team Area Wrapper ==-->

    <!--== Start Testimonial Area Wrapper ==-->
    <section class="testimonial-area bg-color-f2 position-relative z-index-1">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Ý kiến khách hàng</h3>
              <div class="desc">
                <p>Những đánh giá tích cực từ khách hàng của chúng tôi</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="swiper-container testimonial-slider-container">
              <div class="swiper-wrapper">
                @foreach($testimonials as $index => $testimonial)
                <div class="swiper-slide">
                  <!--== Start Testimonial Item ==-->
                  <div class="testimonial-item">
                    <div class="testi-inner-content">
                      <div class="testi-thumb">
                        <img src="{{ asset($testimonial['image']) }}" width="90" height="90" alt="{{ $testimonial['name'] }}">
                      </div>
                      <div class="testi-content">
                        <p>{{ $testimonial['content'] }}</p>
                        <div class="testi-author">
                          <div class="testi-info">
                            <span class="name"><a href="{{ route('about') }}">{{ $testimonial['name'] }}</a></span>
                            <span class="designation">{{ $testimonial['position'] }}</span>
                          </div>
                        </div>
                        <div class="testi-quote"><img src="{{ asset('img/icons/quote1.webp') }}" width="62" height="44" alt="Quote"></div>
                      </div>
                    </div>
                  </div>
                  <!--== End Testimonial Item ==-->
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="shape-group-style3">
        <div class="shape-group-one"><img src="{{ asset('img/shape/10.webp') }}" width="274" height="121" alt="Image-HasTech"></div>
        <div class="shape-group-two"><img src="{{ asset('img/shape/11.webp') }}" width="215" height="183" alt="Image-HasTech"></div>
        <div class="shape-group-three"><img src="{{ asset('img/shape/12.webp') }}" width="288" height="166" alt="Image-HasTech"></div>
        <div class="shape-group-four"><img src="{{ asset('img/shape/17.webp') }}" width="493" height="340" alt="Image-HasTech"></div>
      </div>
    </section>
    <!--== End Testimonial Area Wrapper ==-->

    <!--== Start Blog Area Wrapper ==-->
    <section class="blog-area blog-default-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Tin tức mới nhất</h3>
              <div class="desc">
                <p>Cập nhật những tin tức và xu hướng thời trang giày dép mới nhất</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @if($latestPosts->count() > 0)
            @foreach($latestPosts as $index => $post)
            <div class="col-md-6 col-lg-4">
              <!--== Start Blog Item ==-->
              <div class="post-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('blog.details', $post->slug ?? '') }}">
                      @if($post->getFirstMediaUrl('post-images'))
                        <img src="{{ $post->getFirstMediaUrl('post-images') }}" width="370" height="260" alt="{{ $post->title }}">
                      @else
                        <img src="{{ asset('img/blog/' . ($index + 1) . '.webp') }}" width="370" height="260" alt="{{ $post->title }}">
                      @endif
                    </a>
                  </div>
                  <div class="content">
                    <div class="meta-post">
                      <ul>
                        <li class="post-date"><i class="fa fa-calendar"></i><a href="{{ route('blog') }}">{{ $post->published_at ? $post->published_at->format('d/m/Y') : now()->format('d/m/Y') }}</a></li>
                        <li class="author-info"><i class="fa fa-user"></i><a href="{{ route('blog') }}">{{ $post->author->name ?? 'Admin' }}</a></li>
                      </ul>
                    </div>
                    <h4 class="title"><a href="{{ route('blog.details', $post->slug ?? '') }}">{{ Str::limit($post->title, 60) }}</a></h4>
                    <a class="post-btn" href="{{ route('blog.details', $post->slug ?? '') }}">Đọc thêm</a>
                  </div>
                </div>
              </div>
              <!--== End Blog Item ==-->
            </div>
            @endforeach
          @else
            {{-- Fallback static blog posts if no data --}}
            <div class="col-md-6 col-lg-4">
              <div class="post-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('blog.details') }}"><img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" width="370" height="260" alt="Xu hướng giày thể thao 2024"></a>
                  </div>
                  <div class="content">
                    <div class="meta-post">
                      <ul>
                        <li class="post-date"><i class="fa fa-calendar"></i><a href="{{ route('blog') }}">{{ now()->format('d/m/Y') }}</a></li>
                        <li class="author-info"><i class="fa fa-user"></i><a href="{{ route('blog') }}">Admin</a></li>
                      </ul>
                    </div>
                    <h4 class="title"><a href="{{ route('blog.details') }}">Xu hướng giày thể thao năm 2024</a></h4>
                    <a class="post-btn" href="{{ route('blog.details') }}">Đọc thêm</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="post-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('blog.details') }}"><img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" width="370" height="260" alt="Cách chăm sóc giày da"></a>
                  </div>
                  <div class="content">
                    <div class="meta-post">
                      <ul>
                        <li class="post-date"><i class="fa fa-calendar"></i><a href="{{ route('blog') }}">{{ now()->subDays(3)->format('d/m/Y') }}</a></li>
                        <li class="author-info"><i class="fa fa-user"></i><a href="{{ route('blog') }}">Admin</a></li>
                      </ul>
                    </div>
                    <h4 class="title"><a href="{{ route('blog.details') }}">Cách chăm sóc giày da để bền đẹp như mới</a></h4>
                    <a class="post-btn" href="{{ route('blog.details') }}">Đọc thêm</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="post-item">
                <div class="inner-content">
                  <div class="thumb">
                    <a href="{{ route('blog.details') }}"><img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" width="370" height="260" alt="Chọn size giày phù hợp"></a>
                  </div>
                  <div class="content">
                    <div class="meta-post">
                      <ul>
                        <li class="post-date"><i class="fa fa-calendar"></i><a href="{{ route('blog') }}">{{ now()->subWeek()->format('d/m/Y') }}</a></li>
                        <li class="author-info"><i class="fa fa-user"></i><a href="{{ route('blog') }}">Admin</a></li>
                      </ul>
                    </div>
                    <h4 class="title"><a href="{{ route('blog.details') }}">Hướng dẫn chọn size giày phù hợp nhất</a></h4>
                    <a class="post-btn" href="{{ route('blog.details') }}">Đọc thêm</a>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
    <!--== End Blog Area Wrapper ==-->
@endsection
