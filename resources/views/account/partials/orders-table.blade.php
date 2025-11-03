<div id="orders-table-container">
    <div class="orders-table-wrapper">
        <table class="modern-orders-table">
            <thead>
                <tr>
                    <th>
                        <div class="th-content">
                            <i class="fas fa-hashtag"></i>
                            <span>Đơn Hàng</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-content">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Ngày Đặt</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-content">
                            <i class="fas fa-info-circle"></i>
                            <span>Trạng Thái</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-content">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Tổng Tiền</span>
                        </div>
                    </th>
                    <th>
                        <div class="th-content">
                            <i class="fas fa-cog"></i>
                            <span>Hành Động</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <div class="order-number">
                                <i class="fas fa-receipt"></i>
                                <span>#{{ $order->order_number ?? 'ORD-' . $order->created_at->format('Ymd') . '-' . strtoupper(substr(md5($order->id), 0, 6)) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="order-date">
                                <span class="date-main">{{ $order->created_at->format('d/m/Y') }}</span>
                                <span class="date-time">{{ $order->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusLabel = $order->status->getLabel();
                                $statusClass = 'status-default';
                                $statusIcon = 'fa-circle';

                                if (stripos($statusLabel, 'hoàn thành') !== false || stripos($statusLabel, 'delivered') !== false) {
                                    $statusClass = 'status-success';
                                    $statusIcon = 'fa-check-circle';
                                } elseif (stripos($statusLabel, 'đang') !== false || stripos($statusLabel, 'processing') !== false) {
                                    $statusClass = 'status-warning';
                                    $statusIcon = 'fa-clock';
                                } elseif (stripos($statusLabel, 'hủy') !== false || stripos($statusLabel, 'cancel') !== false) {
                                    $statusClass = 'status-danger';
                                    $statusIcon = 'fa-times-circle';
                                }
                            @endphp
                            <div class="order-status {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i>
                                <span>{{ $statusLabel }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="order-price">
                                <span class="price-amount">{{ number_format($order->total_price, 0, ',', '.') }}</span>
                                <span class="price-currency">₫</span>
                            </div>
                        </td>
                        <td>
                            <div class="order-actions">
                                <a href="{{ route('account.order.show', $order->id) }}" class="action-btn action-view" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                    <span>Xem</span>
                                </a>
                                @if ($order->canBeCancelled())
                                    <form method="POST" action="{{ route('account.order.cancel', $order->id) }}" class="cancel-order-form">
                                        @csrf
                                        <button type="submit" class="action-btn action-cancel" title="Hủy đơn hàng">
                                            <i class="fas fa-ban"></i>
                                            <span>Hủy</span>
                                        </button>
                                    </form>
                                @endif
                                @if ($order->canBeConfirmedAsDelivered())
                                    <form method="POST" action="{{ route('account.order.confirm-delivery', $order->id) }}" class="confirm-delivery-form">
                                        @csrf
                                        <button type="submit" class="action-btn action-confirm" title="Xác nhận đã nhận hàng">
                                            <i class="fas fa-check-double"></i>
                                            <span>Đã nhận</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-state">
                        <td colspan="5">
                            <div class="empty-orders">
                                <i class="fas fa-shopping-bag"></i>
                                <h4>Chưa có đơn hàng nào</h4>
                                <p>Bạn chưa thực hiện đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
                                <a href="{{ route('shop') }}" class="btn-shop-now">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Mua sắm ngay</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (isset($orders) && $orders->hasPages())
        <!-- Modern Pagination -->
        <div class="modern-pagination" id="orders-pagination">
            <div class="pagination-info">
                <i class="fas fa-info-circle"></i>
                <span>Hiển thị <strong>{{ $orders->firstItem() ?? 0 }}</strong> - <strong>{{ $orders->lastItem() ?? 0 }}</strong> trong tổng số <strong>{{ $orders->total() }}</strong> đơn hàng</span>
            </div>
            <div class="pagination-controls">
                <button
                    class="pagination-btn pagination-prev {{ $orders->onFirstPage() ? 'disabled' : '' }}"
                    data-page="{{ $orders->currentPage() - 1 }}"
                    {{ $orders->onFirstPage() ? 'disabled' : '' }}>
                    <i class="fas fa-chevron-left"></i>
                    <span>Trước</span>
                </button>

                <div class="pagination-numbers">
                    @foreach (range(1, min(5, $orders->lastPage())) as $page)
                        @if ($page == $orders->currentPage())
                            <button class="pagination-number active">{{ $page }}</button>
                        @else
                            <button class="pagination-number pagination-link" data-page="{{ $page }}">{{ $page }}</button>
                        @endif
                    @endforeach

                    @if ($orders->lastPage() > 5)
                        <span class="pagination-dots">...</span>
                        <button class="pagination-number pagination-link" data-page="{{ $orders->lastPage() }}">{{ $orders->lastPage() }}</button>
                    @endif
                </div>

                <button
                    class="pagination-btn pagination-next {{ !$orders->hasMorePages() ? 'disabled' : '' }}"
                    data-page="{{ $orders->currentPage() + 1 }}"
                    {{ !$orders->hasMorePages() ? 'disabled' : '' }}>
                    <span>Tiếp</span>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    @endif
</div>
