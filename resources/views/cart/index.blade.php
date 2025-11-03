@extends('layouts.frontend')

@section('title', 'Shopping Cart')

@section('content')
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
        ['label' => 'Giỏ hàng', 'icon' => 'shopping-cart', 'active' => true]
    ]" />

    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Giỏ Hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Shopping Cart Area ==-->
    <section class="shopping-cart-area">
        <div class="container">
            @if ($cartItems && $cartItems->count() > 0)
                <!-- Cart Actions Header -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-danger clear-cart-btn-top"
                                onclick="clearCart(event)">
                                <i class="fa fa-trash-o me-2"></i>
                                Xóa giỏ hàng
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="shopping-cart-form table-responsive">
                            <form action="{{ route('cart.update') }}" method="POST" id="cart-form">
                                @csrf
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">&nbsp;</th>
                                            <th class="product-thumb">&nbsp;</th>
                                            <th class="product-name">Sản phẩm</th>
                                            <th class="product-price">Giá</th>
                                            <th class="product-quantity">Số lượng</th>
                                            <th class="product-subtotal">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr class="cart-product-item">
                                                <td class="product-remove">
                                                    <button type="button" class="remove-item-btn"
                                                        data-item-id="{{ $item->id }}"
                                                        onclick="removeCartItem({{ $item->id }}, event)"
                                                        style="border: none; background: none;">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </td>
                                                <td class="product-thumb">
                                                    <a href="{{ route('product.show', $item->product->id) }}">
                                                        @if ($item->product->getFirstMediaUrl('product-images'))
                                                            <img src="{{ $item->product->getFirstMediaUrl('product-images', 'thumb') }}"
                                                                width="90" height="110"
                                                                alt="{{ $item->product->name }}">
                                                        @else
                                                            <img src="{{ asset('img/shop/placeholder.webp') }}"
                                                                width="90" height="110"
                                                                alt="{{ $item->product->name }}">
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                                    </h4>
                                                    @if ($item->color || $item->size)
                                                        <div class="product-variants">
                                                            @if ($item->color)
                                                                <small>Màu: {{ $item->color }}</small><br>
                                                            @endif
                                                            @if ($item->size)
                                                                <small>Size: {{ $item->size }}</small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="product-price">
                                                    <span class="price">{{ number_format($item->price, 0, ',', '.') }}₫</span>
                                                </td>
                                                <td class="product-quantity">
                                                    <div class="quantity-wrapper">
                                                        <button type="button" class="quantity-btn decrement-btn"
                                                                data-item-id="{{ $item->id }}"
                                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="quantity-input"
                                                               name="quantities[{{ $item->id }}]"
                                                               value="{{ $item->quantity }}"
                                                               data-item-id="{{ $item->id }}"
                                                               data-price="{{ $item->price }}"
                                                               min="1" max="100" readonly>
                                                        <button type="button" class="quantity-btn increment-btn"
                                                                data-item-id="{{ $item->id }}"
                                                                {{ $item->quantity >= 100 ? 'disabled' : '' }}>
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="price item-total" data-item-id="{{ $item->id }}">
                                                        {{ number_format($item->quantity * $item->price, 0, ',', '.') }}₫
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="actions">
                                            <td class="border-0" colspan="6">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('shop') }}" class="btn btn-outline-primary">
                                                        <i class="fa fa-shopping-bag me-2"></i>
                                                        Tiếp tục mua sắm
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row row-gutter-50">
                    <div class="col-md-12 col-lg-8">
                        <div class="shipping-form-cart-totals">
                            <div class="section-title-cart">
                                <h5 class="title">Mã Giảm Giá</h5>
                            </div>
                            <div class="coupon-form-wrap">
                                @if($appliedCoupon)
                                    <!-- Applied Coupon Display -->
                                    <div class="applied-coupon-info">
                                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="fa fa-tag text-success me-2"></i>
                                                    {{ $appliedCoupon->code }}
                                                </h6>
                                                <small class="text-muted">{{ $appliedCoupon->name }}</small>
                                                <div class="mt-1">
                                                    <span class="badge bg-success">
                                                        Giảm {{ number_format($couponDiscount, 0, ',', '.') }}₫
                                                    </span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-coupon-btn">
                                                <i class="fa fa-times"></i> Xóa
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <!-- Coupon Input Form -->
                                    <form id="coupon-form" class="coupon-form">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <input type="text"
                                                       id="coupon_code"
                                                       name="coupon_code"
                                                       class="form-control"
                                                       placeholder="Nhập mã giảm giá..."
                                                       style="text-transform: uppercase;">
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-dark w-100 apply-coupon-btn">
                                                    <i class="fa fa-check me-1"></i>
                                                    Áp Dụng
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="fa fa-info-circle me-1"></i>
                                            Nhập mã giảm giá để được ưu đãi thêm
                                        </small>
                                    </form>
                                @endif

                                <!-- Coupon Messages -->
                                <div class="coupon-alert mt-3" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4">
                        <div class="shipping-form-cart-totals">
                            <div class="section-title-cart">
                                <h5 class="title">Tổng Giỏ Hàng</h5>
                            </div>
                            <div class="cart-total-table">
                                <table class="table">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <td>
                                                <p class="value">Tổng phụ</p>
                                            </td>
                                            <td>
                                                <p class="price" id="subtotal">{{ number_format($cartTotal, 0, ',', '.') }}₫</p>
                                            </td>
                                        </tr>
                                        @if($appliedCoupon && $couponDiscount > 0)
                                        <tr class="cart-discount">
                                            <td>
                                                <p class="value">Giảm giá</p>
                                            </td>
                                            <td>
                                                <p class="price text-success" id="discount">-{{ number_format($couponDiscount, 0, ',', '.') }}₫</p>
                                            </td>
                                        </tr>
                                        @endif
                                        @php
                                            $subtotalAfterDiscount = $cartTotal - $couponDiscount;
                                            // Phí ship cố định 30.000đ
                                            $shippingFee = 30000;
                                            // VAT 10%
                                            $vatRate = 0.10;
                                            $vatAmount = $subtotalAfterDiscount * $vatRate;
                                            // Tổng cuối
                                            $finalTotal = $subtotalAfterDiscount + $shippingFee + $vatAmount;
                                        @endphp
                                        <tr class="cart-shipping">
                                            <td>
                                                <p class="value">
                                                    Phí vận chuyển
                                                    <i class="fa fa-info-circle ms-1"
                                                       data-bs-toggle="tooltip"
                                                       title="Phí vận chuyển cố định toàn quốc"></i>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="price" id="shipping">{{ number_format($shippingFee, 0, ',', '.') }}₫</p>
                                            </td>
                                        </tr>
                                        <tr class="cart-vat">
                                            <td>
                                                <p class="value">
                                                    VAT (10%)
                                                    <i class="fa fa-info-circle ms-1"
                                                       data-bs-toggle="tooltip"
                                                       title="Thuế giá trị gia tăng"></i>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="price" id="vat">{{ number_format($vatAmount, 0, ',', '.') }}₫</p>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>
                                                <p class="value">Tổng cộng</p>
                                            </td>
                                            <td>
                                                <p class="price" id="total">{{ number_format($finalTotal, 0, ',', '.') }}₫</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a class="btn-theme btn-flat w-100" href="{{ route('checkout') }}">
                                <i class="fa fa-lock me-2"></i>
                                Tiến hành thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="cart-empty text-center py-5">
                            <h2>Giỏ hàng của bạn đang trống</h2>
                            <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                            <a href="{{ route('shop') }}" class="btn-theme btn-flat">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--== End Shopping Cart Area ==-->

    <!-- Delete Item Modal -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteItemModalLabel">Xóa sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fa fa-trash-o text-danger" style="font-size: 48px; margin-bottom: 16px;"></i>
                    <p class="mb-0">Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteItem">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Cart Modal -->
    <div class="modal fade" id="clearCartModal" tabindex="-1" aria-labelledby="clearCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="clearCartModalLabel">Xóa giỏ hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fa fa-exclamation-triangle text-warning" style="font-size: 48px; margin-bottom: 16px;"></i>
                    <p class="mb-0">Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?</p>
                    <p class="text-muted small">Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmClearCart">Xóa tất cả</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Function to format price in Vietnamese format
        function formatVietnamPrice(price) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'decimal',
                maximumFractionDigits: 0
            }).format(price) + '₫';
        }

        // Function to show coupon messages
        function showCouponMessage(type, message) {
            const alertDiv = $('.coupon-alert');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';

            alertDiv.removeClass('alert-success alert-danger')
                   .addClass(`alert ${alertClass}`)
                   .html(`<i class="fa fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}`)
                   .fadeIn();

            setTimeout(() => {
                alertDiv.fadeOut();
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // CSRF token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Store current item ID for deletion
            let currentDeleteItemId = null;

            // Handle increment button clicks
            document.querySelectorAll('.increment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    updateQuantity(itemId, 'increment', this);
                });
            });

            // Handle decrement button clicks
            document.querySelectorAll('.decrement-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    updateQuantity(itemId, 'decrement', this);
                });
            });

            // Handle delete item modal confirm
            const confirmDeleteBtn = document.getElementById('confirmDeleteItem');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (currentDeleteItemId) {
                        executeRemoveItem(currentDeleteItemId);
                        // Hide modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteItemModal'));
                        if (modal) {
                            modal.hide();
                        }
                    }
                });
            }

            // Handle clear cart modal confirm
            const confirmClearBtn = document.getElementById('confirmClearCart');
            if (confirmClearBtn) {
                confirmClearBtn.addEventListener('click', function() {
                    executeClearCart();
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('clearCartModal'));
                    if (modal) {
                        modal.hide();
                    }
                });
            }

            // Handle coupon form submission
            $('#coupon-form').on('submit', function(e) {
                e.preventDefault();

                const couponCode = $('#coupon_code').val().trim().toUpperCase();
                if (!couponCode) {
                    showCouponMessage('error', 'Vui lòng nhập mã giảm giá.');
                    return;
                }

                const $btn = $('.apply-coupon-btn');
                const originalHtml = $btn.html();

                // Show loading
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i>Đang xử lý...');

                $.ajax({
                    url: '{{ route("cart.coupon") }}',
                    method: 'POST',
                    data: {
                        coupon_code: couponCode,
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            showCouponMessage('success', response.message);
                            // Reload page to show applied coupon
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showCouponMessage('error', response.message);
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Có lỗi xảy ra. Vui lòng thử lại.';
                        showCouponMessage('error', message);
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // Handle remove coupon
            $('.remove-coupon-btn').on('click', function() {
                const $btn = $(this);
                const originalHtml = $btn.html();

                if (!confirm('Bạn có chắc muốn xóa mã giảm giá?')) {
                    return;
                }

                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '{{ route("cart.coupon.remove") }}',
                    method: 'DELETE',
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            showCouponMessage('success', response.message);
                            // Reload page to update view
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showCouponMessage('error', response.message);
                            $btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr) {
                        showCouponMessage('error', 'Có lỗi xảy ra khi xóa mã giảm giá.');
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // Auto uppercase coupon code
            $('#coupon_code').on('input', function() {
                this.value = this.value.toUpperCase();
            });

            function updateQuantity(itemId, action, button) {
                // Disable button during request
                button.disabled = true;

                const url = action === 'increment'
                    ? '{{ route("cart.increment") }}'
                    : '{{ route("cart.decrement") }}';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        cart_item_id: itemId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update quantity input
                        const quantityInput = document.querySelector(`input[data-item-id="${itemId}"]`);
                        if (quantityInput) {
                            quantityInput.value = data.item_quantity;
                        }

                        // Update item total
                        const itemTotalElement = document.querySelector(`.item-total[data-item-id="${itemId}"]`);
                        if (itemTotalElement) {
                            itemTotalElement.textContent = formatVietnamPrice(data.item_total);
                        }

                        // Get current discount if any
                        const discountElement = document.getElementById('discount');
                        let discountAmount = 0;
                        if (discountElement) {
                            const discountText = discountElement.textContent.replace(/[^\d]/g, '');
                            discountAmount = parseFloat(discountText) || 0;
                        }

                        // Calculate new totals with VAT and shipping
                        const subtotal = data.cart_total;
                        const subtotalAfterDiscount = subtotal - discountAmount;
                        const shippingFee = 30000;
                        const vatAmount = subtotalAfterDiscount * 0.10;
                        const finalTotal = subtotalAfterDiscount + shippingFee + vatAmount;

                        // Update cart totals
                        const subtotalElement = document.getElementById('subtotal');
                        const shippingElement = document.getElementById('shipping');
                        const vatElement = document.getElementById('vat');
                        const totalElement = document.getElementById('total');

                        if (subtotalElement) {
                            subtotalElement.textContent = formatVietnamPrice(subtotal);
                        }
                        if (shippingElement) {
                            shippingElement.textContent = formatVietnamPrice(shippingFee);
                        }
                        if (vatElement) {
                            vatElement.textContent = formatVietnamPrice(vatAmount);
                        }
                        if (totalElement) {
                            totalElement.textContent = formatVietnamPrice(finalTotal);
                        }

                        // Update cart count in header/sidebar if exists
                        const cartCountElements = document.querySelectorAll('.cart-count');
                        cartCountElements.forEach(element => {
                            element.textContent = data.cart_count;
                        });

                        // Enable/disable buttons based on new quantity
                        updateButtonStates(itemId, data.item_quantity);

                        // Show success message
                        if (typeof showSuccess === 'function') {
                            showSuccess(data.message);
                        }
                    } else {
                        // Show error message
                        if (typeof showError === 'function') {
                            showError(data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showError === 'function') {
                        showError('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                })
                .finally(() => {
                    // Re-enable button
                    button.disabled = false;
                });
            }

            function updateButtonStates(itemId, quantity) {
                const decrementBtn = document.querySelector(`.decrement-btn[data-item-id="${itemId}"]`);
                const incrementBtn = document.querySelector(`.increment-btn[data-item-id="${itemId}"]`);

                if (decrementBtn) {
                    decrementBtn.disabled = quantity <= 1;
                }
                if (incrementBtn) {
                    incrementBtn.disabled = quantity >= 100;
                }
            }

            function executeRemoveItem(itemId) {
                fetch('{{ route("cart.remove") }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        cart_item_id: itemId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const button = document.querySelector(`button[data-item-id="${itemId}"]`);
                        if (button) {
                            const row = button.closest('tr');
                            if (row) {
                                row.style.transition = 'opacity 0.3s ease';
                                row.style.opacity = '0';
                                setTimeout(() => {
                                    row.remove();
                                }, 300);
                            }
                        }

                        // Update cart totals - delay this to let animation finish
                        setTimeout(() => {
                            const subtotalElement = document.getElementById('subtotal');
                            const totalElement = document.getElementById('total');
                            if (subtotalElement) {
                                subtotalElement.textContent = '$' + data.cart_total;
                            }
                            if (totalElement) {
                                totalElement.textContent = '$' + data.cart_total;
                            }

                            // Update cart count in header/sidebar if exists
                            const cartCountElements = document.querySelectorAll('.cart-count');
                            cartCountElements.forEach(element => {
                                element.textContent = data.cart_count;
                            });

                            // Check if cart is empty and reload page if needed
                            if (data.cart_count === 0) {
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        }, 350);

                        showSuccess(data.message);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra. Vui lòng thử lại.');
                });
            }

            function executeClearCart() {
                fetch('{{ route("cart.clear") }}', {
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
                        // Reload the page to show empty cart
                        location.reload();
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra. Vui lòng thử lại.');
                });
            }

            // Toast messages are now handled by the global toast system

            // Make functions available globally for onclick handlers
            window.removeCartItem = function(itemId, event) {
                if (event) event.preventDefault();
                currentDeleteItemId = itemId;
                const modal = new bootstrap.Modal(document.getElementById('deleteItemModal'));
                modal.show();
            };

            window.clearCart = function(event) {
                if (event) event.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('clearCartModal'));
                modal.show();
            };
        });
    </script>
@endpush

@push('styles')
<style>
    /* Quantity control styles */
    .quantity-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        border: 1px solid #ddd;
        background: #f8f9fa;
        color: #333;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover:not(:disabled) {
        background: #e9ecef;
        border-color: #adb5bd;
        color: #495057;
    }

    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #e9ecef;
    }

    .quantity-input {
        width: 60px;
        height: 35px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        background: #fff;
    }

    .quantity-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Remove item button styles */
    .remove-item-btn {
        color: #666;
        font-size: 18px;
        transition: color 0.3s ease;
        padding: 5px;
    }

    .remove-item-btn:hover {
        color: #dc3545;
    }

    /* Clear cart button styles */
    .clear-cart {
        display: inline-block;
        padding: 10px 20px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        margin-right: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .clear-cart:hover {
        background-color: #c82333;
        color: white;
        text-decoration: none;
    }

    /* Modal improvements */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    /* Message styling */
    .cart-message {
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 15px;
        margin-bottom: 0;
    }

    /* Animation for row removal */
    .removing-row {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Coupon form styles */
    .coupon-form-wrap {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .coupon-form .form-control {
        height: 45px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-weight: 500;
    }

    .coupon-form .form-control:focus {
        border-color: #333;
        box-shadow: 0 0 0 0.2rem rgba(51, 51, 51, 0.1);
    }

    .apply-coupon-btn {
        height: 45px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .apply-coupon-btn:hover {
        background: #000;
        border-color: #000;
    }

    .applied-coupon-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }

    .applied-coupon-info h6 {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .applied-coupon-info .badge {
        font-size: 13px;
        padding: 5px 10px;
    }

    .coupon-alert {
        padding: 12px 15px;
        border-radius: 6px;
        font-size: 14px;
    }

    .shipping-form-cart-totals {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-title-cart {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .section-title-cart .title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .cart-total-table .table tbody tr td {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-total-table .table tbody tr:last-child td {
        border-bottom: none;
    }

    .cart-total-table .value {
        font-weight: 500;
        color: #666;
        margin: 0;
    }

    .cart-total-table .price {
        font-weight: 600;
        color: #333;
        text-align: right;
        margin: 0;
    }

    .cart-total-table .order-total .value,
    .cart-total-table .order-total .price {
        font-size: 18px;
        font-weight: 700;
        color: #000;
    }

    .cart-discount .price {
        color: #28a745 !important;
        font-weight: 600;
    }

    /* Clear cart button at top */
    .clear-cart-btn-top {
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: 2px solid #dc3545;
        background: white;
        color: #dc3545;
        display: inline-flex;
        align-items: center;
    }

    .clear-cart-btn-top:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .clear-cart-btn-top i {
        font-size: 16px;
    }

    /* New action buttons styles */
    .clear-cart-btn {
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: 2px solid #dc3545;
        background: white;
        color: #dc3545;
    }

    .clear-cart-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-primary {
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: 2px solid #007bff;
        background: white;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background: #007bff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .actions td {
        padding: 20px 0 !important;
    }

    /* Shipping and VAT row styles */
    .cart-shipping .value,
    .cart-vat .value {
        font-size: 14px;
    }

    .cart-shipping .price,
    .cart-vat .price {
        font-size: 14px;
        color: #666;
    }

    .fa-info-circle {
        font-size: 13px;
        color: #6c757d;
        cursor: help;
    }

    /* Checkout button enhancement */
    .btn-theme.btn-flat.w-100 {
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 15px;
    }

    @media (max-width: 576px) {
        .clear-cart-btn,
        .btn-outline-primary {
            width: 100%;
            margin-bottom: 10px;
        }

        .actions td .d-flex {
            flex-direction: column;
        }
    }
</style>
@endpush
