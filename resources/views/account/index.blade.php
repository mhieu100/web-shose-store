@extends('layouts.frontend')

@section('title', 'Tài Khoản Của Tôi - Cửa Hàng Giày')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
  <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Tài Khoản Của Tôi</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Tài Khoản Của Tôi</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start My Account Wrapper ==-->
    <section class="my-account-area">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-lg-12">
            <div class="myaccount-page-wrapper">
              <div class="row">
                <div class="col-lg-3 col-md-4">
                  <nav>
                    <div class="myaccount-tab-menu nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="dashboad-tab" data-bs-toggle="tab" data-bs-target="#dashboad" type="button" role="tab" aria-controls="dashboad" aria-selected="true">Bảng Điều Khiển</button>
                      <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">Đơn Hàng</button>
                      <button class="nav-link" id="download-tab" data-bs-toggle="tab" data-bs-target="#download" type="button" role="tab" aria-controls="download" aria-selected="false">Tải Xuống</button>
                      <button class="nav-link" id="payment-method-tab" data-bs-toggle="tab" data-bs-target="#payment-method" type="button" role="tab" aria-controls="payment-method" aria-selected="false">Phương Thức Thanh Toán</button>
                      <button class="nav-link" id="address-edit-tab" data-bs-toggle="tab" data-bs-target="#address-edit" type="button" role="tab" aria-controls="address-edit" aria-selected="false">Địa Chỉ</button>
                      <button class="nav-link" id="account-info-tab" data-bs-toggle="tab" data-bs-target="#account-info" type="button" role="tab" aria-controls="account-info" aria-selected="false">Chi Tiết Tài Khoản</button>
                      <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                        @csrf
                        <button class="nav-link" type="submit">Đăng Xuất</button>
                      </form>
                    </div>
                  </nav>
                </div>
                <div class="col-lg-9 col-md-8">
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel" aria-labelledby="dashboad-tab">
                      <div class="myaccount-content">
                        <h3>Bảng Điều Khiển</h3>
                        <div class="welcome">
                          <p>Xin chào, <strong>{{ auth()->user()->name ?? 'Alex Tuntuni' }}</strong>!</p>
                        </div>
                        <p>Từ bảng điều khiển tài khoản của bạn, bạn có thể dễ dàng kiểm tra & xem các đơn hàng gần đây, quản lý địa chỉ giao hàng và thanh toán, cũng như chỉnh sửa mật khẩu và thông tin tài khoản.</p>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                      <div class="myaccount-content">
                        <h3>Đơn Hàng</h3>
                        <div class="myaccount-table table-responsive text-center">
                          <table class="table table-bordered">
                            <thead class="thead-light">
                              <tr>
                                <th>Đơn Hàng</th>
                                <th>Ngày</th>
                                <th>Trạng Thái</th>
                                <th>Tổng Cộng</th>
                                <th>Hành Động</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>22/08/2022</td>
                                <td>Đang Chờ</td>
                                <td>3.000.000₫</td>
                                <td><a href="{{ route('cart') }}" class="check-btn sqr-btn ">Xem</a></td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>22/07/2022</td>
                                <td>Đã Duyệt</td>
                                <td>200.000₫</td>
                                <td><a href="{{ route('cart') }}" class="check-btn sqr-btn ">Xem</a></td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>12/06/2022</td>
                                <td>Tạm Giữ</td>
                                <td>990.000₫</td>
                                <td><a href="{{ route('cart') }}" class="check-btn sqr-btn ">Xem</a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                      <div class="myaccount-content">
                        <h3>Tải Xuống</h3>
                        <div class="myaccount-table table-responsive text-center">
                          <table class="table table-bordered">
                            <thead class="thead-light">
                              <tr>
                                <th>Sản Phẩm</th>
                                <th>Ngày</th>
                                <th>Hết Hạn</th>
                                <th>Tải Xuống</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Haven - Mẫu PSD Bất Động Sản Miễn Phí</td>
                                <td>22/08/2022</td>
                                <td>Có</td>
                                <td><a href="#/" class="check-btn sqr-btn"><i class="fa fa-cloud-download"></i> Tải File</a></td>
                              </tr>
                              <tr>
                                <td>HasTech - Mẫu Kinh Doanh Hồ Sơ</td>
                                <td>12/09/2022</td>
                                <td>Không Bao Giờ</td>
                                <td><a href="#/" class="check-btn sqr-btn"><i class="fa fa-cloud-download"></i> Tải File</a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="payment-method" role="tabpanel" aria-labelledby="payment-method-tab">
                      <div class="myaccount-content">
                        <h3>Phương Thức Thanh Toán</h3>
                        <p class="saved-message">Bạn chưa thể lưu phương thức thanh toán của mình.</p>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="address-edit" role="tabpanel" aria-labelledby="address-edit-tab">
                      <div class="myaccount-content">
                        <h3>Địa Chỉ Thanh Toán</h3>
                        <address>
                          <p><strong>{{ auth()->user()->name ?? 'Alex Tuntuni' }}</strong></p>
                          <p>1355 Market St, Suite 900 <br>
                            San Francisco, CA 94103</p>
                          <p>Điện thoại: (123) 456-7890</p>
                        </address>
                        <a href="#/" class="check-btn sqr-btn"><i class="fa fa-edit"></i> Chỉnh Sửa Địa Chỉ</a>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="account-info" role="tabpanel" aria-labelledby="account-info-tab">
                      <div class="myaccount-content">
                        <h3>Chi Tiết Tài Khoản</h3>
                        <div class="account-details-form">
                          <form action="#" method="POST">
                            @csrf
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="single-input-item">
                                  <label for="first-name" class="required">Họ</label>
                                  <input type="text" id="first-name" value="{{ auth()->user()->name ?? 'Alex' }}" />
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="single-input-item">
                                  <label for="last-name" class="required">Tên</label>
                                  <input type="text" id="last-name" value="Tuntuni" />
                                </div>
                              </div>
                            </div>
                            <div class="single-input-item">
                              <label for="display-name" class="required">Tên Hiển Thị</label>
                              <input type="text" id="display-name" value="{{ auth()->user()->name ?? 'Alex Tuntuni' }}" />
                            </div>
                            <div class="single-input-item">
                              <label for="email" class="required">Địa Chỉ Email</label>
                              <input type="email" id="email" value="{{ auth()->user()->email ?? 'alex@example.com' }}" />
                            </div>
                            <fieldset>
                              <legend>Thay đổi mật khẩu</legend>
                              <div class="single-input-item">
                                <label for="current-pwd" class="required">Mật Khẩu Hiện Tại</label>
                                <input type="password" id="current-pwd" />
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="single-input-item">
                                    <label for="new-pwd" class="required">Mật Khẩu Mới</label>
                                    <input type="password" id="new-pwd" />
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="single-input-item">
                                    <label for="confirm-pwd" class="required">Xác Nhận Mật Khẩu</label>
                                    <input type="password" id="confirm-pwd" />
                                  </div>
                                </div>
                              </div>
                            </fieldset>
                            <div class="single-input-item">
                              <button class="check-btn sqr-btn">Lưu Thay Đổi</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End My Account Wrapper ==-->
@endsection
