/**
 * Shop Page JavaScript
 * Handles Add to Cart functionality
 */

$(document).ready(function() {

    // Add to Cart functionality
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();

        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');
        const productPrice = button.data('product-price');

        // Disable button and show loading
        button.prop('disabled', true);
        const originalHtml = button.html();
        button.html('<i class="fa fa-spinner fa-spin"></i>');

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
                    showNotification('success', `${productName} has been added to your cart!`);

                    // Update cart count in header if exists
                    updateCartCount();

                    // Restore button
                    button.html('<i class="fa fa-check"></i> Added');
                    button.removeClass('add-to-cart').addClass('added-to-cart');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.html(originalHtml);
                        button.removeClass('added-to-cart').addClass('add-to-cart');
                        button.prop('disabled', false);
                    }, 2000);

                } else {
                    showNotification('error', response.message || 'Failed to add product to cart');
                    button.html(originalHtml);
                    button.prop('disabled', false);
                }
            },
            error: function(xhr) {
                console.error('Cart Error:', xhr);
                let message = 'Failed to add product to cart';

                if (xhr.status === 401) {
                    message = 'Please login to add items to cart';
                    // Redirect to login if needed
                    window.location.href = '/login';
                    return;
                }

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showNotification('error', message);
                button.html(originalHtml);
                button.prop('disabled', false);
            }
        });
    });

    // Update cart count in header
    function updateCartCount() {
        $.ajax({
            url: '/cart/count',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    // Update cart count badge if exists
                    $('.cart-count, .header-cart-count').text(response.count);

                    // Update any cart total displays
                    if (response.total) {
                        $('.cart-total').text('$' + response.total);
                    }
                }
            },
            error: function(xhr) {
                console.error('Failed to update cart count:', xhr);
            }
        });
    }

    // Show notification function
    function showNotification(type, message) {
        // Remove existing notifications
        $('.shop-notification').remove();

        // Create notification element
        const notification = $(`
            <div class="shop-notification alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show" role="alert">
                <i class="fa fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);

        // Insert at top of page
        $('body').prepend(notification);

        // Position notification
        notification.css({
            'position': 'fixed',
            'top': '20px',
            'right': '20px',
            'z-index': '9999',
            'max-width': '400px',
            'min-width': '300px'
        });

        // Auto hide after 5 seconds
        setTimeout(() => {
            notification.fadeOut(() => {
                notification.remove();
            });
        }, 5000);
    }

    // Quick add to cart from product cards
    $(document).on('click', '.btn-quick-add', function(e) {
        e.preventDefault();

        const productCard = $(this).closest('.product-item');
        const productId = productCard.data('product-id');
        const addButton = productCard.find('.add-to-cart');

        if (addButton.length) {
            addButton.trigger('click');
        }
    });

});

// CSS for notifications (can be moved to separate CSS file)
const notificationStyles = `
<style>
.shop-notification {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border: none;
}

.shop-notification.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.shop-notification.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.add-to-cart:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.added-to-cart {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: white !important;
}

.btn-product-cart.added-to-cart:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}
</style>
`;

// Inject styles
$('head').append(notificationStyles);
