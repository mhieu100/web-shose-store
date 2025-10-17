@extends('layouts.frontend')

@section('title', 'Trạng Thái Cộng Tác Viên')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Trạng Thái Đăng Ký Cộng Tác Viên</h5>
                </div>
                <div class="card-body">
                    @if($application)
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Họ tên:</strong></div>
                            <div class="col-md-8">{{ $application->full_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Số điện thoại:</strong></div>
                            <div class="col-md-8">{{ $application->phone }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Trạng thái:</strong></div>
                            <div class="col-md-8">
                                @if($application->status === 'pending')
                                    <span class="badge bg-warning">Chờ duyệt</span>
                                @elseif($application->status === 'approved')
                                    <span class="badge bg-success">Đã duyệt</span>
                                @else
                                    <span class="badge bg-danger">Đã từ chối</span>
                                @endif
                            </div>
                        </div>
                        @if($application->admin_note)
                            <div class="row mb-3">
                                <div class="col-md-4"><strong>Ghi chú từ admin:</strong></div>
                                <div class="col-md-8">{{ $application->admin_note }}</div>
                            </div>
                        @endif
                        
                        @if($application->status === 'approved' && Auth::user()->isActiveAffiliate())
                            <div class="alert alert-success">
                                <h6><i class="fas fa-check-circle"></i> Chúc mừng! Bạn đã trở thành Cộng Tác Viên</h6>
                                <p class="mb-2">
                                    <strong>Mã CTV của bạn:</strong> 
                                    <code class="bg-light px-2 py-1">{{ Auth::user()->affiliate_code }}</code>
                                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyAffiliateCode()">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </p>
                                <p class="mb-2"><strong>Tỷ lệ hoa hồng:</strong> {{ Auth::user()->commission_rate }}%</p>
                                
                                <div class="mt-3">
                                    <a href="{{ route('affiliate.dashboard') }}" class="btn btn-primary me-2">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard CTV
                                    </a>
                                    <a href="{{ route('affiliate.products') }}" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Tạo Link Affiliate
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        @if($application->status === 'approved' && !Auth::user()->isActiveAffiliate())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                Đơn đăng ký đã được duyệt. Admin đang kích hoạt tài khoản CTV cho bạn.
                            </div>
                        @endif
                    @else
                        <div class="text-center">
                            <p>Bạn chưa đăng ký làm cộng tác viên.</p>
                            <a href="{{ route('collaborator.register') }}" class="btn btn-primary">Đăng Ký Ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyAffiliateCode() {
    navigator.clipboard.writeText('{{ Auth::user()->affiliate_code ?? "" }}').then(() => {
        alert('Đã copy mã CTV thành công!');
    });
}
</script>
@endsection