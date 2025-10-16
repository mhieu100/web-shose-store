@extends('layouts.frontend')

@section('title', 'Dashboard Cộng Tác Viên')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Dashboard Cộng Tác Viên</h2>
            
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">{{ $stats['total_links'] }}</h5>
                            <p class="card-text">Tổng Link</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($stats['total_clicks']) }}</h5>
                            <p class="card-text">Lượt Click</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($stats['total_conversions']) }}</h5>
                            <p class="card-text">Chuyển Đổi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($stats['pending_commission']) }}đ</h5>
                            <p class="card-text">Hoa Hồng Chờ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <!-- Navigation Pills -->
            <ul class="nav nav-pills nav-fill mb-4">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('affiliate.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('affiliate.products') }}">
                        <i class="fas fa-shopping-bag"></i> Tạo Link SP
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('affiliate.guide') }}">
                        <i class="fas fa-book"></i> Hướng Dẫn
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('collaborator.status') }}">
                        <i class="fas fa-user-check"></i> Thông Tin CTV
                    </a>
                </li>
            </ul>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Thao Tác Nhanh</h5>
                            <span class="badge bg-success">Mã CTV: {{ Auth::user()->affiliate_code }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('affiliate.products') }}" class="btn btn-primary w-100">
                                        <i class="fas fa-plus"></i> Tạo Link Mới
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <button class="btn btn-info w-100" onclick="copyAffiliateCode()">
                                        <i class="fas fa-copy"></i> Copy Mã CTV
                                    </button>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('affiliate.guide') }}" class="btn btn-warning w-100">
                                        <i class="fas fa-book"></i> Xem Hướng Dẫn
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <button class="btn btn-success w-100" onclick="showQuickShare()">
                                        <i class="fas fa-share"></i> Share Nhanh
                                    </button>
                                </div>
                            </div>
                            
                            <!-- My Affiliate Code Info -->
                            <div class="alert alert-info mt-3">
                                <h6><i class="fas fa-info-circle"></i> Thông Tin Của Bạn:</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Mã CTV:</strong> {{ Auth::user()->affiliate_code }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Tỷ lệ hoa hồng:</strong> {{ Auth::user()->commission_rate }}%
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Tổng link:</strong> {{ $stats['total_links'] }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Hoa hồng chờ:</strong> {{ number_format($stats['pending_commission']) }}đ
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="affiliateTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab">
                        Links Affiliate
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="commissions-tab" data-bs-toggle="tab" data-bs-target="#commissions" type="button" role="tab">
                        Hoa Hồng
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="affiliateTabContent">
                <!-- Affiliate Links Tab -->
                <div class="tab-pane fade show active" id="links" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @if($affiliateLinks->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sản Phẩm</th>
                                                <th>Link Code</th>
                                                <th>Clicks</th>
                                                <th>Chuyển Đổi</th>
                                                <th>Tỷ Lệ</th>
                                                <th>Trạng Thái</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($affiliateLinks as $link)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('product.show', $link->product->id) }}" target="_blank">
                                                        {{ $link->product->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <code>{{ $link->link_code }}</code>
                                                </td>
                                                <td>{{ number_format($link->clicks) }}</td>
                                                <td>{{ number_format($link->conversions) }}</td>
                                                <td>{{ $link->conversion_rate }}%</td>
                                                <td>
                                                    <span class="badge {{ $link->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $link->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" onclick="copyLink('{{ $link->affiliate_url }}')">
                                                        Copy Link
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $affiliateLinks->links() }}
                            @else
                                <div class="text-center py-4">
                                    <p>Chưa có link affiliate nào.</p>
                                    <a href="{{ route('affiliate.products') }}" class="btn btn-primary">Tạo Link Đầu Tiên</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Commissions Tab -->
                <div class="tab-pane fade" id="commissions" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @if($commissions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Đơn Hàng</th>
                                                <th>Sản Phẩm</th>
                                                <th>Giá Trị Đơn</th>
                                                <th>Tỷ Lệ</th>
                                                <th>Hoa Hồng</th>
                                                <th>Trạng Thái</th>
                                                <th>Ngày Tạo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($commissions as $commission)
                                            <tr>
                                                <td>#{{ $commission->order->number ?? $commission->order_id }}</td>
                                                <td>{{ $commission->product->name ?? 'N/A' }}</td>
                                                <td>{{ number_format($commission->order_amount) }}đ</td>
                                                <td>{{ $commission->commission_rate }}%</td>
                                                <td>{{ number_format($commission->commission_amount) }}đ</td>
                                                <td>
                                                    <span class="badge bg-{{ $commission->status_color }}">
                                                        {{ $commission->status_label }}
                                                    </span>
                                                </td>
                                                <td>{{ $commission->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $commissions->links() }}
                            @else
                                <div class="text-center py-4">
                                    <p>Chưa có hoa hồng nào.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        alert('Đã copy link thành công!');
    });
}

function copyAffiliateCode() {
    navigator.clipboard.writeText('{{ Auth::user()->affiliate_code }}').then(() => {
        alert('Đã copy mã CTV thành công!');
    });
}

function showQuickShare() {
    const myCode = '{{ Auth::user()->affiliate_code }}';
    const siteUrl = '{{ url("/") }}';
    const shareText = `🎉 Mình là Cộng tác viên của ${siteUrl}
💎 Mã CTV: ${myCode}
🛍️ Shop ngay và nhận ưu đãi tốt nhất!
📱 Liên hệ mình để được tư vấn sản phẩm phù hợp nhé!`;
    
    // Create quick share modal
    const modal = `
        <div class="modal fade" id="quickShareModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Share Thông Tin CTV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control mb-3" rows="6" id="shareText">${shareText}</textarea>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" onclick="copyText('shareText')">
                                <i class="fas fa-copy"></i> Copy Text
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal
    const existing = document.getElementById('quickShareModal');
    if (existing) existing.remove();
    
    // Add and show modal
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('quickShareModal')).show();
}

function copyText(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    navigator.clipboard.writeText(element.value).then(() => {
        alert('Đã copy thành công!');
    });
}
</script>
@endsection