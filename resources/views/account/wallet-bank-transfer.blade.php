@extends('layouts.frontend')

@section('title', 'Thông Tin Chuyển Khoản')

@section('content')
<!-- Begin Main Content Area -->
<main class="main-content">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('account.index') }}">Tài khoản</a></li>
                    <li class="active">Chuyển khoản nạp tiền</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-section section section-padding-top-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="fa fa-bank"></i> Thông Tin Chuyển Khoản
                            </h4>
                        </div>
                        <div class="card-body p-5">
                            <!-- Alert -->
                            <div class="alert alert-warning">
                                <h5><i class="fa fa-exclamation-triangle"></i> Quan trọng!</h5>
                                <p class="mb-0">Vui lòng chuyển khoản CHÍNH XÁC số tiền và nội dung bên dưới để được xác nhận nhanh nhất.</p>
                            </div>

                            <!-- Amount Info -->
                            <div class="card bg-light mb-4">
                                <div class="card-body text-center">
                                    <p class="mb-1 text-muted">Số tiền cần nạp</p>
                                    <h2 class="text-primary mb-0">{{ number_format($deposit->amount) }}₫</h2>
                                </div>
                            </div>

                            <!-- Bank Account Info -->
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <strong>Thông Tin Tài Khoản Ngân Hàng</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td width="40%" class="text-muted"><strong>Ngân hàng:</strong></td>
                                            <td><strong>Techcombank</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>Số tài khoản:</strong></td>
                                            <td>
                                                <strong class="text-primary">1234567890</strong>
                                                <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyToClipboard('1234567890')">
                                                    <i class="fa fa-copy"></i> Copy
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>Chủ tài khoản:</strong></td>
                                            <td><strong>CUA HANG GIAY XYZ</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted"><strong>Nội dung:</strong></td>
                                            <td>
                                                <strong class="text-danger">DEPOSIT{{ $deposit->id }} {{ auth()->user()->phone ?? auth()->user()->email }}</strong>
                                                <button class="btn btn-sm btn-outline-danger ms-2" onclick="copyToClipboard('DEPOSIT{{ $deposit->id }} {{ auth()->user()->phone ?? auth()->user()->email }}')">
                                                    <i class="fa fa-copy"></i> Copy
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Confirmation Form -->
                            <div class="card">
                                <div class="card-header">
                                    <strong>Xác Nhận Chuyển Khoản</strong>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Sau khi chuyển khoản, vui lòng điền thông tin bên dưới để chúng tôi xác minh nhanh hơn.</p>

                                    <form action="{{ route('account.wallet.deposit.bank-transfer.confirm', $deposit->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="transaction_reference" class="form-label">
                                                Mã giao dịch / Mã tham chiếu <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('transaction_reference') is-invalid @enderror"
                                                   id="transaction_reference"
                                                   name="transaction_reference"
                                                   placeholder="Nhập mã giao dịch từ ngân hàng"
                                                   required>
                                            <small class="text-muted">Mã giao dịch có thể tìm thấy trong SMS hoặc thông báo từ ngân hàng</small>
                                            @error('transaction_reference')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="transfer_proof" class="form-label">
                                                Ảnh chụp biên lai (tùy chọn)
                                            </label>
                                            <input type="file"
                                                   class="form-control @error('transfer_proof') is-invalid @enderror"
                                                   id="transfer_proof"
                                                   name="transfer_proof"
                                                   accept="image/*">
                                            <small class="text-muted">Định dạng: JPG, PNG - Tối đa 2MB</small>
                                            @error('transfer_proof')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success btn-lg px-5">
                                                <i class="fa fa-check"></i> Xác Nhận Đã Chuyển Khoản
                                            </button>
                                            <a href="{{ route('account.index') }}" class="btn btn-outline-secondary btn-lg px-5 ms-3">
                                                <i class="fa fa-arrow-left"></i> Về Tài Khoản
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="alert alert-info mt-4">
                                <h6><i class="fa fa-info-circle"></i> Lưu ý:</h6>
                                <ul class="mb-0">
                                    <li>Thời gian xử lý: 1-24 giờ làm việc</li>
                                    <li>Vui lòng chuyển khoản đúng số tiền và nội dung để được duyệt tự động</li>
                                    <li>Nếu chuyển khoản sai nội dung, quá trình xác minh sẽ lâu hơn</li>
                                    <li>Liên hệ hotline: 1900-xxxx nếu cần hỗ trợ</li>
                                </ul>
                            </div>
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
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Đã copy: ' + text);
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endpush
@endsection
