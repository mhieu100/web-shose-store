@extends('layouts.frontend')

@section('title', 'Demo - Shoes eCommerce Website Template')
@section('description', 'Demo - Shoes eCommerce Website Template')

@section('content')
    <!--== Start Hero Area Wrapper ==-->
    <section class="home-slider-area">
      <div class="swiper-container home-slider-container default-slider-container">
        <div class="swiper-wrapper home-slider-wrapper slider-default">
          <div class="swiper-slide">
            <div class="slider-content-area" data-bg-img="{{ asset('img/shape/1.webp') }}">
              <div class="container">
                <div class="slider-container">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6 col-md-5">
                      <div class="slider-content">
                        <div class="content">
                          <div class="title-box">
                            <h2 class="title">Exclusive New Shoes</h2>
                          </div>
                          <div class="desc-box">
                            <p class="desc">Up To 30% Off All Shoes & Products</p>
                          </div>
                          <div class="btn-box">
                            <a class="btn-slider" href="{{ route('shop') }}">Shop Now</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="slider-thumb">
                        <div class="thumb scene">
                          <span class="scene-layer" data-depth=".3"><img src="{{ asset('img/slider/slider-01.webp') }}" width="461" height="489" alt="Image-HasTech"></span>
                        </div>
                        <div class="shape-group mousemove">
                          <div class="shape-group-one mousemove-layer" data-speed=".8" data-bg-img="{{ asset('img/shape/2.webp') }}"></div>
                          <div class="shape-group-two scene"><span class="scene-layer" data-depth=".6"><img src="{{ asset('img/shape/3.webp') }}" width="471" height="462" alt="Image-HasTech"></span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <h2 class="slider-text-shape">NEW 2021</h2>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="slider-content-area" data-bg-img="{{ asset('img/shape/1.webp') }}">
              <div class="container">
                <div class="slider-container">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6 col-md-5">
                      <div class="slider-content">
                        <div class="content">
                          <div class="title-box">
                            <h2 class="title">Exclusive New Shoes</h2>
                          </div>
                          <div class="desc-box">
                            <p class="desc">Up To 30% Off All Shoes & Products</p>
                          </div>
                          <div class="btn-box">
                            <a class="btn-slider" href="{{ route('shop') }}">Shop Now</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="slider-thumb">
                        <div class="thumb scene">
                          <span class="scene-layer" data-depth=".3"><img src="{{ asset('img/slider/slider-03.webp') }}" width="548" height="649" alt="Image-HasTech"></span>
                        </div>
                        <div class="shape-group mousemove">
                          <div class="shape-group-one mousemove-layer" data-speed=".8" data-bg-img="{{ asset('img/shape/2.webp') }}"></div>
                          <div class="shape-group-two scene"><span class="scene-layer" data-depth=".6"><img src="{{ asset('img/shape/3.webp') }}" width="471" height="462" alt="Image-HasTech"></span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <h2 class="slider-text-shape">NEW 2022</h2>
            </div>
          </div>
        </div>

        <!--== Add Swiper Arrows ==-->
        <div class="swiper-btn-wrap">
          <div class="swiper-btn-prev">
            <i class="pe-7s-angle-left"></i>
          </div>
          <div class="swiper-btn-next">
            <i class="pe-7s-angle-right"></i>
          </div>
        </div>
      </div>
    </section>
    <!--== End Hero Area Wrapper ==-->

    <!--== Start Product Collection Area Wrapper ==-->
    <section class="product-area product-collection-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <!--== Start Product Collection Item ==-->
            <div class="product-collection">
              <div class="inner-content">
                <div class="product-collection-content">
                  <div class="content">
                    <h3 class="title"><a href="{{ route('shop') }}">Sports Shoes</a></h3>
                    <h4 class="price">From $95.00</h4>
                  </div>
                </div>
                <div class="product-collection-thumb" data-bg-img="{{ asset('img/shop/collection/1.webp') }}"></div>
                <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
              </div>
            </div>
            <!--== End Product Collection Item ==-->
          </div>
          <div class="col-lg-4 col-md-6">
            <!--== Start Product Collection Item ==-->
            <div class="product-collection">
              <div class="inner-content">
                <div class="product-collection-content">
                  <div class="content">
                    <h3 class="title"><a href="{{ route('shop') }}">Latest Shoes</a></h3>
                    <h4 class="price">From $90.00</h4>
                  </div>
                </div>
                <div class="product-collection-thumb" data-bg-img="{{ asset('img/shop/collection/2.webp') }}"></div>
                <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
              </div>
            </div>
            <!--== End Product Collection Item ==-->
          </div>
          <div class="col-lg-4 col-md-6">
            <!--== Start Product Collection Item ==-->
            <div class="product-collection">
              <div class="inner-content">
                <div class="product-collection-content">
                  <div class="content">
                    <h3 class="title"><a href="{{ route('shop') }}">Office Shoes</a></h3>
                    <h4 class="price">From $82.00</h4>
                  </div>
                </div>
                <div class="product-collection-thumb" data-bg-img="{{ asset('img/shop/collection/3.webp') }}"></div>
                <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
              </div>
            </div>
            <!--== End Product Collection Item ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Collection Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
      <div class="container pt--0">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Featured Items</h3>
              <div class="desc">
                <p>There are many variations of passages of Lorem Ipsum available</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 1) }}">
                    <img src="{{ asset('img/shop/1.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-flag">
                    <ul>
                      <li class="discount">-10%</li>
                    </ul>
                  </div>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 1) }}">Leather Mens Slipper</a></h4>
                  <div class="prices">
                    <span class="price-old">$100</span>
                    <span class="sep">-</span>
                    <span class="price">$240.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 2) }}">
                    <img src="{{ asset('img/shop/2.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 2) }}">Quickiin Mens shoes</a></h4>
                  <div class="prices">
                    <span class="price">$140.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 3) }}">
                    <img src="{{ asset('img/shop/3.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-flag">
                    <ul>
                      <li class="discount">-10%</li>
                    </ul>
                  </div>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 3) }}">Rexpo Womens shoes</a></h4>
                  <div class="prices">
                    <span class="price-old">$60</span>
                    <span class="sep">-</span>
                    <span class="price">$260.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 4) }}">
                    <img src="{{ asset('img/shop/4.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 4) }}">Hollister V-Neck Knit</a></h4>
                  <div class="prices">
                    <span class="price">$880.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 5) }}">
                    <img src="{{ asset('img/shop/5.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 5) }}">Primitive Mens shoes</a></h4>
                  <div class="prices">
                    <span class="price">$500.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 6) }}">
                    <img src="{{ asset('img/shop/6.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-flag">
                    <ul>
                      <li class="discount">-10%</li>
                    </ul>
                  </div>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 6) }}">New Womens High Hills</a></h4>
                  <div class="prices">
                    <span class="price-old">$300</span>
                    <span class="sep">-</span>
                    <span class="price">$333.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 7) }}">
                    <img src="{{ asset('img/shop/7.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 7) }}">Simple Fabric Shoe</a></h4>
                  <div class="prices">
                    <span class="price">$133.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
          <div class="col-sm-6 col-lg-3">
            <!--== Start Product Item ==-->
            <div class="product-item">
              <div class="inner-content">
                <div class="product-thumb">
                  <a href="{{ route('product.show', 8) }}">
                    <img src="{{ asset('img/shop/8.webp') }}" width="270" height="274" alt="Image-HasTech">
                  </a>
                  <div class="product-flag">
                    <ul>
                      <li class="discount">-10%</li>
                    </ul>
                  </div>
                  <div class="product-action">
                    <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                    <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                    <button type="button" class="btn-product-quick-view-open">
                      <i class="fa fa-arrows"></i>
                    </button>
                    <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                  </div>
                  <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                </div>
                <div class="product-info">
                  <div class="category">
                    <ul>
                      <li><a href="{{ route('shop') }}">Men</a></li>
                      <li class="sep">/</li>
                      <li><a href="{{ route('shop') }}">Women</a></li>
                    </ul>
                  </div>
                  <h4 class="title"><a href="{{ route('product.show', 8) }}">exclusive mens shoe</a></h4>
                  <div class="prices">
                    <span class="price-old">$300</span>
                    <span class="sep">-</span>
                    <span class="price">$420.00</span>
                  </div>
                </div>
              </div>
            </div>
            <!--== End Product Item ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper ==-->

    <!--== Start Divider Area Wrapper ==-->
    <section class="bg-color-f2 position-relative z-index-1">
      <div class="container pt--0 pb--0">
        <div class="row divider-wrap divider-style1">
          <div class="col-lg-6">
            <div class="divider-content" data-title="NEW">
              <h4 class="sub-title">Saving 50%</h4>
              <h2 class="title">All Online Store</h2>
              <p class="desc">Offer Available All Shoes & Products</p>
              <a class="btn-theme" href="{{ route('shop') }}">Shop Now</a>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-layer-wrap">
        <div class="bg-layer-style z-index--1 parallax" data-speed="1.05" data-bg-img="{{ asset('img/photos/bg1.webp') }}"></div>
      </div>
    </section>
    <!--== End Divider Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-best-seller-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Best Seller</h3>
              <div class="desc">
                <p>There are many variations of passages of Lorem Ipsum available</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="product-slider-wrap">
              <div class="swiper-container product-slider-col4-container">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', 1) }}">
                            <img src="{{ asset('img/shop/1.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-10%</li>
                            </ul>
                          </div>
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">Men</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">Women</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', 1) }}">Modern Smart Shoes</a></h4>
                          <div class="prices">
                            <span class="price-old">$200</span>
                            <span class="sep">-</span>
                            <span class="price">$240.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', 7) }}">
                            <img src="{{ asset('img/shop/7.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">Men</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">Women</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', 7) }}">Quickiin Mens shoes</a></h4>
                          <div class="prices">
                            <span class="price">$440.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', 3) }}">
                            <img src="{{ asset('img/shop/3.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-10%</li>
                            </ul>
                          </div>
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">Men</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">Women</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', 3) }}">Rexpo Womens shoes</a></h4>
                          <div class="prices">
                            <span class="price-old">$130</span>
                            <span class="sep">-</span>
                            <span class="price">$333.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', 4) }}">
                            <img src="{{ asset('img/shop/4.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">Men</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">Women</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', 4) }}">Leather Mens Slipper</a></h4>
                          <div class="prices">
                            <span class="price">$540.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', 5) }}">
                            <img src="{{ asset('img/shop/5.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">Men</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">Women</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', 5) }}">Primitive Mens shoes</a></h4>
                          <div class="prices">
                            <span class="price-old">$40</span>
                            <span class="sep">-</span>
                            <span class="price">$280.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                  <div class="swiper-slide">
                    <!--== Start Product Item ==-->
                    <div class="product-item">
                      <div class="inner-content">
                        <div class="product-thumb">
                          <a href="{{ route('product.show', 6) }}">
                            <img src="{{ asset('img/shop/6.webp') }}" width="270" height="274" alt="Image-HasTech">
                          </a>
                          <div class="product-flag">
                            <ul>
                              <li class="discount">-10%</li>
                            </ul>
                          </div>
                          <div class="product-action">
                            <a class="btn-product-wishlist" href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
                            <a class="btn-product-cart" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <button type="button" class="btn-product-quick-view-open">
                              <i class="fa fa-arrows"></i>
                            </button>
                            <a class="btn-product-compare" href="{{ route('compare') }}"><i class="fa fa-random"></i></a>
                          </div>
                          <a class="banner-link-overlay" href="{{ route('shop') }}"></a>
                        </div>
                        <div class="product-info">
                          <div class="category">
                            <ul>
                              <li><a href="{{ route('shop') }}">Men</a></li>
                              <li class="sep">/</li>
                              <li><a href="{{ route('shop') }}">Women</a></li>
                            </ul>
                          </div>
                          <h4 class="title"><a href="{{ route('product.show', 6) }}">New Womens High Hills</a></h4>
                          <div class="prices">
                            <span class="price-old">$40</span>
                            <span class="sep">-</span>
                            <span class="price">$280.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--== End Product Item ==-->
                  </div>
                </div>

                <!--== Add Swiper Arrows ==-->
                <div class="swiper-btn-wrap">
                  <div class="swiper-btn-prev">
                    <i class="pe-7s-angle-left"></i>
                  </div>
                  <div class="swiper-btn-next">
                    <i class="pe-7s-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Product Area Wrapper -->@endsection
