/**
 * Shop Page JavaScript
 * Handles "Add to Cart" and other shop-related interactions.
 * This script is designed to work with product-options.js for products with variants.
 */

$(document).ready(function() {
    // CSRF token setup for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * This is the primary "Add to Cart" handler for the shop page.
     * It is designed to be a fallback for products WITHOUT variants.
     * Products WITH variants (colors/sizes) should be handled by product-options.js, which will show a modal.
     */
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();

        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');
        const productPrice = button.data('product-price');
        const productColors = button.data('product-colors');
        const productSizes = button.data('product-sizes');

        // If the product has colors or sizes, the product-options.js script should handle it by showing a modal.
        // This part of the script will only run if product-options.js is not loaded or if the product has no options.
        if ((productColors && productColors.length > 0) || (productSizes && productSizes.length > 0)) {
            // If product-options.js is loaded, it will call e.stopImmediatePropagation() and this won't be logged.
            console.log('Product has options. Modal should be triggered by product-options.js');
            // Do nothing and let the other script handle it.
            return;
        }

        // Disable button and show loading
        button.prop('disabled', true);
        const originalHtml = button.html();
        button.html('<i class="fa fa-spinner fa-spin"></i> Adding...');

        // AJAX request to add product to cart
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showSuccess(`"${productName}" đã được thêm vào giỏ hàng!`);

                    // Update cart count and sidebar (functions from product-options.js or cart-sidebar.js)
                    if (typeof updateCartCount === 'function') updateCartCount();
                    if (typeof updateCartSidebarContent === 'function') updateCartSidebarContent();

                    // Animate button to show success
                    button.html('<i class="fa fa-check"></i> Added!').addClass('added-to-cart');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.html(originalHtml);
                        button.prop('disabled', false);
                        // Use a different class to prevent re-triggering if clicked again quickly
                        button.removeClass('added-to-cart');
                    }, 2000);

                } else {
                    showError(response.message || 'Không thể thêm sản phẩm vào giỏ hàng');
                    button.html(originalHtml);
                    button.prop('disabled', false);
                }
            },
            error: function(xhr) {
                console.error('Cart Error:', xhr);
                let message = 'Không thể thêm sản phẩm vào giỏ hàng.';

                if (xhr.status === 401) {
                    message = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng';
                    // Redirect to login if needed
                    window.location.href = '/login';
                    return;
                }

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showError(message);
                button.html(originalHtml);
                button.prop('disabled', false);
            }
        });
    });

    // Update cart count in header
    window.updateShopPageCartCount = function() {
        $.ajax({
            url: '/cart/count',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    // Update cart count badge if exists
                    $('#cart-count, .cart-count, .header-cart-count, .shop-count').text(response.count);
                }
            },
            error: function(xhr) {
                console.error('Failed to update cart count:', xhr);
            }
        });
    };

    // Toast messages are now handled by the global toast system
});
