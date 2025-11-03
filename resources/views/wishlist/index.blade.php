@extends('layouts.frontend')

@section('title', 'Wishlist')

@section('content')
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
        ['label' => 'Danh sách yêu thích', 'icon' => 'heart', 'active' => true]
    ]" />

    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Danh Sách Yêu Thích</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Wishlist Area ==-->
    <section class="shopping-cart-area">
        <div class="container">
            @if(count($wishlistItems) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="shopping-cart-form table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumb">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-stock-status">Stock Status</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlistItems as $item)
                                        <tr class="cart-product-item wishlist-item" data-product-id="{{ $item->product->id }}">
                                            <td class="product-remove">
                                                <button type="button" class="remove-from-wishlist" data-product-id="{{ $item->product->id }}" style="border: none; background: none; cursor: pointer; color: #666; font-size: 18px; transition: color 0.3s;">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                            <td class="product-thumb">
                                                <a href="{{ route('product.show', $item->product->id) }}">
                                                    @if($item->product->getFirstMediaUrl('product-images'))
                                                        <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}" width="90" height="110" alt="{{ $item->product->name }}">
                                                    @else
                                                        <img src="{{ asset('img/shop/placeholder.webp') }}" width="90" height="110" alt="{{ $item->product->name }}">
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <h4 class="title">
                                                    <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                </h4>
                                            </td>
                                            <td class="product-stock-status">
                                                @if($item->product->qty > 0)
                                                    <span class="badge-stock in-stock">In Stock</span>
                                                @else
                                                    <span class="badge-stock out-of-stock">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td class="product-price">
                                                <span class="price">${{ number_format($item->product->sale_price ?? $item->product->price, 2) }}</span>
                                            </td>
                                            <td class="product-action">
                                                @if($item->product->qty > 0)
                                                    <button class="btn-theme btn-flat add-to-cart"
                                                            data-product-id="{{ $item->product->id }}"
                                                            data-product-name="{{ $item->product->name }}"
                                                            data-product-price="{{ $item->product->sale_price ?? $item->product->price }}"
                                                            data-product-colors='{!! $item->product->colors ? json_encode($item->product->colors) : "[]" !!}'
                                                            data-product-sizes='{!! $item->product->sizes ? json_encode($item->product->sizes) : "[]" !!}'
                                                            title="Add to Cart">
                                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                                    </button>
                                                @else
                                                    <button class="btn-theme btn-flat" disabled style="opacity: 0.5; cursor: not-allowed;">
                                                        <i class="fa fa-times"></i> Out of Stock
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="actions">
                                        <td class="border-0" colspan="6">
                                            <button type="button" class="clear-cart" data-bs-toggle="modal" data-bs-target="#clearWishlistModal">
                                                Clear Wishlist
                                            </button>
                                            <a href="{{ route('shop') }}" class="btn-theme btn-flat">Continue Shopping</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="cart-empty text-center py-5">
                            <h2>Your wishlist is currently empty</h2>
                            <p>You haven't added any products to your wishlist yet.</p>
                            <a href="{{ route('shop') }}" class="btn-theme btn-flat">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--== End Wishlist Area ==-->

    <!-- Clear Wishlist Confirmation Modal -->
    <div class="modal fade" id="clearWishlistModal" tabindex="-1" aria-labelledby="clearWishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clearWishlistModalLabel">
                        <i class="fa fa-exclamation-triangle text-warning me-2"></i>
                        Clear Wishlist
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-heart-o" style="font-size: 48px; color: #dc3545; margin-bottom: 20px;"></i>
                        <h4>Are you sure?</h4>
                        <p class="text-muted">This will remove all items from your wishlist. This action cannot be undone.</p>
                        <div class="mt-3">
                            <span class="fw-bold">Items to be removed: </span>
                            <span class="badge bg-primary fs-6" id="wishlistItemCount">{{ count($wishlistItems) }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmClearWishlist">
                        <i class="fa fa-trash me-1"></i> <span class="btn-text">Clear Wishlist</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Product Options Modal -->
    @include('components.product-options-modal')
@endsection

@push('styles')
<style>
    /* Stock badge styling */
    .badge-stock {
        padding: 5px 15px;
        border-radius: 3px;
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-stock.in-stock {
        background-color: #28a745;
        color: white;
    }

    .badge-stock.out-of-stock {
        background-color: #dc3545;
        color: white;
    }

    /* Action button styling */
    .product-action .btn-theme {
        white-space: nowrap;
        padding: 10px 20px;
        font-size: 14px;
    }

    .product-action .btn-theme i {
        margin-right: 5px;
    }

    /* Remove icon styling to match cart */
    .product-remove button {
        color: #666;
        font-size: 18px;
        transition: color 0.3s;
    }

    .product-remove button:hover {
        color: #dc3545;
    }

    .product-remove button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Empty state styling */
    .cart-empty {
        min-height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .cart-empty h2 {
        margin-bottom: 15px;
        color: #333;
    }

    .cart-empty p {
        margin-bottom: 25px;
        color: #666;
        font-size: 16px;
    }

    /* Actions row styling */
    .actions {
        border-top: 1px solid #ebebeb;
        padding-top: 20px !important;
    }

    .clear-cart {
        display: inline-block;
        padding: 10px 25px;
        background-color: #dc3545;
        color: white;
        border-radius: 3px;
        border: none;
        margin-right: 10px;
        transition: all 0.3s;
        cursor: pointer;
    }

    .clear-cart:hover {
        background-color: #c82333;
        color: white;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-radius: 10px 10px 0 0;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-radius: 0 0 10px 10px;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body h4 {
        color: #333;
        margin-bottom: 15px;
    }

    .modal-body p {
        font-size: 16px;
        line-height: 1.5;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        transition: all 0.3s;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-1px);
    }

    .btn-secondary {
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        transform: translateY(-1px);
    }

    /* Loading state for button */
    .btn-loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .btn-loading .btn-text {
        opacity: 0;
    }

    .btn-loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/wishlist.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/product-options.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Individual item removal functionality
    document.querySelectorAll('.remove-from-wishlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            removeFromWishlist(productId, this);
        });
    });

    // Clear wishlist modal functionality
    const confirmClearBtn = document.getElementById('confirmClearWishlist');
    const clearWishlistModal = document.getElementById('clearWishlistModal');

    if (confirmClearBtn) {
        confirmClearBtn.addEventListener('click', function() {
            clearWishlist();
        });
    }

    function removeFromWishlist(productId, button) {


        // Show loading state
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        button.disabled = true;

        fetch('{{ route("wishlist.remove") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the table row with animation
                const row = button.closest('tr');
                row.style.transition = 'opacity 0.3s ease';
                row.style.opacity = '0';

                setTimeout(() => {
                    row.remove();

                    // Update wishlist count in header/sidebar if exists
                    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                    wishlistCountElements.forEach(element => {
                        element.textContent = data.wishlist_count;
                    });

                    // Update item count in modal
                    const itemCountElement = document.getElementById('wishlistItemCount');
                    if (itemCountElement) {
                        itemCountElement.textContent = data.wishlist_count;
                    }

                    // Check if wishlist is empty and show empty state
                    if (data.wishlist_count === 0) {
                        updateWishlistContent();
                    }

                    // Show success message
                    showSuccess(data.message);
                }, 300);

            } else {
                showError(data.message);
                // Restore button state
                button.innerHTML = originalIcon;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại.');
            // Restore button state
            button.innerHTML = originalIcon;
            button.disabled = false;
        });
    }

    function clearWishlist() {
        const button = document.getElementById('confirmClearWishlist');
        const buttonText = button.querySelector('.btn-text');

        // Show loading state
        button.classList.add('btn-loading');
        button.disabled = true;

        fetch('{{ route("wishlist.clear") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide modal
                const modal = bootstrap.Modal.getInstance(clearWishlistModal);
                modal.hide();

                // Show success message
                showSuccess(data.message);

                // Wait for modal to close, then update the page content
                clearWishlistModal.addEventListener('hidden.bs.modal', function() {
                    updateWishlistContent();
                }, { once: true });

                // Update wishlist count in header/sidebar if exists
                const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                wishlistCountElements.forEach(element => {
                    element.textContent = '0';
                });

            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Có lỗi xảy ra khi xóa danh sách yêu thích. Vui lòng thử lại.');
        })
        .finally(() => {
            // Remove loading state
            button.classList.remove('btn-loading');
            button.disabled = false;
        });
    }

    function updateWishlistContent() {
        // Replace the entire wishlist content with empty state
        const wishlistContainer = document.querySelector('.shopping-cart-area .container');
        if (wishlistContainer) {
            wishlistContainer.innerHTML = `
                <div class="row">
                    <div class="col-12">
                        <div class="cart-empty text-center py-5">
                            <h2>Your wishlist is currently empty</h2>
                            <p>You haven't added any products to your wishlist yet.</p>
                            <a href="{{ route('shop') }}" class="btn-theme btn-flat">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // Toast messages are now handled by the global toast system
});
</script>
@endpush
