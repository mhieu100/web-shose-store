@extends('layouts.frontend')

@section('title', 'Nạp Tiền Vào Ví')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/breadcrumb-component.css') }}">
<link rel="stylesheet" href="{{ asset('css/wallet-deposit.css') }}">
@endpush

@section('content')
<!-- Begin Main Content Area -->
<main class="main-content">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
        ['label' => 'Tài khoản', 'url' => route('account.index'), 'icon' => 'user-circle'],
        ['label' => 'Nạp tiền vào ví', 'icon' => 'wallet', 'active' => true]
    ]" />

    <div class="page-section section section-padding-top-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Page Header -->
                    <div class="deposit-header text-center mb-5">
                        <div class="deposit-icon-wrapper mb-3">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h2 class="deposit-title">Nạp Tiền Vào Ví</h2>
                        <p class="deposit-subtitle text-muted">Nạp tiền nhanh chóng và an toàn vào ví của bạn</p>
                    </div>

                    <!-- Current Balance Card -->
                    <div class="balance-card mb-4">
                        <div class="balance-card-content">
                            <div class="balance-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="balance-info">
                                <label class="balance-label">Số dư hiện tại</label>
                                <div class="balance-amount">{{ number_format($walletBalance ?? 0) }}<span class="currency">₫</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Deposit Form -->
                    <div class="deposit-form-card">
                        <form action="{{ route('account.wallet.deposit.process') }}" method="POST" id="depositForm">
                            @csrf

                            <div class="row">
                                <!-- Amount Input Section -->
                                <div class="col-lg-6">
                                    <div class="form-section">
                                        <div class="form-section-header">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <h5>Số tiền nạp</h5>
                                        </div>

                                        <div class="amount-input-group">
                                            <div class="input-with-icon">
                                                <input type="number"
                                                       class="form-control amount-input @error('amount') is-invalid @enderror"
                                                       id="amount"
                                                       name="amount"
                                                       min="10000"
                                                       max="50000000"
                                                       step="1000"
                                                       value="{{ old('amount') }}"
                                                       placeholder="0"
                                                       required>
                                                <span class="input-currency">₫</span>
                                            </div>
                                            <small class="form-text">Tối thiểu: 10,000₫ - Tối đa: 50,000,000₫</small>
                                            @error('amount')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Quick Amount Buttons -->
                                        <div class="quick-amounts">
                                            <label class="quick-amounts-label">Chọn nhanh:</label>
                                            <div class="quick-amounts-grid">
                                                <button type="button" class="quick-amount-btn" data-amount="50000">
                                                    <span class="amount">50K</span>
                                                </button>
                                                <button type="button" class="quick-amount-btn" data-amount="100000">
                                                    <span class="amount">100K</span>
                                                </button>
                                                <button type="button" class="quick-amount-btn" data-amount="200000">
                                                    <span class="amount">200K</span>
                                                </button>
                                                <button type="button" class="quick-amount-btn" data-amount="500000">
                                                    <span class="amount">500K</span>
                                                </button>
                                                <button type="button" class="quick-amount-btn" data-amount="1000000">
                                                    <span class="amount">1M</span>
                                                </button>
                                                <button type="button" class="quick-amount-btn" data-amount="2000000">
                                                    <span class="amount">2M</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Method Section -->
                                <div class="col-lg-6">
                                    <div class="form-section">
                                        <div class="form-section-header">
                                            <i class="fas fa-credit-card"></i>
                                            <h5>Phương thức thanh toán</h5>
                                        </div>

                                        <div class="payment-methods">
                                            <!-- PayPal Option -->
                                            <label class="payment-method-card" for="paypal">
                                                <input type="radio"
                                                       name="payment_method"
                                                       id="paypal"
                                                       value="paypal"
                                                       {{ old('payment_method', 'paypal') == 'paypal' ? 'checked' : '' }}
                                                       required>
                                                <div class="payment-method-content">
                                                    <div class="payment-icon paypal">
                                                        <i class="fab fa-paypal"></i>
                                                    </div>
                                                    <div class="payment-info">
                                                        <h6>PayPal</h6>
                                                        <p>Nhanh chóng & An toàn</p>
                                                    </div>
                                                    <div class="payment-check">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                </div>
                                            </label>

                                            <!-- Bank Transfer Option -->
                                            <label class="payment-method-card" for="bank_transfer">
                                                <input type="radio"
                                                       name="payment_method"
                                                       id="bank_transfer"
                                                       value="bank_transfer"
                                                       {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                                <div class="payment-method-content">
                                                    <div class="payment-icon bank">
                                                        <i class="fas fa-university"></i>
                                                    </div>
                                                    <div class="payment-info">
                                                        <h6>Chuyển khoản</h6>
                                                        <p>Xác minh 1-24 giờ</p>
                                                    </div>
                                                    <div class="payment-check">
                                                        <i class="fas fa-check-circle"></i>
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

                            <!-- Submit Buttons -->
                            <div class="form-actions">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-arrow-right"></i>
                                    <span>Tiếp tục nạp tiền</span>
                                </button>
                                <a href="{{ route('account.index') }}" class="btn-cancel">
                                    <i class="fas fa-times"></i>
                                    <span>Hủy bỏ</span>
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Recent Transactions -->
                    @if(isset($recentTransactions) && $recentTransactions->isNotEmpty())
                    <div class="recent-transactions-section">
                        <div class="section-header">
                            <i class="fas fa-history"></i>
                            <h5>Giao dịch gần đây</h5>
                        </div>

                        <div class="transactions-list">
                            @foreach($recentTransactions->take(5) as $transaction)
                            <div class="transaction-item">
                                <div class="transaction-icon {{ $transaction->type }}">
                                    @if($transaction->type === 'deposit')
                                        <i class="fas fa-arrow-down"></i>
                                    @elseif($transaction->type === 'refund')
                                        <i class="fas fa-undo"></i>
                                    @elseif($transaction->type === 'payment')
                                        <i class="fas fa-shopping-cart"></i>
                                    @else
                                        <i class="fas fa-exchange-alt"></i>
                                    @endif
                                </div>
                                <div class="transaction-details">
                                    <div class="transaction-type">
                                        @if($transaction->type === 'deposit')
                                            Nạp tiền
                                        @elseif($transaction->type === 'refund')
                                            Hoàn tiền
                                        @elseif($transaction->type === 'payment')
                                            Thanh toán
                                        @else
                                            {{ ucfirst($transaction->type) }}
                                        @endif
                                    </div>
                                    <div class="transaction-date">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="transaction-amount {{ $transaction->amount >= 0 ? 'positive' : 'negative' }}">
                                    {{ $transaction->amount >= 0 ? '+' : '' }}{{ number_format($transaction->amount, 0, ',', '.') }}₫
                                </div>
                                <div class="transaction-status {{ $transaction->status }}">
                                    @if($transaction->status === 'completed')
                                        <i class="fas fa-check-circle"></i>
                                    @elseif($transaction->status === 'pending')
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
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
    $('.quick-amount-btn').click(function() {
        const amount = $(this).data('amount');
        $('#amount').val(amount);
        $('.quick-amount-btn').removeClass('active');
        $(this).addClass('active');
    });

    // Format number input
    $('#amount').on('input', function() {
        let val = $(this).val().replace(/[^0-9]/g, '');
        if (val) {
            $(this).val(val);
        }
    });

    $('#amount').on('blur', function() {
        const val = $(this).val();
        if (val) {
            $(this).val(Math.round(val));
        }
    });

    // Payment method card selection styling
    $('input[name="payment_method"]').on('change', function() {
        $('.payment-method-card').removeClass('selected');
        $(this).closest('.payment-method-card').addClass('selected');
    });

    // Set initial selected payment method
    $('input[name="payment_method"]:checked').closest('.payment-method-card').addClass('selected');
});
</script>
@endpush
@endsection
