@extends('layouts.frontend')

@section('title', 'Kết quả tìm kiếm - Shoe Store')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Kết quả tìm kiếm</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Tìm kiếm: "{{ request('q') }}"</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area shop-product-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="shop-product-content">
              <div class="row">
                <div class="col-12">
                  <div class="section-title text-center">
                    <h3 class="title">Kết quả tìm kiếm cho "{{ $searchTerm ?? request('q') }}"</h3>
                    <div class="desc">
                      <p>Tìm thấy {{ $products->total() }} sản phẩm phù hợp</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                @forelse($products as $product)
                <div class="col-sm-6 col-lg-3">
                  <div class="product-item">
                    <div class="inner-content">
                      <div class="product-thumb">
                        <a href="{{ route('product.show', $product->id) }}">
                          @if($product->getFirstMediaUrl('product-images'))
                            <img src="{{ $product->getFirstMediaUrl('product-images') }}" width="270" height="274" alt="{{ $product->name }}">
                          @else
                            <img src="{{ asset('img/shop/placeholder.webp') }}" width="270" height="274" alt="{{ $product->name }}">
                          @endif
                        </a>
                        @if($product->old_price && $product->old_price > $product->price)
                        <div class="product-flag">
                          <ul>
                            <li class="discount">-{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%</li>
                          </ul>
                        </div>
                        @endif
                        <div class="product-action">
                          <button class="add-to-wishlist btn-product-wishlist" data-product-id="{{ $product->id }}" title="Thêm vào danh sách yêu thích">
                            <i class="bx bx-heart"></i>
                          </button>
                          <button type="button" class="btn-product-cart add-to-cart"
                                  data-product-id="{{ $product->id }}"
                                  data-product-name="{{ $product->name }}"
                                  data-product-price="{{ $product->price }}"
                                  data-product-colors="{{ $product->colors ? json_encode($product->colors) : '[]' }}"
                                  data-product-sizes="{{ $product->sizes ? json_encode($product->sizes) : '[]' }}"
                                  title="Thêm vào giỏ hàng">
                            <i class="bx bx-cart"></i>
                          </button>
                          <button type="button" class="btn-product-quick-view-open" title="Xem nhanh">
                            <i class="bx bx-expand-alt"></i>
                          </button>
                          <a class="btn-product-compare" href="{{ route('compare') }}"><i class="bx bx-git-compare"></i></a>
                        </div>
                      </div>
                      <div class="product-info">
                        <div class="category">
                          <ul>
                            @foreach($product->categories as $index => $category)
                              <li><a href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                              @if($index < count($product->categories) - 1)
                                <li class="sep">/</li>
                              @endif
                            @endforeach
                          </ul>
                        </div>
                        <h4 class="title"><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h4>
                        <div class="prices">
                          @if($product->old_price && $product->old_price > $product->price)
                            <span class="price-old">{{ number_format($product->old_price, 0, ',', '.') }} VNĐ</span>
                            <span class="sep">-</span>
                          @endif
                          <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @empty
                <div class="col-12">
                  <div class="text-center p-5">
                    <h4>Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $searchTerm ?? request('q') }}"</h4>
                    <p>Hãy thử tìm kiếm với từ khóa khác hoặc <a href="{{ route('shop') }}">xem tất cả sản phẩm</a></p>
                  </div>
                </div>
                @endforelse
              </div>

              @if($products->hasPages())
              <div class="row">
                <div class="col-12">
                  <div class="pagination-area text-center">
                    {{ $products->links() }}
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->
</main>
@endsection
