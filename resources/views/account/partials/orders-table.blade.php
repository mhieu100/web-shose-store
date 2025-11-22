<div id="orders-table-container">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th><i class="fas fa-hashtag me-2"></i>Đơn Hàng</th>
                    <th><i class="fas fa-calendar-alt me-2"></i>Ngày Đặt</th>
                    <th><i class="fas fa-info-circle me-2"></i>Trạng Thái</th>
                    <th><i class="fas fa-money-bill-wave me-2"></i>Tổng Tiền</th>
                    <th><i class="fas fa-cog me-2"></i>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong class="text-primary">#{{ $order->order_number ?? 'ORD-' . $order->created_at->format('Ymd') . '-' . strtoupper(substr(md5($order->id), 0, 6)) }}</strong>
                        </td>
                        <td>
                            <div>{{ $order->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            @php
                                $statusLabel = $order->status->getLabel();
                                $badgeClass = 'bg-secondary';

                                if (stripos($statusLabel, 'hoàn thành') !== false || stripos($statusLabel, 'delivered') !== false) {
                                    $badgeClass = 'bg-success';
                                } elseif (stripos($statusLabel, 'đang') !== false || stripos($statusLabel, 'processing') !== false) {
                                    $badgeClass = 'bg-warning';
                                } elseif (stripos($statusLabel, 'hủy') !== false || stripos($statusLabel, 'cancel') !== false) {
                                    $badgeClass = 'bg-danger';
                                } elseif (stripos($statusLabel, 'mới') !== false || stripos($statusLabel, 'new') !== false) {
                                    $badgeClass = 'bg-info';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            <strong class="text-success">{{ number_format($order->total_price, 0, ',', '.') }}₫</strong>
                        </td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('account.order.show', $order->id) }}" class="btn btn-sm btn-primary" title="Xem chi tiết">
                                    <i class="fas fa-eye me-1"></i>Xem
                                </a>
                                @if ($order->canBeCancelled())
                                    <form method="POST" action="{{ route('account.order.cancel', $order->id) }}" class="cancel-order-form d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hủy đơn hàng">
                                            <i class="fas fa-ban me-1"></i>Hủy
                                        </button>
                                    </form>
                                @endif
                                @if ($order->canBeConfirmedAsDelivered())
                                    <form method="POST" action="{{ route('account.order.confirm-delivery', $order->id) }}" class="confirm-delivery-form d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Xác nhận đã nhận hàng">
                                            <i class="fas fa-check-double me-1"></i>Đã nhận
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                                <h5>Chưa có đơn hàng nào</h5>
                                <p>Bạn chưa thực hiện đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
                                <a href="{{ route('shop') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-shopping-cart me-1"></i>Mua sắm ngay
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (isset($orders) && $orders->hasPages())
        <!-- Bootstrap Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Hiển thị <strong>{{ $orders->firstItem() ?? 0 }}</strong> - <strong>{{ $orders->lastItem() ?? 0 }}</strong> trong tổng số <strong>{{ $orders->total() }}</strong> đơn hàng
            </div>
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Button --}}
                    @if ($orders->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Trước</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button class="page-link pagination-link" data-page="{{ $orders->currentPage() - 1 }}">Trước</button>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach (range(1, min(5, $orders->lastPage())) as $page)
                        @if ($page == $orders->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button class="page-link pagination-link" data-page="{{ $page }}">{{ $page }}</button>
                            </li>
                        @endif
                    @endforeach

                    @if ($orders->lastPage() > 5)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <button class="page-link pagination-link" data-page="{{ $orders->lastPage() }}">{{ $orders->lastPage() }}</button>
                        </li>
                    @endif

                    {{-- Next Button --}}
                    @if ($orders->hasMorePages())
                        <li class="page-item">
                            <button class="page-link pagination-link" data-page="{{ $orders->currentPage() + 1 }}">Tiếp</button>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Tiếp</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>
