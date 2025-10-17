/**
 * Cart Sidebar Dynamic Updates
 * Handles real-time updates of cart sidebar without page reload
 */

$(document).ready(function() {
    
    // Remove item from cart sidebar
    $(document).on('click', '.aside-cart-product-list .remove', function(e) {
        e.preventDefault();
        
        const productId = $(this).data('product-id');
        const cartItemElement = $(this).closest('.product-list-item');
        const productName = cartItemElement.find('.product-title').text();
        
        if (!productId) {
            console.error('Product ID not found');
            return;
        }
        
        // Show loading state
        cartItemElement.addClass('removing');
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        
        // AJAX request to remove item
        $.ajax({
            url: '/cart/remove',
            type: 'DELETE',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Remove item with animation
                    cartItemElement.fadeOut(300, function() {
                        $(this).remove();
                        updateSidebarAfterChange();
                    });
                    
                    // Update cart count in header
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }
                    
                    // Show success notification
                    showCartNotification('success', `Đã xóa "${productName}" khỏi giỏ hàng`);
                    
                } else {
                    showCartNotification('error', response.message || 'Không thể xóa sản phẩm');
                    cartItemElement.removeClass('removing');
                    $(this).html('×');
                }
            },
            error: function(xhr, status, error) {
                console.error('Remove from cart error:', error);
                showCartNotification('error', 'Có lỗi xảy ra khi xóa sản phẩm');
                cartItemElement.removeClass('removing');
                $(this).html('×');
            }
        });
    });
    
    // Update sidebar after any change
    function updateSidebarAfterChange() {
        const remainingItems = $('.aside-cart-product-list .product-list-item:visible').length;
        
        if (remainingItems === 0) {
            // Show empty cart message
            showEmptyCartMessage();
        } else {
            // Recalculate total
            updateSidebarTotal();
        }
    }
    
    // Show empty cart message
    function showEmptyCartMessage() {
        const emptyMessage = `
            <div class="empty-cart-message" id="empty-cart-message">
                <div class="text-center py-4">
                    <i class="pe-7s-shopbag" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                    <h5>Giỏ hàng trống</h5>
                    <p class="text-muted">Chưa có sản phẩm nào trong giỏ hàng của bạn.</p>
                    <a href="/shop" class="btn-theme">Tiếp tục mua sắm</a>
                </div>
            </div>
        `;
        
        $('#cart-sidebar-content').html(emptyMessage);
    }
    
    // Update sidebar total
    function updateSidebarTotal() {
        // This would ideally fetch from server, but for now we can calculate client-side
        let total = 0;
        $('.aside-cart-product-list .product-list-item:visible').each(function() {
            const priceText = $(this).find('.product-price').text();
            // Extract price from format "2 × 299.000 VNĐ"
            const matches = priceText.match(/(\d+)\s*×\s*([\d.,]+)/);
            if (matches) {
                const quantity = parseInt(matches[1]);
                const price = parseInt(matches[2].replace(/[.,]/g, ''));
                total += quantity * price;
            }
        });
        
        $('#sidebar-cart-total').text(formatPrice(total) + ' VNĐ');
    }
    
    // Refresh entire sidebar from server
    function refreshCartSidebar() {
        $.ajax({
            url: '/cart/sidebar-content',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#cart-sidebar-content').html(response.html);
                    
                    // Update cart count if available
                    if (response.count !== undefined && typeof updateCartCount === 'function') {
                        $('#cart-count').text(response.count);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to refresh cart sidebar:', error);
            }
        });
    }
    
    // Add item to sidebar (called after successful add to cart)
    function addItemToSidebar(productData) {
        // Check if sidebar is empty
        if ($('#empty-cart-message').length > 0) {
            // Refresh entire sidebar if it was empty
            refreshCartSidebar();
            return;
        }
        
        // Check if item already exists
        const existingItem = $(`.product-list-item[data-cart-item-id="${productData.cart_item_id}"]`);
        if (existingItem.length > 0) {
            // Update existing item quantity and price
            existingItem.find('.product-price').text(`${productData.quantity} × ${formatPrice(productData.price)} VNĐ`);
            existingItem.addClass('updated');
            setTimeout(() => {
                existingItem.removeClass('updated');
            }, 1000);
        } else {
            // Add new item to top of list
            const newItem = createSidebarItem(productData);
            $('#sidebar-cart-items').prepend(newItem);
            newItem.hide().fadeIn(300);
        }
        
        updateSidebarTotal();
    }
    
    // Create sidebar item HTML
    function createSidebarItem(data) {
        const variants = [];
        if (data.color) variants.push(`Màu: ${data.color}`);
        if (data.size) variants.push(`Size: ${data.size}`);
        const variantText = variants.length > 0 ? `<span class="product-variants"><small>${variants.join(' | ')}</small></span>` : '';
        
        return $(`
            <li class="product-list-item" data-cart-item-id="${data.cart_item_id}">
                <a href="#" class="remove" data-product-id="${data.product_id}" title="Xóa sản phẩm">×</a>
                <a href="/product/${data.product_id}">
                    <img src="${data.image_url || '/img/shop/placeholder.webp'}" 
                         width="90" height="110" alt="${data.product_name}">
                    <span class="product-title">${data.product_name}</span>
                    ${variantText}
                </a>
                <span class="product-price">${data.quantity} × ${formatPrice(data.price)} VNĐ</span>
            </li>
        `);
    }
    
    // Format price for display
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }
    
    // Show cart notification
    function showCartNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        
        const notification = $(`
            <div class="cart-sidebar-notification alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.alert('close');
        }, 3000);
    }
    
    // Global function to update sidebar after add to cart
    window.updateCartSidebar = function(productData) {
        if (productData) {
            addItemToSidebar(productData);
        } else {
            refreshCartSidebar();
        }
    };
    
    // Global function to refresh sidebar
    window.refreshCartSidebar = refreshCartSidebar;
    
    // CSS for animations
    const sidebarStyles = `
        <style>
        .product-list-item.removing {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .product-list-item.updated {
            background-color: #f0f8ff;
            transition: background-color 0.3s ease;
        }
        
        .product-variants {
            display: block;
            color: #666;
            font-size: 12px;
            margin-top: 2px;
        }
        
        .empty-cart-message {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-cart-message i {
            display: block;
            margin-bottom: 20px;
        }
        
        .empty-cart-message h5 {
            color: #666;
            margin-bottom: 10px;
        }
        
        .cart-sidebar-notification {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
        }
        </style>
    `;
    
    // Inject styles if not already present
    if (!$('#cart-sidebar-styles').length) {
        $('head').append(sidebarStyles.replace('<style>', '<style id="cart-sidebar-styles">'));
    }
});