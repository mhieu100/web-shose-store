// Force AJAX Only - No Page Reloads

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚫 Force AJAX Only mode activated');
    
    // Completely disable all form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('🚫 Form submission blocked');
            return false;
        });
    });
    
    // Disable all links that might cause navigation to shop
    const shopLinks = document.querySelectorAll('a[href*="/shop"]');
    shopLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('🚫 Shop link blocked, using AJAX instead');
            
            const url = new URL(this.href);
            const params = url.searchParams;
            
            // Set form values based on URL
            if (params.get('category')) {
                const categoryRadio = document.querySelector(`input[name="category"][value="${params.get('category')}"]`);
                if (categoryRadio) categoryRadio.checked = true;
            }
            
            if (params.get('brand')) {
                const brandRadio = document.querySelector(`input[name="brand"][value="${params.get('brand')}"]`);
                if (brandRadio) brandRadio.checked = true;
            }
            
            // Trigger AJAX search
            performAjaxSearch();
            return false;
        });
    });
    
    // Force override all input changes to use AJAX
    const filterInputs = document.querySelectorAll('#filter-form input');
    filterInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('🎯 Input changed, using AJAX:', this.name, '=', this.value);
            performAjaxSearch();
            return false;
        });
        
        if (input.type === 'text' || input.type === 'search') {
            input.addEventListener('input', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('🎯 Text input, using AJAX:', this.value);
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    performAjaxSearch();
                }, 300);
                return false;
            });
            
            // Block Enter key
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🚫 Enter key blocked, using AJAX instead');
                    clearTimeout(this.searchTimeout);
                    performAjaxSearch();
                    return false;
                }
            });
        }
    });
    
    // Override all button clicks
    const buttons = document.querySelectorAll('button[onclick], .price-range-btn');
    buttons.forEach(button => {
        // Remove onclick attribute
        button.removeAttribute('onclick');
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('🎯 Button clicked, using AJAX');
            
            // Handle price range buttons
            if (this.classList.contains('price-range-btn')) {
                const onclickValue = this.getAttribute('data-onclick') || this.textContent;
                console.log('🎯 Price range button:', onclickValue);
                
                // Parse price range from button
                if (onclickValue.includes('null')) {
                    document.getElementById('min_price_filter').value = '';
                    document.getElementById('max_price_filter').value = '';
                } else if (onclickValue.includes('<500k')) {
                    document.getElementById('min_price_filter').value = '';
                    document.getElementById('max_price_filter').value = '500000';
                } else if (onclickValue.includes('500k-1tr')) {
                    document.getElementById('min_price_filter').value = '500000';
                    document.getElementById('max_price_filter').value = '1000000';
                } else if (onclickValue.includes('1tr-2tr')) {
                    document.getElementById('min_price_filter').value = '1000000';
                    document.getElementById('max_price_filter').value = '2000000';
                } else if (onclickValue.includes('2tr-5tr')) {
                    document.getElementById('min_price_filter').value = '2000000';
                    document.getElementById('max_price_filter').value = '5000000';
                } else if (onclickValue.includes('>5tr')) {
                    document.getElementById('min_price_filter').value = '5000000';
                    document.getElementById('max_price_filter').value = '';
                }
                
                performAjaxSearch();
            }
            
            return false;
        });
    });
    
    console.log('✅ All form submissions and links have been intercepted');
});

// Simplified AJAX search function
function performAjaxSearch() {
    console.log('📡 Performing AJAX search...');
    
    const form = document.getElementById('filter-form');
    if (!form) {
        console.error('❌ Filter form not found');
        return;
    }
    
    // Show loading
    const productGrid = document.querySelector('#grid-view .row');
    if (productGrid) {
        productGrid.style.opacity = '0.5';
        productGrid.innerHTML = '<div class="col-12 text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Đang tìm kiếm...</div>';
    }
    
    // Get form data
    const formData = new FormData(form);
    const params = new URLSearchParams();
    
    // Add only non-empty values
    for (let [key, value] of formData.entries()) {
        if (value && value.trim() !== '' && value !== '0') {
            params.append(key, value);
        }
    }
    
    // Add AJAX flag
    params.append('ajax', '1');
    
    // Make request
    const url = `${window.location.pathname}?${params.toString()}`;
    
    console.log('📡 Making request to:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('📦 Response status:', response.status);
        console.log('📦 Response headers:', response.headers.get('content-type'));
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            console.warn('⚠️ Response is not JSON, probably HTML page');
            throw new Error('Server returned HTML instead of JSON - AJAX not working');
        }
    })
    .then(data => {
        console.log('✅ AJAX Success:', data);
        
        // Update grid
        if (productGrid && data.products_grid_html) {
            productGrid.style.opacity = '1';
            productGrid.innerHTML = data.products_grid_html;
        }
        
        // Update list view
        const listGrid = document.querySelector('#list-view .row');
        if (listGrid && data.products_list_html) {
            listGrid.innerHTML = data.products_list_html;
        }
        
        // Update pagination
        const pagination = document.querySelector('.pagination-wrapper');
        if (pagination && data.pagination_html) {
            pagination.innerHTML = data.pagination_html;
        }
        
        // Update URL
        history.pushState(null, '', url.replace('&ajax=1', ''));
        
        // Reinitialize components after AJAX update
        setTimeout(() => {
            if (typeof reinitializeComponents === 'function') {
                reinitializeComponents();
            } else {
                console.warn('⚠️ reinitializeComponents not defined yet');
            }
        }, 100);
        
        console.log('🎉 AJAX update completed');
    })
    .catch(error => {
        console.error('❌ AJAX Error:', error);
        
        // Fallback: show error message
        if (productGrid) {
            productGrid.style.opacity = '1';
            productGrid.innerHTML = '<div class="col-12 text-center p-5 text-danger"><i class="fa fa-exclamation-triangle fa-2x"></i><br>Lỗi: ' + error.message + '</div>';
        }
    });
}

// Reinitialize components after AJAX update
function reinitializeComponents() {
    console.log('🔄 Reinitializing components...');
    
    try {
        // Reinitialize cart buttons
        const cartButtons = document.querySelectorAll('.add-to-cart');
        cartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('🛒 Add to cart clicked for product:', this.dataset.productId);
                
                // Trigger add to cart functionality if it exists
                if (window.addToCart) {
                    window.addToCart(this);
                } else if (window.handleAddToCart) {
                    window.handleAddToCart(this);
                }
                
                return false;
            });
        });
        
        // Reinitialize wishlist buttons
        const wishlistButtons = document.querySelectorAll('.btn-product-wishlist');
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('💝 Wishlist clicked for product:', this.dataset.productId);
                
                // Trigger wishlist functionality if it exists
                if (window.toggleWishlist) {
                    window.toggleWishlist(this);
                } else if (window.handleWishlist) {
                    window.handleWishlist(this);
                }
                
                return false;
            });
        });
        
        // Reinitialize product links to prevent navigation
        const productLinks = document.querySelectorAll('.product-item a');
        productLinks.forEach(link => {
            if (link.href && link.href.includes('/product/')) {
                // Keep product links working normally
                // Don't prevent default for product detail pages
            } else if (link.href && link.href.includes('/shop')) {
                // Prevent shop category links from reloading page
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('🔗 Shop link intercepted:', this.href);
                    return false;
                });
            }
        });
        
        // Reinitialize product hover effects
        const productItems = document.querySelectorAll('.product-item');
        productItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Reinitialize any image lazy loading
        const images = document.querySelectorAll('.product-item img');
        images.forEach(img => {
            if (!img.complete) {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
            }
        });
        
        // Reinitialize quick view buttons
        const quickViewButtons = document.querySelectorAll('.btn-product-quick-view-open');
        quickViewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('👁 Quick view clicked');
                
                // Trigger quick view if it exists
                if (window.openQuickView) {
                    window.openQuickView(this);
                }
                
                return false;
            });
        });
        
        // Reinitialize any other custom components
        if (window.initializeProductInteractions) {
            window.initializeProductInteractions();
        }
        
        if (window.initializeCartButtons) {
            window.initializeCartButtons();
        }
        
        if (window.initializeWishlistButtons) {
            window.initializeWishlistButtons();
        }
        
        // Trigger custom event for other scripts to listen
        const event = new CustomEvent('ajaxProductsUpdated', {
            detail: { 
                timestamp: Date.now(),
                productsCount: document.querySelectorAll('.product-item').length 
            }
        });
        document.dispatchEvent(event);
        
        console.log('✅ Components reinitialized successfully');
        
    } catch (error) {
        console.error('❌ Error reinitializing components:', error);
    }
}

// Export for global access
window.performAjaxSearch = performAjaxSearch;
window.reinitializeComponents = reinitializeComponents;