@extends('layouts.frontend')

@section('title', 'Đăng ký cộng tác viên - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Đăng ký cộng tác viên</h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li>Đăng ký cộng tác viên</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Collaborator Registration Area ==-->
    <section class="account-area section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($existingApplication)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Trạng thái đăng ký cộng tác viên</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Họ tên:</strong> {{ $existingApplication->full_name }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ $existingApplication->phone }}</p>
                                        <p><strong>Ngày đăng ký:</strong> {{ $existingApplication->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Trạng thái:</strong>
                                            @if($existingApplication->status === 'pending')
                                                <span class="badge bg-warning">Đang chờ duyệt</span>
                                            @elseif($existingApplication->status === 'approved')
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @else
                                                <span class="badge bg-danger">Từ chối</span>
                                            @endif
                                        </p>
                                        @if($existingApplication->admin_note)
                                            <p><strong>Ghi chú:</strong> {{ $existingApplication->admin_note }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if($existingApplication->status === 'approved')
                                    <div class="alert alert-success mt-3">
                                        <h5>🎉 Chúc mừng!</h5>
                                        <p>Bạn đã được chấp nhận làm cộng tác viên. Vui lòng liên hệ admin để nhận thông tin chi tiết về chương trình hoa hồng.</p>
                                    </div>
                                @elseif($existingApplication->status === 'pending')
                                    <div class="alert alert-info mt-3">
                                        <h5>⏳ Đang xử lý</h5>
                                        <p>Đơn đăng ký của bạn đang được xem xét. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Đăng ký làm cộng tác viên</h4>
                                <p class="text-muted mt-2">Gia nhập đội ngũ cộng tác viên để nhận hoa hồng từ việc giới thiệu khách hàng</p>
                            </div>
                            <div class="card-body">
                                @auth
                                    <form action="{{ route('collaborator.store') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                                       id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                                                @error('full_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_card_number" class="form-label">Số CMND/CCCD <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('id_card_number') is-invalid @enderror"
                                                   id="id_card_number" name="id_card_number" value="{{ old('id_card_number') }}" required>
                                            @error('id_card_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="bank_name" class="form-label">Tên ngân hàng <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                                       id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                                                       placeholder="VD: Vietcombank, VietinBank..." required>
                                                @error('bank_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="bank_account" class="form-label">Số tài khoản <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('bank_account') is-invalid @enderror"
                                                       id="bank_account" name="bank_account" value="{{ old('bank_account') }}" required>
                                                @error('bank_account')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bank_account_name" class="form-label">Tên chủ tài khoản <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_account_name') is-invalid @enderror"
                                                   id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name') }}" required>
                                            @error('bank_account_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="reason" class="form-label">Lý do muốn làm cộng tác viên</label>
                                            <textarea class="form-control @error('reason') is-invalid @enderror"
                                                      id="reason" name="reason" rows="3"
                                                      placeholder="Chia sẻ lý do bạn muốn trở thành cộng tác viên của chúng tôi...">{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="experience" class="form-label">Kinh nghiệm bán hàng/marketing</label>
                                            <textarea class="form-control @error('experience') is-invalid @enderror"
                                                      id="experience" name="experience" rows="3"
                                                      placeholder="Mô tả kinh nghiệm bán hàng, marketing hoặc các kỹ năng liên quan...">{{ old('experience') }}</textarea>
                                            @error('experience')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="pe-7s-check"></i> Gửi đơn đăng ký
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-info text-center">
                                        <h5>Vui lòng đăng nhập để đăng ký cộng tác viên</h5>
                                        <p>Bạn cần có tài khoản để có thể đăng ký làm cộng tác viên.</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary me-2">Đăng nhập</a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Đăng ký tài khoản</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--== End Collaborator Registration Area ==-->
@endsection

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}
.form-label {
    font-weight: 600;
    color: #495057;
}
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
.badge {
    font-size: 0.875em;
}
</style>
@endpush
