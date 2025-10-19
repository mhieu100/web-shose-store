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
                      <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet" type="button" role="tab" aria-controls="wallet" aria-selected="false">Ví Tiền</button>
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

                        @if(isset($stats))
                        <div class="row mt-4">
                          <div class="col-md-3">
                            <div class="card text-center">
                              <div class="card-body">
                                <h5 class="card-title text-primary">{{ $stats['total_orders'] }}</h5>
                                <p class="card-text">Tổng đơn hàng</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="card text-center">
                              <div class="card-body">
                                <h5 class="card-title text-warning">{{ $stats['pending_orders'] }}</h5>
                                <p class="card-text">Đang chờ xử lý</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="card text-center">
                              <div class="card-body">
                                <h5 class="card-title text-success">{{ $stats['completed_orders'] }}</h5>
                                <p class="card-text">Đã hoàn thành</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="card text-center">
                              <div class="card-body">
                                <h5 class="card-title text-info">{{ number_format($stats['total_spent']) }}₫</h5>
                                <p class="card-text">Tổng chi tiêu</p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Wallet Balance -->
                        <div class="row mt-4">
                          <div class="col-12">
                            <div class="alert alert-info">
                              <h5 class="mb-0">
                                <i class="fa fa-wallet"></i> Số dư ví:
                                <strong>{{ number_format($stats['wallet_balance'] ?? 0) }}₫</strong>
                                <a href="#wallet" data-bs-toggle="tab" class="btn btn-sm btn-primary float-end">Xem Chi Tiết</a>
                              </h5>
                            </div>
                          </div>
                        </div>
                        @endif
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
                              @forelse($orders as $order)
                              <tr>
                                <td>#{{ $order->order_number ?? $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>
                                  <span class="badge badge-{{ $order->status_color }}">
                                    {{ $order->status->getLabel() }}
                                  </span>
                                </td>
                                <td>{{ number_format($order->total_price) }}₫</td>
                                <td>
                                  <a href="{{ route('account.order.show', $order->id) }}" class="check-btn sqr-btn">Xem</a>
                                  @if($order->canBeCancelled())
                                    <form method="POST" action="{{ route('account.order.cancel', $order->id) }}" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                      @csrf
                                      <button type="submit" class="btn btn-sm btn-danger">Hủy</button>
                                    </form>
                                  @endif
                                  @if($order->canBeConfirmedAsDelivered())
                                    <form method="POST" action="{{ route('account.order.confirm-delivery', $order->id) }}" style="display: inline;" onsubmit="return confirm('Bạn có chắc đã nhận được hàng?')">
                                      @csrf
                                      <button type="submit" class="btn btn-sm btn-success">Đã nhận hàng</button>
                                    </form>
                                  @endif
                                </td>
                              </tr>
                              @empty
                              <tr>
                                <td colspan="5" class="text-center">Bạn chưa có đơn hàng nào.</td>
                              </tr>
                              @endforelse
                            </tbody>
                          </table>
                        </div>

                        @if(isset($orders) && $orders->hasPages())
                        <div class="pagination-wrapper mt-3 d-flex justify-content-center">
                          {{ $orders->links() }}
                        </div>
                        @endif
                      </div>
                    </div>

                    <!-- Wallet Tab -->
                    <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                      <div class="myaccount-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <h3>Ví Tiền</h3>
                          <a href="{{ route('account.wallet.deposit') }}" class="btn btn-primary">
                            <i class="fa fa-plus-circle"></i> Nạp tiền vào ví
                          </a>
                        </div>

                        <!-- Current Balance -->
                        <div class="alert alert-success">
                          <h4 class="mb-0">
                            <i class="fa fa-wallet"></i> Số dư hiện tại:
                            <strong>{{ number_format($stats['wallet_balance'] ?? 0) }}₫</strong>
                          </h4>
                        </div>

                        <!-- Recent Transactions -->
                        <h5 class="mt-4 mb-3">Giao dịch gần đây</h5>
                        <div class="myaccount-table table-responsive">
                          <table class="table table-bordered">
                            <thead class="thead-light">
                              <tr>
                                <th>Ngày</th>
                                <th>Loại</th>
                                <th>Mô tả</th>
                                <th>Số tiền</th>
                                <th>Trạng thái</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($recentTransactions as $transaction)
                              <tr>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                  @if($transaction->type === 'refund')
                                    <span class="badge bg-success">Hoàn tiền</span>
                                  @elseif($transaction->type === 'payment')
                                    <span class="badge bg-danger">Thanh toán</span>
                                  @elseif($transaction->type === 'deposit')
                                    <span class="badge bg-primary">Nạp tiền</span>
                                  @elseif($transaction->type === 'withdrawal')
                                    <span class="badge bg-warning">Rút tiền</span>
                                  @endif
                                </td>
                                <td>{{ $transaction->description }}</td>
                                <td class="{{ $transaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                  {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount) }}₫
                                </td>
                                <td>
                                  @if($transaction->status === 'completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                  @elseif($transaction->status === 'pending')
                                    <span class="badge bg-warning">Đang xử lý</span>
                                  @else
                                    <span class="badge bg-danger">Thất bại</span>
                                  @endif
                                </td>
                              </tr>
                              @empty
                              <tr>
                                <td colspan="5" class="text-center">Chưa có giao dịch nào.</td>
                              </tr>
                              @endforelse
                            </tbody>
                          </table>
                        </div>

                        <div class="alert alert-info mt-3">
                          <p class="mb-0">
                            <i class="fa fa-info-circle"></i>
                            Số dư ví có thể được sử dụng để thanh toán cho các đơn hàng tiếp theo.
                            Khi bạn hủy đơn hàng đã thanh toán, tiền sẽ được hoàn lại vào ví của bạn.
                          </p>
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
                          @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                          @endif
                          @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                          @endif

                          <form action="{{ route('account.update-profile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="single-input-item">
                                  <label for="name" class="required">Họ và Tên</label>
                                  <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                                  @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror
                                </div>
                              </div>
                            </div>
                            <div class="single-input-item">
                              <label for="email" class="required">Địa Chỉ Email</label>
                              <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                              @error('email')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            <div class="single-input-item">
                              <label for="phone">Số Điện Thoại</label>
                              <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" />
                              @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            <div class="single-input-item">
                              <label for="address">Địa Chỉ</label>
                              <textarea id="address" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                              @error('address')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            <div class="single-input-item">
                              <button type="submit" class="check-btn sqr-btn">Cập Nhật Thông Tin</button>
                            </div>
                          </form>

                          <!-- Password Change Form -->
                          <form action="{{ route('account.update-password') }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <fieldset>
                              <legend>Thay đổi mật khẩu</legend>
                              <div class="single-input-item">
                                <label for="current_password" class="required">Mật Khẩu Hiện Tại</label>
                                <input type="password" id="current_password" name="current_password" required />
                                @error('current_password')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="single-input-item">
                                    <label for="password" class="required">Mật Khẩu Mới</label>
                                    <input type="password" id="password" name="password" required />
                                    @error('password')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="single-input-item">
                                    <label for="password_confirmation" class="required">Xác Nhận Mật Khẩu</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required />
                                  </div>
                                </div>
                              </div>
                              <div class="single-input-item">
                                <button type="submit" class="check-btn sqr-btn">Thay Đổi Mật Khẩu</button>
                              </div>
                            </fieldset>
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
