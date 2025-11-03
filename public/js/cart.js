/**
 * Cart functionality
 */
$(document).ready(function() {
    // CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add to cart
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();

        // Check if user is authenticated before proceeding
        const isAuthenticated = $('meta[name="user-authenticated"]').attr('content') === 'true';
        if (!isAuthenticated) {
            // Redirect to login immediately
            window.location.href = '/login';
            return;
        }

        const productId = $(this).data('product-id');
        const quantity = $(this).data('quantity') || 1;
        const button = $(this);

        button.prop('disabled', true);

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Update cart count
                    updateCartCount(response.cart_count);
                    updateCartTotal(response.cart_total);

                    // Show success message
                    showSuccess(response.message);

                    // Update button text temporarily
                    const originalText = button.html();
                    button.html('<i class="fa fa-check me-1"></i> Added!');
                    setTimeout(() => {
                        button.html(originalText);
                    }, 2000);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    showError(response ? response.message : 'Có lỗi xảy ra');
                }
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });

    // Remove from cart
    $(document).on('click', '.remove-from-cart', function(e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const button = $(this);
        const row = button.closest('tr');
        const card = button.closest('.cart-card');

        button.prop('disabled', true);

        $.ajax({
            url: '/cart/remove',
            method: 'DELETE',
            data: {
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // If we're on cart page, remove the item
                    if (row.hasClass('cart-item')) {
                        // Desktop table row
                        row.addClass('removing');
                        row.fadeOut(500, function() {
                            $(this).remove();
                            checkEmptyCart();
                            updateCartSummary(response.cart_total, response.cart_count);
                        });
                    } else if (card.length) {
                        // Mobile card
                        card.addClass('removing');
                        card.fadeOut(500, function() {
                            $(this).remove();
                            checkEmptyCart();
                            updateCartSummary(response.cart_total, response.cart_count);
                        });
                    }

                    // Update cart count and total
                    updateCartCount(response.cart_count);
                    updateCartTotal(response.cart_total);

                    // Show success message
                    showNotification('Product removed from cart', 'success');
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showError(response ? response.message : 'Có lỗi xảy ra');
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });

    // Update cart quantity
    $(document).on('change', '.quantity-input, .quantity-input-mobile', function(e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const quantity = parseInt($(this).val());
        const input = $(this);

        if (quantity < 1 || quantity > 100) {
            showNotification('Quantity must be between 1 and 100', 'error');
            return;
        }

        updateCartQuantity(productId, quantity, input);
    });

    // Quantity plus/minus buttons
    $(document).on('click', '.quantity-plus, .quantity-minus', function(e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const isPlus = $(this).hasClass('quantity-plus');
        const input = $(this).siblings('.quantity-input, .quantity-input-mobile');
        let quantity = parseInt(input.val());

        if (isPlus) {
            quantity = Math.min(quantity + 1, 100);
        } else {
            quantity = Math.max(quantity - 1, 1);
        }

        input.val(quantity);
        updateCartQuantity(productId, quantity, input);
    });

    // Clear cart - Show modal
    $(document).on('click', '.clear-cart', function(e) {
        e.preventDefault();

        // Update modal count
        const currentCount = $('.cart-item, .cart-card').length;
        $('#modal-item-count').text(currentCount);
        $('#modal-item-text').text(currentCount === 1 ? 'item' : 'items');

        // Show modal using Bootstrap 5
        const modal = new bootstrap.Modal(document.getElementById('clearCartModal'));
        modal.show();
    });

    // Confirm clear cart
    $(document).on('click', '#confirmClearCart', function(e) {
        e.preventDefault();

        const button = $(this);
        button.prop('disabled', true);

        $.ajax({
            url: '/cart/clear',
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    // Hide modal using Bootstrap 5
                    const modal = bootstrap.Modal.getInstance(document.getElementById('clearCartModal'));
                    if (modal) modal.hide();

                    // Remove all cart items with animation
                    $('.cart-item, .cart-card').addClass('removing').fadeOut(500, function() {
                        $(this).remove();
                        checkEmptyCart();
                        updateCartSummary(0, 0);
                    });

                    // Update cart count and total
                    updateCartCount(0);
                    updateCartTotal(0);

                    // Show success message
                    showNotification('Cart cleared successfully', 'success');
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showError(response ? response.message : 'Có lỗi xảy ra');
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });

    // Update cart quantity function
    function updateCartQuantity(productId, quantity, inputElement) {
        inputElement.prop('disabled', true);

        $.ajax({
            url: '/cart/update',
            method: 'PUT',
            data: {
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Update item total
                    $(`.item-total[data-product-id="${productId}"], .item-total-mobile[data-product-id="${productId}"]`)
                        .text('$' + response.item_total.toFixed(2));

                    // Update cart summary
                    updateCartSummary(response.cart_total, response.cart_count);
                    updateCartCount(response.cart_count);
                    updateCartTotal(response.cart_total);

                    showNotification('Cart updated successfully', 'success');
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showError(response ? response.message : 'Có lỗi xảy ra');
            },
            complete: function() {
                inputElement.prop('disabled', false);
            }
        });
    }

    // Update cart count in UI
    function updateCartCount(count) {
        $('.cart-count').text(count);
        if (count > 0) {
            $('.cart-count').show();
        } else {
            $('.cart-count').hide();
        }
    }

    // Update cart total in UI
    function updateCartTotal(total) {
        $('.cart-total').text('$' + total.toFixed(2));
    }

    // Update cart summary
    function updateCartSummary(total, count) {
        $('.cart-subtotal').text('$' + total.toFixed(2));
        $('.cart-grand-total').text('$' + total.toFixed(2));

        // Update item count text
        const itemText = count === 1 ? 'item' : 'items';
        $('.cart-info p').text(`${count} ${itemText} in your cart`);
    }

    // Check if cart is empty and show empty message
    function checkEmptyCart() {
        const desktopTable = $('.cart-table tbody');
        const mobileCards = $('.cart-mobile');
        const mainContainer = $('.cart-area .container');

        // Check if there are any items left in desktop table or mobile cards
        const hasDesktopItems = desktopTable.find('.cart-item').length > 0;
        const hasMobileItems = mobileCards.find('.cart-card').length > 0;

        // If no items in either desktop or mobile
        if (!hasDesktopItems && !hasMobileItems) {
            // Hide cart header
            $('.cart-header').fadeOut(300);

            // Hide table and mobile sections
            $('.cart-table-wrapper').fadeOut(300);
            $('.cart-mobile').fadeOut(300);
            $('.cart-summary-wrapper').fadeOut(300);

            // Show empty state with animation
            setTimeout(() => {
                // Check if empty state already exists from server side
                if ($('.empty-cart-state').length) {
                    $('.empty-cart-state').show().animate({opacity: 1}, 500);
                } else {
                    const emptyStateHtml = `
                        <div class="col-12">
                            <div class="empty-cart-state" style="opacity: 0;">
                                <div class="text-center py-5">
                                    <div class="empty-icon mb-4">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <h4 class="empty-title">Your cart is empty</h4>
                                    <p class="empty-subtitle">Browse our products and add items to your cart</p>
                                    <a href="/shop" class="btn-continue-shopping">
                                        <i class="fa fa-shopping-bag me-2"></i>
                                        Start Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    mainContainer.find('.row').last().append(emptyStateHtml);
                    $('.empty-cart-state').animate({opacity: 1}, 500);
                }
            }, 300);
        }
    }

    // Toast messages are now handled by the global toast system
});
