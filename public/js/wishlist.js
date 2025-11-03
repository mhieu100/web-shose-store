/**
 * Enhanced Wishlist JavaScript with Add to Cart functionality
 */

$(document).ready(function() {
    // Initialize wishlist functionality
    initWishlist();
    
    // Update wishlist count on page load
    updateWishlistCount();
});

function initWishlist() {
    // Remove from wishlist
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const row = $(this).closest('tr');
        
        removeFromWishlist(productId, row);
    });

    // Add to cart from wishlist
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');
        const productPrice = button.data('product-price');
        
        addToCartFromWishlist(productId, productName, productPrice, button);
    });

    // Quick view functionality
    $(document).on('click', '.quick-view-btn', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        showQuickView(productId);
    });
}

function removeFromWishlist(productId, row) {
    // Add loading state
    row.addClass('removing');
    
    $.ajax({
        url: '/wishlist/remove',
        method: 'DELETE',
        data: {
            product_id: productId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Animate row removal
                row.fadeOut(400, function() {
                    $(this).remove();
                    
                    // Check if wishlist is empty
                    if ($('.cart-wishlist-item').length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                });
                
                // Update wishlist count
                updateWishlistCount();
                
                // Show success message
                showToast('success', response.message);
            } else {
                row.removeClass('removing');
                showToast('error', response.message);
            }
        },
        error: function(xhr) {
            row.removeClass('removing');
            
            const response = xhr.responseJSON;
            if (response && response.redirect) {
                window.location.href = response.redirect;
                return;
            }
            
            let errorMessage = 'An error occurred while removing the item';
            if (response && response.message) {
                errorMessage = response.message;
            }
            
            showToast('error', errorMessage);
        }
    });
}

function addToCartFromWishlist(productId, productName, productPrice, button) {
    // Add loading state
    button.prop('disabled', true);
    button.html('<i class="fa fa-spinner fa-spin"></i> Adding...');
    
    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            product_id: productId,
            quantity: 1,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Show success message
                showToast('success', `${productName} added to cart successfully!`);
                
                // Update cart count if function exists
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
                
                // Reset button
                button.prop('disabled', false);
                button.html('<i class="fa fa-shopping-cart"></i> Add to Cart');
                
                // Optional: Remove from wishlist after adding to cart
                // Uncomment the line below if you want this behavior
                // removeFromWishlist(productId, button.closest('tr'));
                
            } else {
                button.prop('disabled', false);
                button.html('<i class="fa fa-shopping-cart"></i> Add to Cart');
                showToast('error', response.message);
            }
        },
        error: function(xhr) {
            button.prop('disabled', false);
            button.html('<i class="fa fa-shopping-cart"></i> Add to Cart');
            
            const response = xhr.responseJSON;
            if (response && response.redirect) {
                window.location.href = response.redirect;
                return;
            }
            
            let errorMessage = 'An error occurred while adding to cart';
            if (response && response.message) {
                errorMessage = response.message;
            }
            
            showToast('error', errorMessage);
        }
    });
}

function showQuickView(productId) {
    // You can implement quick view modal here
    // For now, redirect to product page
    window.location.href = `/product/${productId}`;
}

function updateWishlistCount() {
    $.ajax({
        url: '/wishlist/count',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                // Update wishlist counter in header
                $('.wishlist-count, .wishlist-counter').text(response.count);
                
                // Update badge
                if (response.count > 0) {
                    $('.wishlist-badge').text(response.count).show();
                } else {
                    $('.wishlist-badge').hide();
                }
            }
        },
        error: function(xhr) {
            console.error('Failed to update wishlist count');
        }
    });
}

function showToast(type, message) {
    // Remove existing toasts
    $('.toast-notification').remove();
    
    // Create toast HTML
    const toastHtml = `
        <div class="toast-notification ${type}">
            <div class="toast-content">
                <div class="toast-icon">
                    <i class="fa ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                </div>
                <div class="toast-message">${message}</div>
                <button class="toast-close" onclick="$(this).closest('.toast-notification').remove()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    // Add to body
    $('body').append(toastHtml);
    
    // Show toast
    setTimeout(() => {
        $('.toast-notification').addClass('show');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        $('.toast-notification').removeClass('show');
        setTimeout(() => {
            $('.toast-notification').remove();
        }, 300);
    }, 5000);
}

// Enhanced image loading
$(document).on('load', '.product-image', function() {
    $(this).closest('.product-image-wrapper').addClass('loaded');
});

$(document).on('error', '.product-image', function() {
    $(this).attr('src', '/img/shop/placeholder.webp');
    $(this).addClass('placeholder-image');
});

/**
 * Wishlist functionality
 */
$(document).ready(function() {
    // CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Check if wishlist is empty on page load
    setTimeout(function() {
        checkEmptyWishlist();
    }, 100);

    // Add to wishlist
    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();

        // Check if user is authenticated before proceeding
        const isAuthenticated = $('meta[name="user-authenticated"]').attr('content') === 'true';
        if (!isAuthenticated) {
            // Redirect to login immediately
            window.location.href = '/login';
            return;
        }

        const productId = $(this).data('product-id');
        const button = $(this);

        button.prop('disabled', true);

        $.ajax({
            url: '/wishlist/add',
            method: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Update UI với animation
                    button.addClass('animate-heart');
                    setTimeout(() => {
                        button.removeClass('add-to-wishlist animate-heart')
                              .addClass('remove-from-wishlist')
                              .html('<i class="fa fa-heart"></i>')
                              .attr('title', 'Xóa khỏi danh sách yêu thích');
                    }, 150);

                    // Update wishlist count
                    updateWishlistCount(response.wishlist_count);

                    // Show success message
                    showSuccess('Đã thêm vào danh sách yêu thích! ❤️');
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

    // Remove from wishlist
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const button = $(this);
        const row = button.closest('tr');
        const card = button.closest('.wishlist-card');

        button.prop('disabled', true);

        $.ajax({
            url: '/wishlist/remove',
            method: 'DELETE',
            data: {
                product_id: productId
            },
            success: function(response) {
                console.log('Remove success response:', response); // Debug log

                if (response.success) {
                    // If we're on wishlist page, remove the item
                    if (row.hasClass('wishlist-item')) {
                        // Desktop table row
                        row.addClass('removing');
                        row.fadeOut(500, function() {
                            $(this).remove();
                            checkEmptyWishlist();
                        });
                    } else if (card.length) {
                        // Mobile card
                        card.addClass('removing');
                        card.fadeOut(500, function() {
                            $(this).remove();
                            checkEmptyWishlist();
                        });
                    } else {
                        // Update UI for product pages với animation
                        button.addClass('animate-heart');
                        setTimeout(() => {
                            button.removeClass('remove-from-wishlist animate-heart')
                                  .addClass('add-to-wishlist')
                                  .html('<i class="fa fa-heart-o"></i>')
                                  .attr('title', 'Thêm vào danh sách yêu thích');
                        }, 150);
                    }

                    // Update wishlist count
                    updateWishlistCount(response.wishlist_count);

                    // Show success message
                    showSuccess('Đã xóa sản phẩm khỏi danh sách yêu thích');
                } else {
                    console.log('Remove failed:', response.message); // Debug log
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

    // Toggle wishlist (add/remove)
    $(document).on('click', '.toggle-wishlist', function(e) {
        e.preventDefault();

        // Check if user is authenticated before proceeding
        const isAuthenticated = $('meta[name="user-authenticated"]').attr('content') === 'true';
        if (!isAuthenticated) {
            // Redirect to login immediately
            window.location.href = '/login';
            return;
        }

        const productId = $(this).data('product-id');
        const button = $(this);

        button.prop('disabled', true);

        $.ajax({
            url: '/wishlist/toggle',
            method: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Update button state
                    if (response.in_wishlist) {
                        button.removeClass('add-to-wishlist')
                              .addClass('remove-from-wishlist')
                              .html('<i class="fa fa-heart"></i>')
                              .attr('title', 'Remove from wishlist');
                    } else {
                        button.removeClass('remove-from-wishlist')
                              .addClass('add-to-wishlist')
                              .html('<i class="fa fa-heart-o"></i>')
                              .attr('title', 'Add to wishlist');
                    }

                    // Update wishlist count
                    updateWishlistCount(response.wishlist_count);

                    // Show success message
                    showSuccess(response.message);
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

    // Clear wishlist - Show modal
    $(document).on('click', '.clear-wishlist', function(e) {
        e.preventDefault();

        // Update modal count
        const currentCount = $('.wishlist-item, .wishlist-card').length;
        $('#modal-item-count').text(currentCount);
        $('#modal-item-text').text(currentCount === 1 ? 'item' : 'items');

        // Show modal using Bootstrap 5
        const modal = new bootstrap.Modal(document.getElementById('clearWishlistModal'));
        modal.show();
    });

    // Confirm clear wishlist
    $(document).on('click', '#confirmClearWishlist', function(e) {
        e.preventDefault();

        const button = $(this);
        button.prop('disabled', true);

        $.ajax({
            url: '/wishlist/clear',
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    // Hide modal using Bootstrap 5
                    const modal = bootstrap.Modal.getInstance(document.getElementById('clearWishlistModal'));
                    if (modal) modal.hide();

                    // Remove all wishlist items with animation
                    $('.wishlist-item, .wishlist-card').addClass('removing').fadeOut(500, function() {
                        $(this).remove();
                        checkEmptyWishlist();
                    });

                    // Update wishlist count
                    updateWishlistCount(0);

                    // Show success message
                    showSuccess('Đã xóa toàn bộ danh sách yêu thích');
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

    // Update wishlist count in UI
    function updateWishlistCount(count) {
        $('.wishlist-count').text(count);
        if (count > 0) {
            $('.wishlist-count').show();
        } else {
            $('.wishlist-count').hide();
        }
    }

    // Check if wishlist is empty and show empty message
    function checkEmptyWishlist() {
        const desktopTable = $('.wishlist-table tbody');
        const mobileCards = $('.wishlist-mobile');
        const mainContainer = $('.wishlist-area .container');

        // Check if there are any items left in desktop table or mobile cards
        const hasDesktopItems = desktopTable.find('.wishlist-item').length > 0;
        const hasMobileItems = mobileCards.find('.wishlist-card').length > 0;

        // If no items in either desktop or mobile
        if (!hasDesktopItems && !hasMobileItems) {
            // Hide wishlist header
            $('.wishlist-header').fadeOut(300);

            // Hide table and mobile sections
            $('.wishlist-table-wrapper').fadeOut(300);
            $('.wishlist-mobile').fadeOut(300);

            // Show empty state with animation
            setTimeout(() => {
                // Check if empty state already exists from server side
                if ($('.empty-wishlist-state').length) {
                    $('.empty-wishlist-state').show().animate({opacity: 1}, 500);
                } else {
                    const emptyStateHtml = `
                        <div class="col-12">
                            <div class="empty-wishlist-state" style="opacity: 0;">
                                <div class="text-center py-5">
                                    <div class="empty-icon mb-4">
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                    <h4 class="empty-title">Your wishlist is empty</h4>
                                    <p class="empty-subtitle">Discover amazing products and add them to your wishlist</p>
                                    <a href="/shop" class="btn-continue-shopping">
                                        <i class="fa fa-shopping-bag me-2"></i>
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    mainContainer.find('.row').last().append(emptyStateHtml);
                    $('.empty-wishlist-state').animate({opacity: 1}, 500);
                }
            }, 300);
        }
    }    // Toast notifications are now handled by the global toast system

    // Load wishlist count on page load
    function loadWishlistCount() {
        $.ajax({
            url: '/wishlist/count',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    updateWishlistCount(response.count);
                }
            }
        });
    }

    // Initialize wishlist count
    loadWishlistCount();
});
