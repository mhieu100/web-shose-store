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
                    showNotification('Đã thêm vào danh sách yêu thích! ❤️', 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    showNotification(response ? response.message : 'An error occurred', 'error');
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
                    showNotification('Product removed from wishlist', 'success');
                } else {
                    console.log('Remove failed:', response.message); // Debug log
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showNotification(response ? response.message : 'An error occurred', 'error');
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });

    // Toggle wishlist (add/remove)
    $(document).on('click', '.toggle-wishlist', function(e) {
        e.preventDefault();

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
                    showNotification(response.message, 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    showNotification(response ? response.message : 'An error occurred', 'error');
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
                    showNotification('Wishlist cleared successfully', 'success');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showNotification(response ? response.message : 'An error occurred', 'error');
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
    }    // Show notification với theme màu đỏ
    function showNotification(message, type = 'info') {
        // Create notification element với style phù hợp theme
        const notificationClass = type === 'success' ? 'alert-success' : 'alert-warning';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        const notification = $(`
            <div class="alert ${notificationClass} alert-dismissible fade show wishlist-notification" role="alert" style="
                background: linear-gradient(135deg, ${type === 'success' ? '#eb3e32' : '#f8d7da'} 0%, ${type === 'success' ? '#d63384' : '#f5c6cb'} 100%);
                border: none;
                border-radius: 6px;
                box-shadow: 0 3px 12px rgba(0,0,0,0.1);
                color: ${type === 'success' ? '#ffffff' : '#721c24'};
                font-weight: 300;
                font-size: 13px;
                padding: 10px 15px;
                margin-bottom: 8px;
            ">
                <i class="fa ${iconClass}" style="margin-right: 6px; font-size: 12px;"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="
                    color: inherit;
                    opacity: 0.8;
                    font-size: 16px;
                    padding: 0;
                    margin-left: 8px;
                    font-weight: 300;
                ">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);

        // Add to page
        if ($('.wishlist-notifications').length === 0) {
            $('body').prepend('<div class="wishlist-notifications" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;"></div>');
        }

        $('.wishlist-notifications').append(notification);

        // Add entrance animation
        notification.hide().slideDown(300);

        // Auto hide after 4 seconds
        setTimeout(function() {
            notification.slideUp(300, function() {
                $(this).remove();
            });
        }, 4000);
    }

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
