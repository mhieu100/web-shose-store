@extends('layouts.frontend')

@section('title', 'Hướng Dẫn Sử Dụng CTV')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">🎯 Hướng Dẫn Sử Dụng Hệ Thống Cộng Tác Viên</h2>
            
            <!-- Quick Start Guide -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fa fa-rocket"></i> Bắt Đầu Nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="fa fa-user-plus fa-2x text-primary mb-2"></i>
                                <h6>1. Đăng Ký</h6>
                                <p class="small">Đăng ký làm CTV và chờ admin duyệt</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="fa fa-link fa-2x text-success mb-2"></i>
                                <h6>2. Tạo Link</h6>
                                <p class="small">Chọn sản phẩm và tạo link affiliate</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="fa fa-share-alt fa-2x text-info mb-2"></i>
                                <h6>3. Chia Sẻ</h6>
                                <p class="small">Share link cho bạn bè, khách hàng</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="fa fa-money fa-2x text-warning mb-2"></i>
                                <h6>4. Nhận Hoa Hồng</h6>
                                <p class="small">Kiếm hoa hồng {{ Auth::user()->commission_rate ?? 5 }}% khi có người mua</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Instructions -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fa fa-tachometer"></i> Dashboard CTV</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Tại đây bạn có thể:</strong></p>
                            <ul>
                                <li>📊 Xem thống kê tổng quan (clicks, conversions, hoa hồng)</li>
                                <li>📝 Quản lý danh sách link affiliate</li>
                                <li>💰 Theo dõi hoa hồng (chờ duyệt, đã duyệt, đã trả)</li>
                                <li>📋 Copy mã CTV của bạn</li>
                            </ul>
                            <a href="{{ route('affiliate.dashboard') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-right"></i> Vào Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fa fa-shopping-bag"></i> Tạo Link Sản Phẩm</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Cách tạo link affiliate:</strong></p>
                            <ol>
                                <li>Vào trang "Chọn Sản Phẩm"</li>
                                <li>Tìm kiếm hoặc duyệt sản phẩm</li>
                                <li>Click "Tạo Link" hoặc "Copy Link"</li>
                                <li>Link sẽ có dạng: <code>domain.com/product/123?ref=CTV123456</code></li>
                            </ol>
                            <a href="{{ route('affiliate.products') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i> Tạo Link Ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sharing Tips -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fa fa-lightbulb-o"></i> Mẹo Chia Sẻ Hiệu Quả</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6><i class="fab fa-facebook text-primary"></i> Facebook</h6>
                            <ul class="small">
                                <li>Đăng trong group có nhiều thành viên</li>
                                <li>Kèm ảnh sản phẩm và mô tả chi tiết</li>
                                <li>Tag bạn bè quan tâm</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6><i class="fab fa-zalo text-info"></i> Zalo</h6>
                            <ul class="small">
                                <li>Gửi trong nhóm gia đình, bạn bè</li>
                                <li>Nhắn tin cá nhân cho khách hàng tiềm năng</li>
                                <li>Chia sẻ story Zalo</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6><i class="fa fa-users text-success"></i> Offline</h6>
                            <ul class="small">
                                <li>Giới thiệu trực tiếp cho khách hàng</li>
                                <li>In card có QR code link affiliate</li>
                                <li>Tặng kèm mã giảm giá</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commission Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fa fa-info-circle"></i> Về Hoa Hồng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>📈 Tỷ Lệ Hoa Hồng</h6>
                            <p>Bạn nhận <strong>{{ Auth::user()->commission_rate ?? 5 }}%</strong> trên tổng giá trị đơn hàng (sau khi trừ phí ship)</p>
                            
                            <h6>⏱️ Thời Gian Thanh Toán</h6>
                            <ul class="small">
                                <li><span class="badge bg-warning">Chờ duyệt:</span> Sau khi khách đặt hàng</li>
                                <li><span class="badge bg-success">Đã duyệt:</span> Admin duyệt (1-3 ngày)</li>
                                <li><span class="badge bg-info">Đã trả:</span> Chuyển tiền (cuối tháng)</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>💡 Lưu Ý Quan Trọng</h6>
                            <ul class="small">
                                <li>Chỉ nhận hoa hồng từ khách hàng mới</li>
                                <li>Đơn hàng phải hoàn thành mới được tính</li>
                                <li>Không được tự mua để tạo hoa hồng</li>
                                <li>Hoa hồng có thể bị hủy nếu khách trả hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-headphones"></i> Hỗ Trợ</h5>
                </div>
                <div class="card-body">
                    <p>Cần hỗ trợ? Liên hệ với chúng tôi:</p>
                    <div class="row">
                        <div class="col-md-4">
                            <i class="fa fa-phone text-success"></i> 
                            <strong>Hotline:</strong> 0123.456.789
                        </div>
                        <div class="col-md-4">
                            <i class="fa fa-envelope text-primary"></i> 
                            <strong>Email:</strong> support@domain.com
                        </div>
                        <div class="col-md-4">
                            <i class="fab fa-facebook-messenger text-info"></i> 
                            <strong>Messenger:</strong> m.me/fanpage
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection