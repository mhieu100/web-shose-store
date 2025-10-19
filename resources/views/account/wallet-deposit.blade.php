@extends('layouts.frontend')

@section('title', 'Nạp Tiền Vào Ví')

@section('content')
<!-- Begin Main Content Area -->
<main class="main-content">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('account.index') }}">Tài khoản</a></li>
                    <li class="active">Nạp tiền vào ví</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-section section section-padding-top-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="fa fa-wallet"></i> Nạp Tiền Vào Ví
                            </h4>
                        </div>
                        <div class="card-body p-5">
                            <!-- Current Balance -->
                            <div class="alert alert-info mb-4">
                                <h5 class="mb-0">
                                    <i class="fa fa-info-circle"></i> Số dư hiện tại:
                                    <strong>{{ number_format($walletBalance ?? 0) }}₫</strong>
                                </h5>
                            </div>

                            <!-- Deposit Form -->
                            <form action="{{ route('account.wallet.deposit.process') }}" method="POST" id="depositForm">
                                @csrf

                                <div class="row">
                                    <!-- Amount Input -->
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="amount" class="form-label">
                                                Số tiền nạp (VNĐ) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                   class="form-control form-control-lg @error('amount') is-invalid @enderror"
                                                   id="amount"
                                                   name="amount"
                                                   min="10000"
                                                   max="50000000"
                                                   step="1000"
                                                   value="{{ old('amount') }}"
                                                   placeholder="Nhập số tiền (tối thiểu 10,000₫)"
                                                   required>
                                            <small class="text-muted">Tối thiểu: 10,000₫ - Tối đa: 50,000,000₫</small>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Quick Amount Buttons -->
                                        <div class="mb-4">
                                            <label class="form-label">Chọn nhanh:</label>
                                            <div class="btn-group d-flex flex-wrap gap-2" role="group">
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="50000">50,000₫</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="100000">100,000₫</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="200000">200,000₫</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="500000">500,000₫</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="1000000">1,000,000₫</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Method Selection -->
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">
                                                Phương thức thanh toán <span class="text-danger">*</span>
                                            </label>

                                            <!-- PayPal -->
                                            <div class="form-check payment-option mb-3" style="border: 2px solid #ddd; border-radius: 8px; padding: 15px;">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="payment_method"
                                                       id="paypal"
                                                       value="paypal"
                                                       {{ old('payment_method', 'paypal') == 'paypal' ? 'checked' : '' }}
                                                       required>
                                                <label class="form-check-label w-100" for="paypal">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fab fa-paypal fa-2x text-info me-3"></i>
                                                        <div>
                                                            <strong>PayPal</strong><br>
                                                            <small class="text-muted">Nhanh chóng và an toàn</small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- Bank Transfer -->
                                            <div class="form-check payment-option" style="border: 2px solid #ddd; border-radius: 8px; padding: 15px;">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="payment_method"
                                                       id="bank_transfer"
                                                       value="bank_transfer"
                                                       {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="bank_transfer">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-bank fa-2x text-primary me-3"></i>
                                                        <div>
                                                            <strong>Chuyển khoản ngân hàng</strong><br>
                                                            <small class="text-muted">Cần xác minh (1-24 giờ)</small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            @error('payment_method')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fa fa-arrow-right"></i> Tiếp tục nạp tiền
                                    </button>
                                    <a href="{{ route('account.index') }}" class="btn btn-outline-secondary btn-lg px-5 ms-3">
                                        <i class="fa fa-times"></i> Hủy
                                    </a>
                                </div>
                            </form>

                            <!-- Recent Transactions -->
                            @if($recentTransactions->isNotEmpty())
                            <div class="mt-5">
                                <h5 class="mb-3">Giao dịch gần đây</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Loại</th>
                                                <th>Số tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentTransactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($transaction->type === 'deposit')
                                                        <span class="badge bg-primary">Nạp tiền</span>
                                                    @elseif($transaction->type === 'refund')
                                                        <span class="badge bg-success">Hoàn tiền</span>
                                                    @elseif($transaction->type === 'payment')
                                                        <span class="badge bg-danger">Thanh toán</span>
                                                    @endif
                                                </td>
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Main Content Area End Here -->

@push('scripts')
<script>
$(document).ready(function() {
    // Quick amount selection
    $('.quick-amount').click(function() {
        const amount = $(this).data('amount');
        $('#amount').val(amount);
        $('.quick-amount').removeClass('active');
        $(this).addClass('active');
    });

    // Format number input
    $('#amount').on('blur', function() {
        const val = $(this).val();
        if (val) {
            $(this).val(Math.round(val));
        }
    });
});
</script>
@endpush
@endsection
