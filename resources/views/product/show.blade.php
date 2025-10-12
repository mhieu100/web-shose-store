@extends('layouts.frontend')

@section('title', 'Chi tiết sản phẩm - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Chi tiết sản phẩm</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Chi tiết sản phẩm</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Product Single Area Wrapper ==-->
    <section class="product-area product-single-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="product-single-item">
              <div class="row">
                <div class="col-xl-6">
                  <!--== Start Product Thumbnail Area ==-->
                  <div class="product-single-thumb">
                    <div class="swiper-container single-product-thumb single-product-thumb-slider">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide">
                          <a class="lightbox-image" data-fancybox="gallery" href="{{ asset('img/shop/product-single/1.webp') }}">
                            <img src="{{ asset('img/shop/product-single/1.webp') }}" width="570" height="541" alt="Sản phẩm">
                          </a>
                        </div>
                        <div class="swiper-slide">
                          <a class="lightbox-image" data-fancybox="gallery" href="{{ asset('img/shop/product-single/2.webp') }}">
                            <img src="{{ asset('img/shop/product-single/2.webp') }}" width="570" height="541" alt="Sản phẩm">
                          </a>
                        </div>
                        <div class="swiper-slide">
                          <a class="lightbox-image" data-fancybox="gallery" href="{{ asset('img/shop/product-single/3.webp') }}">
                            <img src="{{ asset('img/shop/product-single/3.webp') }}" width="570" height="541" alt="Sản phẩm">
                          </a>
                        </div>
                        <div class="swiper-slide">
                          <a class="lightbox-image" data-fancybox="gallery" href="{{ asset('img/shop/product-single/4.webp') }}">
                            <img src="{{ asset('img/shop/product-single/4.webp') }}" width="570" height="541" alt="Sản phẩm">
                          </a>
                        </div>
                        <div class="swiper-slide">
                          <a class="lightbox-image" data-fancybox="gallery" href="{{ asset('img/shop/product-single/5.webp') }}">
                            <img src="{{ asset('img/shop/product-single/5.webp') }}" width="570" height="541" alt="Sản phẩm">
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-container single-product-nav single-product-nav-slider">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide">
                          <img src="{{ asset('img/shop/product-single/nav-1.webp') }}" width="127" height="127" alt="Sản phẩm">
                        </div>
                        <div class="swiper-slide">
                          <img src="{{ asset('img/shop/product-single/nav-2.webp') }}" width="127" height="127" alt="Sản phẩm">
                        </div>
                        <div class="swiper-slide">
                          <img src="{{ asset('img/shop/product-single/nav-3.webp') }}" width="127" height="127" alt="Sản phẩm">
                        </div>
                        <div class="swiper-slide">
                          <img src="{{ asset('img/shop/product-single/nav-4.webp') }}" width="127" height="127" alt="Sản phẩm">
                        </div>
                        <div class="swiper-slide">
                          <img src="{{ asset('img/shop/product-single/nav-5.webp') }}" width="127" height="127" alt="Sản phẩm">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--== End Product Thumbnail Area ==-->
                </div>
                <div class="col-xl-6">
                  <!--== Start Product Info Area ==-->
                  <div class="product-single-info">
                    <h3 class="main-title">{{ ['Giày da nam cao cấp', 'Giày thể thao Nike', 'Giày boot cổ cao', 'Giày sneaker Adidas', 'Giày oxford thanh lịch', 'Giày cao gót nữ', 'Giày canvas casual', 'Giày running professional'][($id ?? 1) - 1] ?? 'Giày thời trang cao cấp' }}</h3>
                    <div class="prices">
                      <span class="price">{{ number_format(rand(1500000, 3000000)) }} VNĐ</span>
                    </div>
                    <div class="rating-box-wrap">
                      <div class="rating-box">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </div>
                      <div class="review-status">
                        <a href="javascript:void(0)">({{ rand(3, 15) }} đánh giá khách hàng)</a>
                      </div>
                    </div>
                    <p>Sản phẩm được làm từ chất liệu cao cấp, thiết kế hiện đại và phong cách. Đây là lựa chọn hoàn hảo cho những ai yêu thích sự thoải mái và thời trang. Sản phẩm có độ bền cao, phù hợp với nhiều hoạt động khác nhau trong cuộc sống hàng ngày.</p>
                    
                    <div class="product-color">
                      <h6 class="title">Màu sắc</h6>
                      <ul class="color-list">
                        <li data-bg-color="#586882"></li>
                        <li class="active" data-bg-color="#505050"></li>
                        <li data-bg-color="#73707a"></li>
                        <li data-bg-color="#c7bb9b"></li>
                      </ul>
                    </div>
                    
                    <div class="product-size">
                      <h6 class="title">Kích thước</h6>
                      <ul class="size-list">
                        <li>38</li>
                        <li class="active">39</li>
                        <li>40</li>
                        <li>41</li>
                        <li>42</li>
                        <li>43</li>
                      </ul>
                    </div>
                    
                    <div class="product-quick-action">
                      <div class="qty-wrap">
                        <div class="pro-qty">
                          <input type="text" title="Quantity" value="1">
                        </div>
                      </div>
                      <a class="btn-theme" href="{{ route('cart') }}">Add to Cart</a>
                    </div>
                    
                    <div class="product-wishlist-compare">
                      <a href="{{ route('wishlist') }}"><i class="pe-7s-like"></i>Thêm vào yêu thích</a>
                      <a href="{{ route('compare') }}"><i class="pe-7s-shuffle"></i>So sánh sản phẩm</a>
                    </div>
                    
                    <div class="product-info-footer">
                      <h6 class="code"><span>Mã sản phẩm:</span> SP-{{ str_pad($id ?? 1, 3, '0', STR_PAD_LEFT) }}</h6>
                      <div class="social-icons">
                        <span>Chia sẻ</span>
                        <a href="#/" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#/" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#/" target="_blank"><i class="fa fa-pinterest-p"></i></a>
                      </div>
                    </div>
                  </div>
                  <!--== End Product Info Area ==-->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="product-review-tabs-content">
              <ul class="nav product-tab-nav" id="ReviewTab" role="tablist">
                <li role="presentation">
                  <a class="active" id="information-tab" data-bs-toggle="pill" href="#information" role="tab" aria-controls="information" aria-selected="true">Thông tin</a>
                </li>
                <li role="presentation">
                  <a id="description-tab" data-bs-toggle="pill" href="#description" role="tab" aria-controls="description" aria-selected="false">Mô tả</a>
                </li>
                <li role="presentation">
                  <a id="reviews-tab" data-bs-toggle="pill" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Đánh giá <span>({{ rand(3, 10) }})</span></a>
                </li>
              </ul>
              <div class="tab-content product-tab-content" id="ReviewTabContent">
                <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                  <div class="product-information">
                    <h4>Thông tin sản phẩm</h4>
                    <ul>
                      <li><strong>Chất liệu:</strong> Da thật cao cấp</li>
                      <li><strong>Đế giày:</strong> Cao su chống trượt</li>
                      <li><strong>Lót giày:</strong> Memory foam êm ái</li>
                      <li><strong>Xuất xứ:</strong> Việt Nam</li>
                      <li><strong>Bảo hành:</strong> 6 tháng</li>
                      <li><strong>Hướng dẫn bảo quản:</strong> Tránh nước, bảo quản nơi khô ráo</li>
                    </ul>
                  </div>
                </div>
                <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                  <div class="product-description">
                    <h4>Mô tả chi tiết</h4>
                    <p>Đây là một sản phẩm giày cao cấp được thiết kế với sự chú trọng đến từng chi tiết nhỏ nhất. Chất liệu da thật được tuyển chọn kỹ lưỡng, mang lại độ bền và vẻ đẹp sang trọng.</p>
                    <p>Thiết kế hiện đại, phù hợp với xu hướng thời trang hiện tại. Đế giày được làm từ cao su chất lượng cao, có khả năng chống trượt tốt và mang lại cảm giác thoải mái khi di chuyển.</p>
                    <p>Sản phẩm có nhiều màu sắc và kích thước khác nhau để phù hợp với nhu cầu đa dạng của khách hàng. Đây là lựa chọn hoàn hảo cho cả công việc và giải trí.</p>
                  </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                  <div class="product-review-content">
                    <div class="review-content-header">
                      <h3>Đánh giá của khách hàng</h3>
                      <div class="review-info">
                        <ul class="review-rating">
                          <li class="fa fa-star"></li>
                          <li class="fa fa-star"></li>
                          <li class="fa fa-star"></li>
                          <li class="fa fa-star"></li>
                          <li class="fa fa-star-o"></li>
                        </ul>
                        <span class="review-caption">Dựa trên {{ rand(5, 15) }} đánh giá</span>
                        <span class="review-write-btn">Viết đánh giá</span>
                      </div>
                    </div>

                    <!--== Start Reviews List ==-->
                    <div class="reviews-list">
                      @for($i = 1; $i <= 3; $i++)
                      <div class="review-item">
                        <div class="review-author">
                          <h6>{{ ['Anh Minh', 'Chị Hoa', 'Anh Tuấn'][$i-1] }}</h6>
                          <span class="review-date">{{ now()->subDays($i * 5)->format('d/m/Y') }}</span>
                        </div>
                        <div class="review-rating">
                          @for($j = 1; $j <= 5; $j++)
                            <i class="fa fa-star{{ $j > 4 ? '-o' : '' }}"></i>
                          @endfor
                        </div>
                        <p>{{ ['Chất lượng giày rất tốt, đi rất êm chân và phong cách. Tôi rất hài lòng với sản phẩm này.', 'Giao hàng nhanh, đóng gói cẩn thận. Giày đúng như mô tả, chất lượng tốt.', 'Thiết kế đẹp, phù hợp với nhiều trang phục khác nhau. Sẽ mua thêm.'][$i-1] }}</p>
                      </div>
                      @endfor
                    </div>
                    <!--== End Reviews List ==-->

                    <!--== Start Reviews Form ==-->
                    <div class="reviews-form-area">
                      <h4 class="title">Viết đánh giá</h4>
                      <div class="reviews-form-content">
                        <form action="#" method="POST">
                          @csrf
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Tên của bạn <span>*</span></label>
                                <input class="form-control" type="text" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Email <span>*</span></label>
                                <input class="form-control" type="email" required>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Đánh giá của bạn <span>*</span></label>
                                <div class="review-rating-input">
                                  <input type="radio" name="rating" value="5" id="star5">
                                  <label for="star5">5 sao</label>
                                  <input type="radio" name="rating" value="4" id="star4">
                                  <label for="star4">4 sao</label>
                                  <input type="radio" name="rating" value="3" id="star3">
                                  <label for="star3">3 sao</label>
                                  <input type="radio" name="rating" value="2" id="star2">
                                  <label for="star2">2 sao</label>
                                  <input type="radio" name="rating" value="1" id="star1">
                                  <label for="star1">1 sao</label>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Nội dung đánh giá <span>*</span></label>
                                <textarea class="form-control" rows="6" required></textarea>
                              </div>
                            </div>
                            <div class="col-12">
                              <button class="btn-theme" type="submit">Gửi đánh giá</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <!--== End Reviews Form ==-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Single Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-related-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Sản phẩm liên quan</h3>
              <div class="desc">
                <p>Những sản phẩm tương tự bạn có thể quan tâm</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @for($i = 1; $i <= 4; $i++)
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', $i + 10) }}">
                    <img src="{{ asset('img/shop/' . (($i - 1) % 8 + 1) . '.webp') }}" width="270" height="274" alt="Sản phẩm {{ $i }}">
                  </a>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">{{ $i % 2 == 0 ? 'Nam' : 'Nữ' }}</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">{{ $i % 3 == 0 ? 'Thể thao' : 'Thời trang' }}</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', $i + 10) }}">Sản phẩm liên quan {{ $i }}</a></h4>
                  <div class="prices">
                    <span class="price">{{ number_format(rand(1500000, 2800000)) }} VNĐ</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          @endfor
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->
@endsection