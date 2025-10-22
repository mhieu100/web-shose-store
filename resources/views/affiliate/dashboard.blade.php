@extends('layouts.frontend')

@section('title', 'Dashboard Cộng Tác Viên')

@push('styles')
<style>
/* Design System Variables */
:root {
    --primary-red: #DC3E37;
    --secondary-orange: #F2965B;
    --dark-text: #322A2A;
    --light-bg: #EFEBEA;
    --gray-100: #F8F9FA;
    --gray-200: #E9ECEF;
    --gray-300: #DEE2E6;
    --gray-400: #CED4DA;
    --gray-500: #ADB5BD;
    --gray-600: #6C757D;
    --success: #28A745;
    --warning: #FFC107;
    --info: #17A2B8;
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --shadow-sm: 0 2px 4px rgba(50, 42, 42, 0.08);
    --shadow-md: 0 4px 6px rgba(50, 42, 42, 0.1);
    --shadow-hover: 0 6px 12px rgba(220, 62, 55, 0.15);
}

/* Custom Page Styles */
.affiliate-dashboard {
    font-family: 'Poppins', sans-serif;
    color: var(--dark-text);
    padding: 24px 0;
}

.page-header {
    margin-bottom: 32px;
}

.page-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--dark-text);
    margin-bottom: 8px;
    line-height: 1.3;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--gray-600);
    font-weight: 400;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    gap: 20px;
    margin-bottom: 32px;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

.stat-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 24px;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    text-align: center;
    border: 1px solid var(--gray-200);
}

.stat-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-4px);
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-red);
    margin-bottom: 8px;
    line-height: 1.2;
}

.stat-label {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--gray-600);
    margin: 0;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.25rem;
}

.stat-icon.links { background: rgba(220, 62, 55, 0.1); color: var(--primary-red); }
.stat-icon.clicks { background: rgba(23, 162, 184, 0.1); color: var(--info); }
.stat-icon.conversions { background: rgba(40, 167, 69, 0.1); color: var(--success); }
.stat-icon.commission { background: rgba(255, 193, 7, 0.1); color: var(--warning); }

/* Navigation Pills */
.nav-pills-container {
    margin-bottom: 32px;
}

.nav-custom {
    display: flex;
    gap: 8px;
    padding: 0;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: 8px;
    border: 1px solid var(--gray-200);
}

.nav-custom .nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    color: var(--gray-600);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    flex: 1;
    justify-content: center;
    border: none;
    background: transparent;
}

.nav-custom .nav-link:hover {
    color: var(--primary-red);
    background: rgba(220, 62, 55, 0.05);
}

.nav-custom .nav-link.active {
    background: var(--primary-red);
    color: white;
    box-shadow: var(--shadow-sm);
}

.nav-custom .nav-link i {
    font-size: 1rem;
}

/* Quick Actions Card */
.quick-actions-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    margin-bottom: 32px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.quick-actions-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid var(--gray-200);
    background: var(--light-bg);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark-text);
    margin: 0;
}

.affiliate-code-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--success);
    color: white;
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-label {
    opacity: 0.9;
}

.badge-value {
    font-weight: 600;
}

.card-content {
    padding: 24px;
}

/* Action Buttons */
.action-buttons {
    display: grid;
    gap: 16px;
    margin-bottom: 24px;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}

.btn-action {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-sm);
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    text-decoration: none;
}

.btn-action.btn-primary {
    background: var(--primary-red);
    color: white;
}

.btn-action.btn-primary:hover {
    background: var(--secondary-orange);
    color: white;
}

.btn-action.btn-secondary {
    background: var(--gray-100);
    color: var(--dark-text);
    border: 1px solid var(--gray-300);
}

.btn-action.btn-secondary:hover {
    background: var(--gray-200);
    border-color: var(--primary-red);
    color: var(--primary-red);
}

.btn-action.btn-info {
    background: var(--info);
    color: white;
}

.btn-action.btn-success {
    background: var(--success);
    color: white;
}

.btn-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    font-size: 0.85rem;
}

.btn-text {
    flex: 1;
}

/* Affiliate Info */
.affiliate-info {
    background: var(--light-bg);
    border-radius: var(--radius-md);
    padding: 20px;
}

.info-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-text);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-title i {
    color: var(--info);
}

.info-grid {
    display: grid;
    gap: 12px;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
}

.info-label {
    font-size: 0.9rem;
    color: var(--gray-600);
    font-weight: 500;
}

.info-value {
    font-size: 0.9rem;
    color: var(--dark-text);
    font-weight: 600;
}

/* Content Tabs */
.content-tabs {
    margin-bottom: 32px;
}

.tab-nav {
    display: flex;
    gap: 4px;
    background: white;
    border-radius: var(--radius-lg);
    padding: 4px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    margin-bottom: 20px;
}

.tab-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    border: none;
    background: transparent;
    border-radius: var(--radius-md);
    color: var(--gray-600);
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.tab-btn:hover {
    color: var(--primary-red);
    background: rgba(220, 62, 55, 0.05);
}

.tab-btn.active {
    background: var(--primary-red);
    color: white;
    box-shadow: var(--shadow-sm);
}

.tab-btn i {
    font-size: 1rem;
}

/* Tab Content */
.tab-content-container {
    position: relative;
}

.tab-panel {
    display: none;
}

.tab-panel.active {
    display: block;
}

/* Data Cards */
.data-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

/* Tables */
.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.data-table th {
    background: var(--light-bg);
    color: var(--dark-text);
    font-weight: 600;
    padding: 16px 12px;
    text-align: left;
    border-bottom: 1px solid var(--gray-200);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.data-table td {
    padding: 16px 12px;
    border-bottom: 1px solid var(--gray-100);
    vertical-align: middle;
}

.data-table tr:hover {
    background: var(--gray-100);
}

/* Table Cell Styles */
.product-cell {
    max-width: 200px;
}

.product-link {
    color: var(--dark-text);
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color 0.2s ease;
}

.product-link:hover {
    color: var(--primary-red);
    text-decoration: none;
}

.product-link i {
    font-size: 0.75rem;
    opacity: 0.6;
}

.link-code {
    background: var(--gray-100);
    color: var(--dark-text);
    padding: 4px 8px;
    border-radius: var(--radius-sm);
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
    font-weight: 600;
}

.metric-value {
    font-weight: 600;
    color: var(--dark-text);
}

.conversion-rate {
    font-weight: 600;
    color: var(--success);
}

.order-number {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: var(--primary-red);
}

.product-name {
    font-weight: 500;
    color: var(--dark-text);
}

.amount-value, .commission-amount {
    font-weight: 600;
    color: var(--primary-red);
}

.rate-value {
    font-weight: 600;
    color: var(--info);
}

.date-value {
    color: var(--gray-600);
    font-size: 0.85rem;
}

/* Status Badges */
.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.status-badge.inactive {
    background: rgba(108, 117, 125, 0.1);
    color: var(--gray-600);
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
}

.status-badge.approved {
    background: rgba(23, 162, 184, 0.1);
    color: var(--info);
}

.status-badge.paid {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.status-badge.cancelled {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* Action Button in Table */
.action-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: 1px solid var(--gray-300);
    background: white;
    color: var(--dark-text);
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.action-btn:hover {
    border-color: var(--primary-red);
    color: var(--primary-red);
    background: rgba(220, 62, 55, 0.05);
}

.action-btn i {
    font-size: 0.75rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 24px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: var(--light-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: var(--gray-500);
    font-size: 2rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark-text);
    margin-bottom: 8px;
}

.empty-text {
    color: var(--gray-600);
    font-size: 0.9rem;
    margin-bottom: 24px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Pagination */
.pagination-container {
    padding: 20px 24px;
    border-top: 1px solid var(--gray-200);
    background: var(--gray-100);
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .nav-custom {
        flex-direction: column;
        gap: 4px;
    }
    
    .tab-nav {
        flex-direction: column;
        gap: 4px;
    }
    
    .data-table {
        font-size: 0.8rem;
    }
    
    .data-table th,
    .data-table td {
        padding: 12px 8px;
    }
}
</style>
@endpush

@section('content')
<div class="affiliate-dashboard">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Dashboard Cộng Tác Viên</h1>
            <p class="page-subtitle">Quản lý liên kết affiliate và theo dõi hiệu suất của bạn</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon links">
                    <i class="fa fa-link fas fa-link"></i>
                </div>
                <div class="stat-value">{{ $stats['total_links'] }}</div>
                <p class="stat-label">Tổng Link Affiliate</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon clicks">
                    <i class="fa fa-mouse-pointer fas fa-mouse-pointer"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['total_clicks']) }}</div>
                <p class="stat-label">Lượt Click</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon conversions">
                    <i class="fa fa-shopping-cart fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['total_conversions']) }}</div>
                <p class="stat-label">Chuyển Đổi Thành Công</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon commission">
                    <i class="fa fa-coins fas fa-coins"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['pending_commission']) }}₫</div>
                <p class="stat-label">Hoa Hồng Chờ Duyệt</p>
            </div>
        </div>

        <!-- Navigation Pills -->
        <div class="nav-pills-container">
            <nav class="nav nav-pills nav-custom">
                <a class="nav-link active" href="{{ route('affiliate.dashboard') }}">
                    <i class="fa fa-tachometer-alt fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a class="nav-link" href="{{ route('affiliate.products') }}">
                    <i class="fa fa-shopping-bag fas fa-shopping-bag"></i>
                    <span>Tạo Link SP</span>
                </a>
                <a class="nav-link" href="{{ route('affiliate.guide') }}">
                    <i class="fa fa-book fas fa-book"></i>
                    <span>Hướng Dẫn</span>
                </a>
                <a class="nav-link" href="{{ route('collaborator.status') }}">
                    <i class="fa fa-user fas fa-user"></i>
                    <span>Thông Tin CTV</span>
                </a>
            </nav>
        </div>

        <!-- Quick Actions Card -->
        <div class="quick-actions-card">
            <div class="card-header">
                <h3 class="card-title">Thao Tác Nhanh</h3>
                <div class="affiliate-code-badge">
                    <span class="badge-label">Mã CTV:</span>
                    <span class="badge-value">{{ Auth::user()->affiliate_code }}</span>
                </div>
            </div>
            
            <div class="card-content">
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('affiliate.products') }}" class="btn-action btn-primary">
                        <div class="btn-icon">
                            <i class="fa fa-plus fas fa-plus"></i>
                        </div>
                        <span class="btn-text">Tạo Link Mới</span>
                    </a>
                    <button class="btn-action btn-secondary" onclick="copyAffiliateCode()">
                        <div class="btn-icon">
                            <i class="fa fa-copy fas fa-copy"></i>
                        </div>
                        <span class="btn-text">Copy Mã CTV</span>
                    </button>
                    <a href="{{ route('affiliate.guide') }}" class="btn-action btn-info">
                        <div class="btn-icon">
                            <i class="fa fa-book fas fa-book"></i>
                        </div>
                        <span class="btn-text">Xem Hướng Dẫn</span>
                    </a>
                    <button class="btn-action btn-success" onclick="showQuickShare()">
                        <div class="btn-icon">
                            <i class="fa fa-share-alt fas fa-share-alt"></i>
                        </div>
                        <span class="btn-text">Share Nhanh</span>
                    </button>
                </div>
                
                <!-- Affiliate Info -->
                <div class="affiliate-info">
                    <h4 class="info-title">
                        <i class="fa fa-info-circle fas fa-info-circle"></i>
                        Thông Tin Của Bạn
                    </h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Mã CTV:</span>
                            <span class="info-value">{{ Auth::user()->affiliate_code }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tỷ lệ hoa hồng:</span>
                            <span class="info-value">{{ Auth::user()->commission_rate }}%</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tổng link:</span>
                            <span class="info-value">{{ $stats['total_links'] }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Hoa hồng chờ:</span>
                            <span class="info-value">{{ number_format($stats['pending_commission']) }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="content-tabs">
            <div class="tab-nav">
                <button class="tab-btn active" data-tab="links">
                    <i class="fa fa-link fas fa-link"></i>
                    <span>Links Affiliate</span>
                </button>
                <button class="tab-btn" data-tab="commissions">
                    <i class="fa fa-coins fas fa-coins"></i>
                    <span>Hoa Hồng</span>
                </button>
            </div>

            <div class="tab-content-container">
                <!-- Affiliate Links Tab -->
                <div class="tab-panel active" id="links">
                    <div class="data-card">
                        @if($affiliateLinks->count() > 0)
                            <div class="table-container">
                                <table class="data-table">
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
                                                <div class="product-cell">
                                                    <a href="{{ route('product.show', $link->product->id) }}" target="_blank" class="product-link">
                                                        {{ $link->product->name }}
                                                        <i class="fa fa-external-link-alt fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <code class="link-code">{{ $link->link_code }}</code>
                                            </td>
                                            <td>
                                                <span class="metric-value">{{ number_format($link->clicks) }}</span>
                                            </td>
                                            <td>
                                                <span class="metric-value">{{ number_format($link->conversions) }}</span>
                                            </td>
                                            <td>
                                                <span class="conversion-rate">{{ $link->conversion_rate }}%</span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $link->is_active ? 'active' : 'inactive' }}">
                                                    {{ $link->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="action-btn" onclick="copyLink('{{ $link->affiliate_url }}')">
                                                    <i class="fa fa-copy fas fa-copy"></i>
                                                    <span>Copy Link</span>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-container">
                                {{ $affiliateLinks->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa fa-link fas fa-link"></i>
                                </div>
                                <h4 class="empty-title">Chưa có link affiliate nào</h4>
                                <p class="empty-text">Tạo link affiliate đầu tiên để bắt đầu kiếm hoa hồng</p>
                                <a href="{{ route('affiliate.products') }}" class="btn-action btn-primary">
                                    <div class="btn-icon">
                                        <i class="fa fa-plus fas fa-plus"></i>
                                    </div>
                                    <span class="btn-text">Tạo Link Đầu Tiên</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Commissions Tab -->
                <div class="tab-panel" id="commissions">
                    <div class="data-card">
                        @if($commissions->count() > 0)
                            <div class="table-container">
                                <table class="data-table">
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
                                            <td>
                                                <span class="order-number">#{{ $commission->order->number ?? $commission->order_id }}</span>
                                            </td>
                                            <td>
                                                <span class="product-name">{{ $commission->product->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="amount-value">{{ number_format($commission->order_amount) }}₫</span>
                                            </td>
                                            <td>
                                                <span class="rate-value">{{ $commission->commission_rate }}%</span>
                                            </td>
                                            <td>
                                                <span class="commission-amount">{{ number_format($commission->commission_amount) }}₫</span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $commission->status }}">
                                                    {{ $commission->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="date-value">{{ $commission->created_at->format('d/m/Y') }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-container">
                                {{ $commissions->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa fa-coins fas fa-coins"></i>
                                </div>
                                <h4 class="empty-title">Chưa có hoa hồng nào</h4>
                                <p class="empty-text">Hoa hồng sẽ xuất hiện khi có khách hàng mua hàng qua link của bạn</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all buttons and panels
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanels.forEach(panel => panel.classList.remove('active'));
            
            // Add active class to clicked button and corresponding panel
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
});

function copyLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        showNotification('Đã copy link thành công!', 'success');
    }).catch(() => {
        showNotification('Không thể copy link. Vui lòng thử lại.', 'error');
    });
}

function copyAffiliateCode() {
    navigator.clipboard.writeText('{{ Auth::user()->affiliate_code }}').then(() => {
        showNotification('Đã copy mã CTV thành công!', 'success');
    }).catch(() => {
        showNotification('Không thể copy mã CTV. Vui lòng thử lại.', 'error');
    });
}

function showQuickShare() {
    const myCode = '{{ Auth::user()->affiliate_code }}';
    const siteUrl = '{{ url("/") }}';
    const shareText = `🎉 Mình là Cộng tác viên của ${siteUrl}
💎 Mã CTV: ${myCode}
🛍️ Shop ngay và nhận ưu đãi tốt nhất!
📱 Liên hệ mình để được tư vấn sản phẩm phù hợp nhé!`;
    
    // Create quick share modal with custom styling
    const modal = `
        <div class="modal fade" id="quickShareModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 8px 16px rgba(50, 42, 42, 0.12);">
                    <div class="modal-header" style="background: var(--light-bg); border-bottom: 1px solid var(--gray-200); border-radius: 12px 12px 0 0;">
                        <h5 class="modal-title" style="color: var(--dark-text); font-weight: 600;">
                            <i class="fa fa-share-alt fas fa-share-alt" style="color: var(--primary-red); margin-right: 8px;"></i>
                            Share Thông Tin CTV
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 24px;">
                        <textarea class="form-control mb-3" rows="6" id="shareText" style="border-radius: 8px; border: 1px solid var(--gray-300); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">${shareText}</textarea>
                        <div class="d-grid gap-2">
                            <button class="btn-action btn-primary" onclick="copyText('shareText')" style="justify-content: center;">
                                <div class="btn-icon">
                                    <i class="fa fa-copy fas fa-copy"></i>
                                </div>
                                <span class="btn-text">Copy Text</span>
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
    
    // Use Bootstrap 5 modal
    const bootstrapModal = new bootstrap.Modal(document.getElementById('quickShareModal'));
    bootstrapModal.show();
}

function copyText(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    navigator.clipboard.writeText(element.value).then(() => {
        showNotification('Đã copy thành công!', 'success');
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('quickShareModal'));
        if (modal) modal.hide();
    }).catch(() => {
        showNotification('Không thể copy text. Vui lòng thử lại.', 'error');
    });
}

// Custom notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existing = document.querySelectorAll('.custom-notification');
    existing.forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    notification.className = `custom-notification ${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        font-size: 0.9rem;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    // Set background color based on type
    const colors = {
        success: '#28A745',
        error: '#DC3545',
        info: '#17A2B8',
        warning: '#FFC107'
    };
    notification.style.background = colors[type] || colors.info;
    
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animation for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection