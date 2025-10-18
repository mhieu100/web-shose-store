@extends('layouts.frontend')

@section('title', 'Chi tiết bài viết - Shoe Store')

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
                <img src="{{ asset('img/blog/blog-details-1.webp') }}" width="770" height="450" alt="Blog Details">
              </div>
              <div class="blog-details-info">
                <div class="blog-details-meta">
                  <div class="meta-info">
                    <ul>
                      <li class="post-date"><i class="fa fa-calendar"></i>{{ now()->format('d/m/Y') }}</li>
                      <li class="author-info"><i class="fa fa-user"></i>Admin</li>
                      <li class="post-category"><i class="fa fa-folder"></i><a href="{{ route('blog') }}">Xu hướng thời trang</a></li>
                      <li class="post-comments"><i class="fa fa-comments"></i><a href="#comments">5 bình luận</a></li>
                    </ul>
                  </div>
                </div>
                <h2 class="title">Xu hướng giày thể thao 2024 - Những mẫu hot nhất năm</h2>
                <div class="blog-details-desc">
                  <p>Năm 2024 đánh dấu một bước ngoặt mới trong thế giới thời trang giày thể thao. Với sự kết hợp hoàn hảo giữa công nghệ hiện đại và phong cách thời trang, những mẫu giày thể thao năm nay không chỉ mang lại sự thoải mái mà còn thể hiện cá tính riêng của người sử dụng.</p>

                  <h3>1. Chunky Sneakers - Xu hướng "to bản" lên ngôi</h3>
                  <p>Giày thể thao chunky với thiết kế to bản, đế dày tiếp tục khẳng định vị thế trong năm 2024. Phong cách này không chỉ mang lại vẻ ngoài năng động mà còn tăng chiều cao đáng kể cho người mang.</p>

                  <div class="blog-quote">
                    <blockquote>
                      <p>"Thời trang giày thể thao không chỉ là về sự thoải mái, mà còn là cách thể hiện cá tính và phong cách sống của bạn"</p>
                      <cite>- Chuyên gia thời trang</cite>
                    </blockquote>
                  </div>

                  <h3>2. Sustainable Sneakers - Bền vững và thân thiện môi trường</h3>
                  <p>Xu hướng giày thể thao bền vững đang ngày càng được ưa chuộng. Các thương hiệu lớn đang chuyển hướng sản xuất giày từ vật liệu tái chế, thân thiện với môi trường mà vẫn đảm bảo chất lượng và tính thẩm mỹ cao.</p>

                  <img src="{{ asset('img/blog/blog-details-2.webp') }}" width="770" height="400" alt="Sustainable Sneakers" class="img-fluid my-4">

                  <h3>3. Tech-Forward Design - Công nghệ tích hợp</h3>
                  <p>Giày thể thao năm 2024 được tích hợp nhiều công nghệ tiên tiến như:</p>
                  <ul>
                    <li>Đế giày thông minh với khả năng đệm êm tự động</li>
                    <li>Vật liệu thông hơi cao cấp</li>
                    <li>Hệ thống dây buộc tự động</li>
                    <li>Cảm biến theo dõi hoạt động</li>
                  </ul>

                  <h3>4. Màu sắc trending 2024</h3>
                  <p>Các tông màu được ưa chuộng nhất trong năm 2024 bao gồm:</p>
                  <ol>
                    <li><strong>Sage Green:</strong> Xanh lá nhẹ nhàng, tự nhiên</li>
                    <li><strong>Digital Lime:</strong> Xanh neon nổi bật</li>
                    <li><strong>Cosmic Latte:</strong> Kem sữa ấm áp</li>
                    <li><strong>Midnight Black:</strong> Đen huyền bí</li>
                  </ol>

                  <h3>5. Cách phối đồ với giày thể thao hot trend</h3>
                  <p>Để tối đa hóa vẻ đẹp của đôi giày thể thao trendy, bạn có thể:</p>
                  <ul>
                    <li>Kết hợp với quần jogger và áo hoodie cho phong cách sporty</li>
                    <li>Mix với váy midi và áo blazer cho look smart casual</li>
                    <li>Phối cùng quần jean và áo thun cho style street wear</li>
                  </ul>

                  <div class="blog-share">
                    <h5>Chia sẻ bài viết:</h5>
                    <div class="social-share">
                      <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                      <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                      <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                      <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                    </div>
                  </div>
                </div>
              </div>

              <!--== Start Blog Tags ==-->
              <div class="blog-details-tags">
                <div class="tags-wrap">
                  <h6>Tags:</h6>
                  <div class="tags-item">
                    <a href="{{ route('blog') }}">giày thể thao</a>
                    <a href="{{ route('blog') }}">xu hướng 2024</a>
                    <a href="{{ route('blog') }}">sneakers</a>
                    <a href="{{ route('blog') }}">thời trang</a>
                  </div>
                </div>
              </div>
              <!--== End Blog Tags ==-->

              <!--== Start Author Info ==-->
              <div class="blog-author-info">
                <div class="author-thumb">
                  <img src="{{ asset('img/blog/author.webp') }}" width="80" height="80" alt="Author">
                </div>
                <div class="author-content">
                  <h5 class="name">Nguyễn Văn Admin</h5>
                  <p class="designation">Chuyên gia thời trang giày dép</p>
                  <p class="desc">Với hơn 10 năm kinh nghiệm trong ngành thời trang giày dép, Admin luôn cập nhật những xu hướng mới nhất và chia sẻ kiến thức hữu ích đến độc giả.</p>
                </div>
              </div>
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
              <div class="sidebar-item">
                <h4 class="sidebar-title">Bài viết mới nhất</h4>
                <div class="sidebar-body">
                  <div class="sidebar-recent-posts">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="recent-post-item">
                      <div class="recent-post-thumb">
                        <a href="{{ route('blog.details') }}">
                          <img src="{{ asset('img/blog/recent-' . $i . '.webp') }}" width="80" height="80" alt="Recent Post">
                        </a>
                      </div>
                      <div class="recent-post-content">
                        <h6 class="title"><a href="{{ route('blog.details') }}">{{ ['Cách chọn giày phù hợp', 'Xu hướng thời trang mới', 'Bảo quản giày hiệu quả', 'Phối đồ với giày'][($i-1)] }}</a></h6>
                        <span class="date">{{ now()->subDays($i * 3)->format('d/m/Y') }}</span>
                      </div>
                    </div>
                    @endfor
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
                      <li><a href="{{ route('blog') }}">Xu hướng thời trang <span>(12)</span></a></li>
                      <li><a href="{{ route('blog') }}">Cách chọn giày <span>(8)</span></a></li>
                      <li><a href="{{ route('blog') }}">Bảo quản giày <span>(6)</span></a></li>
                      <li><a href="{{ route('blog') }}">Phối đồ <span>(10)</span></a></li>
                      <li><a href="{{ route('blog') }}">Thương hiệu giày <span>(5)</span></a></li>
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
    <!--== End Blog Details Area ==-->
</main>
@endsection
