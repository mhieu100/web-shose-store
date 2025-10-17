<!-- Pagination Partial -->
<div class="pagination-info">
    <div class="pagination-summary">
        <span class="showing-text">Hiển thị</span>
        <strong>{{ $products->firstItem() ?? 0 }}</strong>
        <span>đến</span>
        <strong>{{ $products->lastItem() ?? 0 }}</strong>
        <span>trong tổng số</span>
        <strong>{{ $products->total() }}</strong>
        <span>sản phẩm</span>
        @if (request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
            <span class="filtered-text">(đã lọc)</span>
        @endif
    </div>

    <div class="per-page-selector">
        <label for="per-page">Hiển thị:</label>
        <select id="per-page" class="form-select per-page-select" onchange="changePerPage(this.value)">
            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 sản phẩm</option>
            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 sản phẩm</option>
            <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36 sản phẩm</option>
            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 sản phẩm</option>
        </select>
    </div>
</div>

<div class="pagination-area">
    <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <div class="pagination-container">
            @if ($products->onFirstPage())
                <span class="page-link disabled first-last-btn">
                    <i class="fa fa-angle-double-left"></i>
                    <span class="btn-text">Đầu</span>
                </span>
                <span class="page-link disabled">
                    <i class="fa fa-angle-left"></i>
                    <span class="btn-text">Trước</span>
                </span>
            @else
                <a href="{{ $products->url(1) }}" class="page-link first-last-btn">
                    <i class="fa fa-angle-double-left"></i>
                    <span class="btn-text">Đầu</span>
                </a>
                <a href="{{ $products->previousPageUrl() }}" class="page-link">
                    <i class="fa fa-angle-left"></i>
                    <span class="btn-text">Trước</span>
                </a>
            @endif

            <div class="page-numbers">
                @php
                    $start = max(1, $products->currentPage() - 2);
                    $end = min($products->lastPage(), $products->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <a href="{{ $products->url(1) }}" class="page-link">1</a>
                    @if ($start > 2)
                        <span class="page-link dots">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $products->currentPage())
                        <span class="page-link active">{{ $i }}</span>
                    @else
                        <a href="{{ $products->url($i) }}" class="page-link">{{ $i }}</a>
                    @endif
                @endfor

                @if ($end < $products->lastPage())
                    @if ($end < $products->lastPage() - 1)
                        <span class="page-link dots">...</span>
                    @endif
                    <a href="{{ $products->url($products->lastPage()) }}" class="page-link">{{ $products->lastPage() }}</a>
                @endif
            </div>

            @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="page-link">
                    <span class="btn-text">Tiếp</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="{{ $products->url($products->lastPage()) }}" class="page-link first-last-btn">
                    <span class="btn-text">Cuối</span>
                    <i class="fa fa-angle-double-right"></i>
                </a>
            @else
                <span class="page-link disabled">
                    <span class="btn-text">Tiếp</span>
                    <i class="fa fa-angle-right"></i>
                </span>
                <span class="page-link disabled first-last-btn">
                    <span class="btn-text">Cuối</span>
                    <i class="fa fa-angle-double-right"></i>
                </span>
            @endif
        </div>
    </nav>
</div>

<div class="pagination-jump">
    <div class="jump-to-page">
        <label for="jump-page">Đi đến trang:</label>
        <input type="number" id="jump-page" class="form-control jump-input"
               min="1" max="{{ $products->lastPage() }}"
               placeholder="{{ $products->currentPage() }}">
        <button type="button" class="btn btn-primary jump-btn" onclick="jumpToPage()">
            <i class="fa fa-arrow-right"></i>
        </button>
    </div>
</div>