@extends('layouts.frontend')

@section('title', 'Giỏ hàng - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Giỏ hàng</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Giỏ hàng</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Shopping Cart Area ==-->
    <section class="shopping-cart-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="shopping-cart-form table-responsive">
              <form action="#" method="post">
                @csrf
                <table class="table text-center">
                  <thead>
                    <tr>
                      <th class="product-remove">&nbsp;</th>
                      <th class="product-thumb">&nbsp;</th>
                      <th class="product-name">Product</th>
                      <th class="product-price">Price</th>
                      <th class="product-quantity">Quantity</th>
                      <th class="product-subtotal">Total</th>
                    </tr>
                  </thead>
                    <tbody>
                    <tr class="cart-product-item">
                      <td class="product-remove">
                        <a href="#/"><i class="fa fa-trash-o"></i></a>
                      </td>
                      <td class="product-thumb">
                        <a href="{{ route('product.show', 1) }}">
                          <img src="{{ asset('img/shop/product-mini/1.webp') }}" width="90" height="110" alt="Image-HasTech">
                        </a>
                      </td>
                      <td class="product-name">
                        <h4 class="title"><a href="{{ route('product.show', 1) }}">Leather Mens Slipper</a></h4>
                      </td>
                      <td class="product-price">
                        <span class="price">£69.99</span>
                      </td>
                      <td class="product-quantity">
                        <div class="pro-qty">
                          <input type="text" class="quantity" title="Quantity" value="1">
                        </div>
                      </td>
                      <td class="product-subtotal">
                        <span class="price">£69.99</span>
                      </td>
                    </tr>
                    <tr class="cart-product-item">
                      <td class="product-remove">
                        <a href="#/"><i class="fa fa-trash-o"></i></a>
                      </td>
                      <td class="product-thumb">
                        <a href="{{ route('product.show', 2) }}">
                          <img src="{{ asset('img/shop/product-mini/2.webp') }}" width="90" height="110" alt="Image-HasTech">
                        </a>
                      </td>
                      <td class="product-name">
                        <h4 class="title"><a href="{{ route('product.show', 2) }}">Quickiin Mens shoes</a></h4>
                      </td>
                      <td class="product-price">
                        <span class="price">£20.00</span>
                      </td>
                      <td class="product-quantity">
                        <div class="pro-qty">
                          <input type="text" class="quantity" title="Quantity" value="1">
                        </div>
                      </td>
                      <td class="product-subtotal">
                        <span class="price">£20.00</span>
                      </td>
                    </tr>
                    <tr class="actions">
                      <td class="border-0" colspan="6">
                        <button type="submit" class="update-cart" disabled>Update cart</button>
                        <button type="submit" class="clear-cart">Clear Cart</button>
                        <a href="{{ route('shop') }}" class="btn-theme btn-flat">Continue Shopping</a>
                      </td>
                    </tr>
                    </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Shopping Cart Area ==-->
@endsection