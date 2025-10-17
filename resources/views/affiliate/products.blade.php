@extends('layouts.frontend')

@section('title', 'Chọn Sản Phẩm Affiliate')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Navigation Pills -->
            <ul class="nav nav-pills nav-fill mb-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('affiliate.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('affiliate.products') }}">
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>🛍️ Chọn Sản Phẩm Tạo Link Affiliate</h2>
                <div class="text-muted">
                    <i class="fas fa-percentage"></i> Hoa hồng: {{ Auth::user()->commission_rate }}%
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('affiliate.products') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-control">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach(\App\Models\Shop\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Tìm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($product->getFirstMediaUrl('product-images'))
                                <img src="{{ $product->getFirstMediaUrl('product-images') }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <span class="text-muted">Không có ảnh</span>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="text-muted small mb-2">{{ $product->brand->name ?? 'N/A' }}</p>
                                <p class="card-text text-success fw-bold">{{ number_format($product->price) }}đ</p>
                                
                                @if(isset($existingLinks[$product->id]))
                                    <div class="mt-auto">
                                        <p class="text-success small mb-2">
                                            <i class="fas fa-check"></i> Đã có link affiliate
                                        </p>
                                        <div class="btn-group w-100">
                                            <button class="btn btn-outline-primary btn-sm" onclick="copyExistingLink({{ $product->id }})">
                                                Copy Link
                                            </button>
                                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                                Xem SP
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-auto">
                                        <div class="btn-group w-100">
                                            <button class="btn btn-primary btn-sm" onclick="createAffiliateLink({{ $product->id }})">
                                                Tạo Link
                                            </button>
                                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                                Xem SP
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Đang tạo link...</p>
            </div>
        </div>
    </div>
</div>

<script>
const existingLinks = @json($existingLinks);

function createAffiliateLink(productId) {
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();

    fetch('{{ route("affiliate.create-link") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        loadingModal.hide();
        if (data.success) {
            navigator.clipboard.writeText(data.link).then(() => {
                alert('Tạo link thành công và đã copy vào clipboard!');
                location.reload();
            });
        } else {
            alert('Lỗi: ' + (data.error || 'Không thể tạo link'));
        }
    })
    .catch(error => {
        loadingModal.hide();
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi tạo link');
    });
}

function copyExistingLink(productId) {
    fetch(`/affiliate/get-link/${productId}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            navigator.clipboard.writeText(data.link).then(() => {
                alert('Đã copy link thành công!');
            });
        } else {
            alert('Lỗi: ' + (data.error || 'Không thể lấy link'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra');
    });
}
</script>
@endsection