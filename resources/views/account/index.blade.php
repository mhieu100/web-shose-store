@extends('layouts.frontend')

@section('title', 'Tài Khoản Của Tôi - Cửa Hàng Giày')

@section('content')
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
        ['label' => 'Tài khoản', 'icon' => 'user-circle', 'active' => true]
    ]" />

    <!--== Start Page Header Area Wrapper ==-->
  <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Tài Khoản Của Tôi</h2>
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
              <!-- Horizontal Navigation Tabs -->
              <nav class="mb-4">
                <div class="myaccount-tab-menu-horizontal nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="dashboad-tab" data-bs-toggle="tab" data-bs-target="#dashboad" type="button" role="tab" aria-controls="dashboad" aria-selected="true">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tổng Quan</span>
                  </button>
                  <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Đơn Hàng</span>
                  </button>
                  <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet" type="button" role="tab" aria-controls="wallet" aria-selected="false">
                    <i class="fas fa-wallet"></i>
                    <span>Ví Tiền</span>
                    @if(isset($walletBalance) && $walletBalance > 0)
                    <span class="badge bg-success">{{ number_format($walletBalance, 0, ',', '.') }}₫</span>
                    @endif
                  </button>
                  <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button" role="tab" aria-controls="transactions" aria-selected="false">
                    <i class="fas fa-history"></i>
                    <span>Lịch sử giao dịch</span>
                  </button>
                  <button class="nav-link" id="account-info-tab" data-bs-toggle="tab" data-bs-target="#account-info" type="button" role="tab" aria-controls="account-info" aria-selected="false">
                    <i class="fas fa-user-cog"></i>
                    <span>Cài Đặt</span>
                  </button>
                  <form method="POST" action="{{ route('logout') }}" style="display: contents;">
                    @csrf
                    <button class="nav-link logout-btn" type="submit">
                      <i class="fas fa-sign-out-alt"></i>
                      <span>Đăng Xuất</span>
                    </button>
                  </form>
                </div>
              </nav>

              <!-- Tab Content -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel" aria-labelledby="dashboad-tab">
                      <!-- User Profile Overview -->
                      <div class="user-profile-overview mb-4">
                        <div class="row g-4">
                          <!-- Profile Card -->
                          <div class="col-lg-4">
                            <div class="profile-card">
                              <div class="profile-card-header">
                                <div class="profile-avatar-large">
                                  {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="profile-card-info">
                                  <h4 class="profile-card-name">{{ auth()->user()->name ?? 'Khách hàng' }}</h4>
                                  <p class="profile-card-email">{{ auth()->user()->email }}</p>
                                  <span class="profile-badge">
                                    <i class="fas fa-crown"></i> Thành viên
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Quick Info Cards -->
                          <div class="col-lg-8">
                            <div class="row g-3">
                              <div class="col-md-6">
                                <div class="quick-info-card">
                                  <div class="quick-info-icon">
                                    <i class="fas fa-user"></i>
                                  </div>
                                  <div class="quick-info-content">
                                    <label>Họ và Tên</label>
                                    <span>{{ auth()->user()->name ?? 'Chưa cập nhật' }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="quick-info-card">
                                  <div class="quick-info-icon">
                                    <i class="fas fa-phone"></i>
                                  </div>
                                  <div class="quick-info-content">
                                    <label>Số điện thoại</label>
                                    <span>{{ auth()->user()->phone ?? 'Chưa cập nhật' }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="quick-info-card">
                                  <div class="quick-info-icon">
                                    <i class="fas fa-envelope"></i>
                                  </div>
                                  <div class="quick-info-content">
                                    <label>Email</label>
                                    <span>{{ auth()->user()->email }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="quick-info-card">
                                  <div class="quick-info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                  </div>
                                  <div class="quick-info-content">
                                    <label>Địa chỉ</label>
                                    <span>{{ auth()->user()->address ?? 'Chưa cập nhật' }}</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="myaccount-content">
                        <h3>Thống Kê Hoạt Động</h3>
                        <div class="welcome">
                          <p>Xin chào, <strong>{{ auth()->user()->name ?? 'Khách hàng' }}</strong>! Chào mừng bạn quay trở lại.</p>
                        </div>

                        @if(isset($stats))
                        <div class="row mt-4 g-4">
                          <div class="col-md-6 col-lg-3">
                            <div class="modern-stat-card modern-stat-primary">
                              <div class="stat-number">{{ $stats['total_orders'] }}</div>
                              <div class="stat-info">
                                <div class="stat-icon-box">
                                  <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="stat-label-text">
                                  <span class="label-main">TỔNG</span>
                                  <span class="label-sub">ĐỎN HÀNG</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-3">
                            <div class="modern-stat-card modern-stat-warning">
                              <div class="stat-number">{{ $stats['pending_orders'] }}</div>
                              <div class="stat-info">
                                <div class="stat-icon-box">
                                  <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-label-text">
                                  <span class="label-main">ĐANG</span>
                                  <span class="label-sub">XỬ LÝ</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-3">
                            <div class="modern-stat-card modern-stat-success">
                              <div class="stat-number">{{ $stats['completed_orders'] }}</div>
                              <div class="stat-info">
                                <div class="stat-icon-box">
                                  <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-label-text">
                                  <span class="label-main">HOÀN</span>
                                  <span class="label-sub">THÀNH</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-3">
                            <div class="modern-stat-card modern-stat-info">
                              <div class="stat-number stat-number-currency">{{ number_format($stats['total_spent'], 0, ',', '.') }}<span class="currency-symbol">₫</span></div>
                              <div class="stat-info">
                                <div class="stat-icon-box">
                                  <i class="fas fa-coins"></i>
                                </div>
                                <div class="stat-label-text">
                                  <span class="label-main">TỔNG CHI</span>
                                  <span class="label-sub">TIÊU</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                      <div class="myaccount-content">
                        <h3>Đơn Hàng</h3>
                        @include('account.partials.orders-table')
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

                    <!-- Transaction History Tab -->
                    <div class="tab-pane fade" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                      <div class="myaccount-content">
                        <h3 class="mb-4">
                          <i class="fas fa-history text-primary"></i>
                          Lịch sử giao dịch
                        </h3>

                        @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                          <div class="table-responsive">
                            <table class="table table-hover align-middle">
                              <thead class="table-light">
                                <tr>
                                  <th style="width: 10%;">
                                    <i class="fas fa-hashtag text-muted me-1"></i>
                                    ID
                                  </th>
                                  <th style="width: 20%;">
                                    <i class="fas fa-exchange-alt text-muted me-1"></i>
                                    Loại giao dịch
                                  </th>
                                  <th style="width: 25%;">
                                    <i class="fas fa-align-left text-muted me-1"></i>
                                    Mô tả
                                  </th>
                                  <th style="width: 15%;">
                                    <i class="fas fa-money-bill-wave text-muted me-1"></i>
                                    Số tiền
                                  </th>
                                  <th style="width: 15%;">
                                    <i class="fas fa-info-circle text-muted me-1"></i>
                                    Trạng thái
                                  </th>
                                  <th style="width: 15%;">
                                    <i class="fas fa-calendar text-muted me-1"></i>
                                    Thời gian
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($recentTransactions as $transaction)
                                  <tr>
                                    <td class="fw-semibold text-muted">
                                      #{{ $transaction->id }}
                                    </td>
                                    <td>
                                      @php
                                        $typeConfig = match($transaction->type) {
                                          'refund' => ['badge' => 'bg-info', 'icon' => 'fa-undo', 'label' => 'Hoàn tiền'],
                                          'withdrawal' => ['badge' => 'bg-warning', 'icon' => 'fa-arrow-down', 'label' => 'Rút tiền'],
                                          'deposit' => ['badge' => 'bg-success', 'icon' => 'fa-arrow-up', 'label' => 'Nạp tiền'],
                                          'payment' => ['badge' => 'bg-danger', 'icon' => 'fa-shopping-cart', 'label' => 'Thanh toán'],
                                          default => ['badge' => 'bg-secondary', 'icon' => 'fa-exchange-alt', 'label' => ucfirst($transaction->type)]
                                        };
                                      @endphp
                                      <span class="badge {{ $typeConfig['badge'] }}">
                                        <i class="fas {{ $typeConfig['icon'] }} me-1"></i>
                                        {{ $typeConfig['label'] }}
                                      </span>
                                    </td>
                                    <td>
                                      <div class="text-truncate" style="max-width: 250px;" title="{{ $transaction->description }}">
                                        {{ $transaction->description ?? 'N/A' }}
                                      </div>
                                      @if($transaction->order_id)
                                        <small class="text-muted">
                                          <i class="fas fa-link me-1"></i>
                                          Đơn hàng: <a href="{{ route('account.order.show', $transaction->order_id) }}" class="text-decoration-none">#{{ $transaction->order_id }}</a>
                                        </small>
                                      @endif
                                    </td>
                                    <td>
                                      <span class="fw-bold {{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->amount >= 0 ? '+' : '' }}{{ number_format($transaction->amount, 0, ',', '.') }}₫
                                      </span>
                                    </td>
                                    <td>
                                      @php
                                        $statusConfig = match($transaction->status) {
                                          'completed' => ['badge' => 'bg-success', 'icon' => 'fa-check-circle', 'label' => 'Hoàn thành'],
                                          'pending' => ['badge' => 'bg-warning', 'icon' => 'fa-clock', 'label' => 'Đang xử lý'],
                                          'failed' => ['badge' => 'bg-danger', 'icon' => 'fa-times-circle', 'label' => 'Thất bại'],
                                          default => ['badge' => 'bg-secondary', 'icon' => 'fa-question-circle', 'label' => ucfirst($transaction->status)]
                                        };
                                      @endphp
                                      <span class="badge {{ $statusConfig['badge'] }}">
                                        <i class="fas {{ $statusConfig['icon'] }} me-1"></i>
                                        {{ $statusConfig['label'] }}
                                      </span>
                                    </td>
                                    <td>
                                      <div class="small">
                                        <div class="fw-semibold">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                        <div class="text-muted">{{ $transaction->created_at->format('H:i:s') }}</div>
                                      </div>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>

                          <div class="alert alert-info mt-3">
                            <p class="mb-0">
                              <i class="fa fa-info-circle me-2"></i>
                              Hiển thị {{ $recentTransactions->count() }} giao dịch gần nhất.
                              Giao dịch sẽ được lưu trữ vĩnh viễn để bạn theo dõi.
                            </p>
                          </div>
                        @else
                          <div class="text-center py-5">
                            <i class="fas fa-history fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có giao dịch nào</h5>
                            <p class="text-muted">Lịch sử giao dịch của bạn sẽ hiển thị tại đây.</p>
                          </div>
                        @endif
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

                          <form id="update-profile-form" action="{{ route('account.update-profile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div id="profile-messages"></div>
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="single-input-item">
                                  <label for="name" class="required">Họ và Tên</label>
                                  <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                                  <span class="text-danger error-name"></span>
                                </div>
                              </div>
                            </div>
                            <div class="single-input-item">
                              <label for="email" class="required">Địa Chỉ Email</label>
                              <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                              <span class="text-danger error-email"></span>
                            </div>
                            <div class="single-input-item">
                              <label for="phone">Số Điện Thoại</label>
                              <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" />
                              <span class="text-danger error-phone"></span>
                            </div>
                            <div class="single-input-item">
                              <label for="address">Địa Chỉ</label>
                              <textarea id="address" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                              <span class="text-danger error-address"></span>
                            </div>
                            <div class="single-input-item">
                              <button type="submit" class="check-btn sqr-btn">
                                <span class="btn-text">Cập Nhật Thông Tin</span>
                                <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Đang xử lý...</span>
                              </button>
                            </div>
                          </form>

                          <!-- Password Change Form -->
                          <form id="update-password-form" action="{{ route('account.update-password') }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <fieldset>
                              <legend>Thay đổi mật khẩu</legend>
                              <div id="password-messages"></div>
                              <div class="single-input-item">
                                <label for="current_password" class="required">Mật Khẩu Hiện Tại</label>
                                <input type="password" id="current_password" name="current_password" required />
                                <span class="text-danger error-current_password"></span>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="single-input-item">
                                    <label for="password" class="required">Mật Khẩu Mới</label>
                                    <input type="password" id="password" name="password" required />
                                    <span class="text-danger error-password"></span>
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
                                <button type="submit" class="check-btn sqr-btn">
                                  <span class="btn-text">Thay Đổi Mật Khẩu</span>
                                  <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Đang xử lý...</span>
                                </button>
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

@push('styles')
<link rel="stylesheet" href="{{ asset('css/account-page.css') }}">
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // AJAX Pagination for Orders
    function loadOrders(page) {
        // Show loading state
        $('#orders-table-container').css('opacity', '0.5');

        $.ajax({
            url: '{{ route("account.index") }}',
            type: 'GET',
            data: {
                page: page,
                ajax: 1
            },
            success: function(response) {
                $('#orders-table-container').html(response);
                $('#orders-table-container').css('opacity', '1');

                // Scroll to top of orders section smoothly
                $('html, body').animate({
                    scrollTop: $('#orders-table-container').offset().top - 100
                }, 300);
            },
            error: function(xhr) {
                console.error('Error loading orders:', xhr);
                $('#orders-table-container').css('opacity', '1');
                alert('Có lỗi xảy ra khi tải danh sách đơn hàng. Vui lòng thử lại.');
            }
        });
    }

    // Handle pagination clicks
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();

        if ($(this).hasClass('pe-none')) {
            return false;
        }

        const page = $(this).data('page');
        loadOrders(page);
    });

    // Handle cancel order form with AJAX
    $(document).on('submit', '.cancel-order-form', function(e) {
        e.preventDefault();

        if (!confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
            return false;
        }

        const form = $(this);
        const button = form.find('button[type="submit"]');
        const originalText = button.html();

        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: response.message || "Đơn hàng đã được hủy thành công!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#28a745"
                        }).showToast();
                    }

                    // Reload orders table
                    const currentPage = $('#orders-pagination .px-3.py-1.text-white').text() || 1;
                    loadOrders(currentPage);
                } else {
                    alert(response.message || 'Có lỗi xảy ra khi hủy đơn hàng.');
                    button.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                console.error('Error cancelling order:', xhr);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                button.prop('disabled', false).html(originalText);
            }
        });
    });

    // Handle confirm delivery form with AJAX
    $(document).on('submit', '.confirm-delivery-form', function(e) {
        e.preventDefault();

        if (!confirm('Bạn có chắc đã nhận được hàng?')) {
            return false;
        }

        const form = $(this);
        const button = form.find('button[type="submit"]');
        const originalText = button.html();

        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: response.message || "Xác nhận đã nhận hàng thành công!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#28a745"
                        }).showToast();
                    }

                    // Reload orders table
                    const currentPage = $('#orders-pagination .px-3.py-1.text-white').text() || 1;
                    loadOrders(currentPage);
                } else {
                    alert(response.message || 'Có lỗi xảy ra khi xác nhận đơn hàng.');
                    button.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                console.error('Error confirming delivery:', xhr);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                button.prop('disabled', false).html(originalText);
            }
        });
    });

    // AJAX Update Profile Form
    $('#update-profile-form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const button = form.find('button[type="submit"]');
        const btnText = button.find('.btn-text');
        const btnLoading = button.find('.btn-loading');

        // Clear previous errors
        form.find('.text-danger').text('');
        $('#profile-messages').html('');

        // Show loading state
        button.prop('disabled', true);
        btnText.hide();
        btnLoading.show();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $('#profile-messages').html(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-check-circle me-2"></i>' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );

                    // Show toast if available
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: response.message || "Cập nhật thông tin thành công!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#28a745"
                        }).showToast();
                    }

                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: $('#profile-messages').offset().top - 100
                    }, 300);
                } else {
                    $('#profile-messages').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>' + (response.message || 'Có lỗi xảy ra') +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }

                // Reset button
                button.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
            },
            error: function(xhr) {
                console.error('Error updating profile:', xhr);

                // Show validation errors
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        form.find('.error-' + field).text(messages[0]);
                    });

                    $('#profile-messages').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>Vui lòng kiểm tra lại thông tin nhập vào.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                } else {
                    $('#profile-messages').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>Có lỗi xảy ra. Vui lòng thử lại.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }

                // Reset button
                button.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
            }
        });
    });

    // AJAX Update Password Form
    $('#update-password-form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const button = form.find('button[type="submit"]');
        const btnText = button.find('.btn-text');
        const btnLoading = button.find('.btn-loading');

        // Clear previous errors
        form.find('.text-danger').text('');
        $('#password-messages').html('');

        // Show loading state
        button.prop('disabled', true);
        btnText.hide();
        btnLoading.show();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $('#password-messages').html(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-check-circle me-2"></i>' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );

                    // Show toast if available
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: response.message || "Đổi mật khẩu thành công!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#28a745"
                        }).showToast();
                    }

                    // Clear password fields
                    form[0].reset();

                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: $('#password-messages').offset().top - 100
                    }, 300);
                } else {
                    $('#password-messages').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>' + (response.message || 'Có lỗi xảy ra') +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }

                // Reset button
                button.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
            },
            error: function(xhr) {
                console.error('Error updating password:', xhr);

                // Show validation errors
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        form.find('.error-' + field).text(messages[0]);
                    });

                    $('#password-messages').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>Vui lòng kiểm tra lại thông tin nhập vào.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                } else {
                    $('#password-messages').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>Có lỗi xảy ra. Vui lòng thử lại.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }

                // Reset button
                button.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
            }
        });
    });
});
</script>
@endpush
