/**
 * Product Options Modal Handler
 * Handles color and size selection when adding products to cart
 */

$(document).ready(function() {
    let currentProduct = null;
    let selectedColor = null;
    let selectedSize = null;
    let isProcessing = false; // Flag to prevent double-click

    // Handle add to cart button click
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevent other handlers from running
        
        // Prevent double-click
        if (isProcessing) {
            console.log('Already processing add to cart request...');
            return;
        }
        
        // Check if user is authenticated before proceeding
        const isAuthenticated = $('meta[name="user-authenticated"]').attr('content') === 'true';
        if (!isAuthenticated) {
            // Redirect to login immediately
            window.location.href = '/login';
            return;
        }
        
        const productId = $(this).data('product-id');
        const productName = $(this).data('product-name');
        const productPrice = $(this).data('product-price');
        
        // Safely parse JSON data
        let productColors = [];
        let productSizes = [];
        
        try {
            const colorsData = $(this).data('product-colors');
            productColors = typeof colorsData === 'string' ? JSON.parse(colorsData) : (Array.isArray(colorsData) ? colorsData : []);
        } catch (e) {
            console.warn('Invalid colors data:', e);
            productColors = [];
        }
        
        try {
            const sizesData = $(this).data('product-sizes');
            productSizes = typeof sizesData === 'string' ? JSON.parse(sizesData) : (Array.isArray(sizesData) ? sizesData : []);
        } catch (e) {
            console.warn('Invalid sizes data:', e);
            productSizes = [];
        }
        
        // Store current product data
        currentProduct = {
            id: productId,
            name: productName,
            price: productPrice,
            colors: Array.isArray(productColors) ? productColors : [],
            sizes: Array.isArray(productSizes) ? productSizes : []
        };

        // Reset selections
        selectedColor = null;
        selectedSize = null;

        // Check if product has colors or sizes
        const hasColors = currentProduct.colors.length > 0;
        const hasSizes = currentProduct.sizes.length > 0;

        // ALWAYS require modal if product has colors OR sizes
        if (hasColors || hasSizes) {
            // Show modal for selection
            showProductOptionsModal();
        } else {
            // Show notification that this product doesn't have variants
            showInfo(`"${currentProduct.name}" không có tùy chọn màu sắc hoặc kích thước.`);
            // Still add to cart for products without variants
            addToCartDirectly();
        }
    });

    function showProductOptionsModal() {
        // Update modal content
        $('#modal-product-name').text(currentProduct.name);
        $('#modal-product-price').text(formatPrice(currentProduct.price) + ' VNĐ');
        
        // Find product image (try to get from the product card)
        const productCard = $(`.add-to-cart[data-product-id="${currentProduct.id}"]`).closest('.product-item');
        const productImage = productCard.find('img').first().attr('src') || '/img/shop/placeholder.webp';
        $('#modal-product-image').attr('src', productImage);

        // Setup color options
        if (currentProduct.colors.length > 0) {
            setupColorOptions();
            $('#color-selection').show();
        } else {
            $('#color-selection').hide();
        }

        // Setup size options
        if (currentProduct.sizes.length > 0) {
            setupSizeOptions();
            $('#size-selection').show();
        } else {
            $('#size-selection').hide();
        }

        // Reset quantity
        $('#modal-quantity').val(1);

        // Hide selected options initially
        $('#selected-options').hide();
        
        // Disable confirm button initially if selections are required
        const needsColor = currentProduct.colors.length > 0;
        const needsSize = currentProduct.sizes.length > 0;
        if (needsColor || needsSize) {
            $('#confirm-add-to-cart').prop('disabled', true);
        }

        // Show modal using Bootstrap 5
        const modalElement = document.getElementById('productOptionsModal');
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false,
            focus: true
        });
        
        // Handle focus management for accessibility
        modalElement.addEventListener('shown.bs.modal', function() {
            // Remove aria-hidden when modal is shown
            modalElement.removeAttribute('aria-hidden');
            // Focus on the first input or button in modal
            const firstFocusable = modalElement.querySelector('button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusable) {
                firstFocusable.focus();
            }
        });
        
        modalElement.addEventListener('hidden.bs.modal', function() {
            // Restore aria-hidden when modal is hidden
            modalElement.setAttribute('aria-hidden', 'true');
        });
        
        modal.show();
    }

    function setupColorOptions() {
        const colorContainer = $('#color-options');
        colorContainer.empty();

        currentProduct.colors.forEach((color, index) => {
            let colorName, colorCode;
            
            if (typeof color === 'object') {
                colorName = color.name || color.color || 'Unknown';
                colorCode = color.color_code || color.code || color.hex || getColorCode(colorName);
            } else {
                colorName = color;
                colorCode = getColorCode(color);
            }

            const colorOption = $(`
                <div class="color-option" 
                     data-color="${colorName}" 
                     data-color-code="${colorCode}"
                     style="background-color: ${colorCode};"
                     title="${colorName}">
                </div>
            `);

            colorOption.on('click', function() {
                $('.color-option').removeClass('selected');
                $(this).addClass('selected');
                selectedColor = {
                    name: colorName,
                    code: colorCode
                };
                
                // Hide requirement message when color is selected
                $('#color-options .selection-required').fadeOut();
                
                updateSelectedSummary();
            });

            colorContainer.append(colorOption);
        });

        // Do NOT auto-select - force user to choose
        // Show requirement message
        if (currentProduct.colors.length > 0) {
            colorContainer.append('<div class="selection-required text-danger mt-2"><small><i class="fas fa-exclamation-circle me-1"></i>Vui lòng chọn màu sắc</small></div>');
        }
    }

    function setupSizeOptions() {
        const sizeContainer = $('#size-options');
        sizeContainer.empty();

        currentProduct.sizes.forEach((size, index) => {
            let sizeValue, sizeLabel;
            
            if (typeof size === 'object') {
                sizeValue = size.value || size.size || size.label || 'Unknown';
                sizeLabel = size.label || `Size ${sizeValue}`;
            } else {
                sizeValue = size;
                sizeLabel = `Size ${size}`;
            }

            const sizeOption = $(`
                <div class="size-option" 
                     data-size="${sizeValue}"
                     title="${sizeLabel}">
                    ${sizeValue}
                </div>
            `);

            sizeOption.on('click', function() {
                $('.size-option').removeClass('selected');
                $(this).addClass('selected');
                selectedSize = sizeValue;
                
                // Hide requirement message when size is selected
                $('#size-options .selection-required').fadeOut();
                
                updateSelectedSummary();
            });

            sizeContainer.append(sizeOption);
        });

        // Do NOT auto-select - force user to choose
        // Show requirement message
        if (currentProduct.sizes.length > 0) {
            sizeContainer.append('<div class="selection-required text-danger mt-2"><small><i class="fas fa-exclamation-circle me-1"></i>Vui lòng chọn kích thước</small></div>');
        }
    }

    function updateSelectedSummary() {
        const hasRequiredSelections = checkRequiredSelections();
        
        if (selectedColor || selectedSize) {
            let summary = '';
            
            if (selectedColor) {
                summary += `<div class="summary-item"><strong>Màu sắc:</strong> ${selectedColor.name}</div>`;
            }
            
            if (selectedSize) {
                summary += `<div class="summary-item"><strong>Kích thước:</strong> ${selectedSize}</div>`;
            }
            
            const quantity = $('#modal-quantity').val();
            summary += `<div class="summary-item"><strong>Số lượng:</strong> ${quantity}</div>`;
            
            $('#selected-summary').html(summary);
            $('#selected-options').show();
        } else {
            $('#selected-options').hide();
        }

        // Enable/disable confirm button
        $('#confirm-add-to-cart').prop('disabled', !hasRequiredSelections);
    }

    function checkRequiredSelections() {
        const needsColor = currentProduct.colors.length > 0;
        const needsSize = currentProduct.sizes.length > 0;
        
        return (!needsColor || selectedColor) && (!needsSize || selectedSize);
    }

    // Quantity controls
    $(document).on('click', '.qty-decrease', function() {
        const input = $('#modal-quantity');
        const currentVal = parseInt(input.val()) || 1;
        if (currentVal > 1) {
            input.val(currentVal - 1);
            updateSelectedSummary();
        }
    });

    $(document).on('click', '.qty-increase', function() {
        const input = $('#modal-quantity');
        const currentVal = parseInt(input.val()) || 1;
        input.val(currentVal + 1);
        updateSelectedSummary();
    });

    $(document).on('change', '#modal-quantity', function() {
        updateSelectedSummary();
    });

    // Confirm add to cart
    $(document).on('click', '#confirm-add-to-cart', function() {
        if (checkRequiredSelections()) {
            addToCartWithOptions();
        }
    });

    function addToCartWithOptions() {
        if (isProcessing) return; // Double-check
        isProcessing = true; // Set processing flag
        
        const quantity = parseInt($('#modal-quantity').val()) || 1;
        
        const cartData = {
            product_id: currentProduct.id,
            quantity: quantity,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        if (selectedColor) {
            cartData.color = selectedColor.name;
            cartData.color_code = selectedColor.code;
        }

        if (selectedSize) {
            cartData.size = selectedSize;
        }

        // Show loading
        const button = $('#confirm-add-to-cart');
        const originalText = button.html();
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...');

        // AJAX request
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: cartData,
            success: function(response) {
                // Hide modal using Bootstrap 5
                const modalElement = document.getElementById('productOptionsModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                } else {
                    // Fallback if no instance exists
                    modalElement.style.display = 'none';
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
                
                // Show success message
                showSuccess(`Đã thêm "${currentProduct.name}" vào giỏ hàng!`);
                
                // Update cart count and sidebar immediately
                console.log('🛒 Starting cart updates...');
                
                // Update cart count in header
                updateCartCount();
                console.log('✅ Cart count update initiated');
                
                // Update cart sidebar content
                updateCartSidebarContent();
                console.log('✅ Cart sidebar update initiated');
                
                // Update cart UI if needed
                if (typeof updateCartUI === 'function') {
                    updateCartUI();
                }
            },
            error: function(xhr, status, error) {
                console.error('Add to cart error:', error);
                
                const response = xhr.responseJSON;
                if (response && response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }
                
                let errorMessage = 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng';
                if (response && response.message) {
                    errorMessage = response.message;
                }
                
                showError(errorMessage);
            },
            complete: function() {
                // Restore button
                button.prop('disabled', false).html(originalText);
                // Reset processing flag
                isProcessing = false;
            }
        });
    }

    function addToCartDirectly() {
        if (isProcessing) return; // Double-check
        isProcessing = true; // Set processing flag
        
        const cartData = {
            product_id: currentProduct.id,
            quantity: 1,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: cartData,
            success: function(response) {
                showSuccess(`Đã thêm "${currentProduct.name}" vào giỏ hàng!`);
                
                // Update cart count and sidebar immediately
                console.log('🛒 Starting cart updates (direct)...');
                
                // Update cart count in header
                updateCartCount();
                console.log('✅ Cart count update initiated');
                
                // Update cart sidebar content
                updateCartSidebarContent();
                console.log('✅ Cart sidebar update initiated');
                
                if (typeof updateCartUI === 'function') {
                    updateCartUI();
                }
            },
            error: function(xhr, status, error) {
                console.error('Add to cart error:', error);
                
                const response = xhr.responseJSON;
                if (response && response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }
                
                let errorMessage = 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng';
                if (response && response.message) {
                    errorMessage = response.message;
                }
                
                showError(errorMessage);
            },
            complete: function() {
                // Reset processing flag
                isProcessing = false;
            }
        });
    }

    // Helper functions
    function getColorCode(colorName) {
        const colorMap = {
            'đỏ': '#FF0000',
            'red': '#FF0000',
            'xanh': '#0000FF',
            'blue': '#0000FF',
            'vàng': '#FFFF00',
            'yellow': '#FFFF00',
            'xanh lá': '#008000',
            'green': '#008000',
            'đen': '#000000',
            'black': '#000000',
            'trắng': '#FFFFFF',
            'white': '#FFFFFF',
            'nâu': '#A52A2A',
            'brown': '#A52A2A',
            'hồng': '#FFC0CB',
            'pink': '#FFC0CB',
            'cam': '#FFA500',
            'orange': '#FFA500',
            'tím': '#800080',
            'purple': '#800080',
            'xám': '#808080',
            'gray': '#808080',
            'grey': '#808080',
            'be': '#F5F5DC',
            'beige': '#F5F5DC'
        };

        return colorMap[colorName.toLowerCase()] || '#' + Math.floor(Math.random()*16777215).toString(16);
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }

    // Toast messages are now handled by the global toast system

    // Update cart count in header
    function updateCartCount() {
        $.ajax({
            url: '/cart/count',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const count = parseInt(response.count) || 0;
                    $('#cart-count').text(count);
                    
                    // Add bounce animation effect
                    $('#cart-count').addClass('cart-count-bounce');
                    setTimeout(() => {
                        $('#cart-count').removeClass('cart-count-bounce');
                    }, 600);
                    
                    console.log('Cart count updated to:', count);
                }
            },
            error: function(xhr, status, error) {
                console.log('Failed to update cart count:', error);
            }
        });
    }
    
    // Update cart sidebar content immediately
    function updateCartSidebarContent() {
        console.log('🔄 Refreshing cart sidebar content...');
        
        $.ajax({
            url: '/cart/sidebar-content',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('✅ Sidebar content updated successfully');
                    
                    // Update sidebar content
                    $('#cart-sidebar-content').html(response.html);
                    
                    // Also update cart count if provided
                    if (response.count !== undefined) {
                        $('#cart-count').text(response.count);
                        console.log('✅ Cart count also updated from sidebar response:', response.count);
                    }
                    
                    // Add update animation
                    $('#cart-sidebar-content').addClass('sidebar-updated');
                    setTimeout(() => {
                        $('#cart-sidebar-content').removeClass('sidebar-updated');
                    }, 1000);
                } else {
                    console.error('❌ Sidebar update failed:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Failed to refresh cart sidebar:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }
    
    // Make functions available globally for other scripts
    window.updateCartCount = updateCartCount;
    window.updateCartSidebarContent = updateCartSidebarContent;
});