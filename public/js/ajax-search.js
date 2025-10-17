// AJAX Search for Shop - No Page Reload

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔍 AJAX Search initialized');
    
    // Disable original filter logic to prevent conflicts
    if (window.submitFilters) {
        console.log('🚫 Disabling original filter logic');
        window.submitFilters = function() {
            console.log('🔄 Redirecting to AJAX search');
            performAjaxSearch();
        };
    }
    
    // Initialize immediately
    initializeAjaxSearch();
    initializeAjaxFilters();
    
    // Force override any conflicting scripts after a delay
    setTimeout(() => {
        console.log('🔄 Force overriding any remaining conflicts');
        
        // Override global functions that might cause page reload
        window.selectPriceRange = function(min, max) {
            console.log('🎯 AJAX Price range selected:', min, max);
            const minInput = document.getElementById('min_price_filter');
            const maxInput = document.getElementById('max_price_filter');
            
            if (minInput) minInput.value = min || '';
            if (maxInput) maxInput.value = max || '';
            
            performAjaxSearch();
        };
        
        window.clearSearch = function() {
            console.log('🎯 AJAX Clear search');
            const searchInput = document.querySelector('input[name="search"]');
            const clearBtn = document.querySelector('.search-clear-btn');
            
            if (searchInput) searchInput.value = '';
            if (clearBtn) clearBtn.style.display = 'none';
            
            performAjaxSearch();
        };
        
        window.clearAllFilters = function() {
            console.log('🎯 AJAX Clear all filters');
            const form = document.getElementById('filter-form');
            if (form) {
                form.reset();
                performAjaxSearch();
            }
        };
        
        window.changePerPage = function(perPage) {
            console.log('🎯 AJAX Change per page:', perPage);
            performAjaxSearch();
        };
        
        window.jumpToPage = function() {
            console.log('🎯 AJAX Jump to page');
            performAjaxPagination(document.getElementById('jump-page').value);
        };
    }, 100);
});

function initializeAjaxSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    const filterForm = document.getElementById('filter-form');
    
    if (!searchInput || !filterForm) {
        console.warn('Search input or filter form not found');
        return;
    }
    
    let searchTimeout;
    
    // Override search input behavior
    searchInput.addEventListener('input', function(e) {
        const query = this.value.trim();
        
        // Show/hide clear button
        const clearBtn = document.querySelector('.search-clear-btn');
        if (clearBtn) {
            clearBtn.style.display = query.length > 0 ? 'block' : 'none';
        }
        
        // Debounce search
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (query.length >= 2 || query.length === 0) {
                performAjaxSearch();
            }
        }, 300);
    });
    
    // Prevent form submission for search
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(searchTimeout);
            performAjaxSearch();
        }
    });
}

function initializeAjaxFilters() {
    const filterForm = document.getElementById('filter-form');
    if (!filterForm) return;
    
    // Override radio button behavior for AJAX
    const radioInputs = filterForm.querySelectorAll('input[type="radio"]');
    radioInputs.forEach(input => {
        // Remove existing event listeners by cloning
        const newInput = input.cloneNode(true);
        input.parentNode.replaceChild(newInput, input);
        
        // Add new AJAX listener
        newInput.addEventListener('change', function() {
            console.log('🎯 AJAX Filter changed:', this.name, '=', this.value);
            performAjaxSearch();
        });
    });
    
    // Also disable the original form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('🚫 Form submission prevented, using AJAX instead');
        performAjaxSearch();
    });
    
    // Override price inputs for AJAX
    const priceInputs = filterForm.querySelectorAll('#min_price_filter, #max_price_filter');
    let priceTimeout;
    
    priceInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(priceTimeout);
            priceTimeout = setTimeout(() => {
                performAjaxSearch();
            }, 800);
        });
    });
}

function performAjaxSearch() {
    const filterForm = document.getElementById('filter-form');
    if (!filterForm) return;
    
    // Show loading state
    showAjaxLoading();
    
    // Get form data
    const formData = new FormData(filterForm);
    const params = new URLSearchParams();
    
    // Clean and add form data
    for (let [key, value] of formData.entries()) {
        if (value && value.trim() !== '' && value !== '0') {
            params.append(key, value);
        }
    }
    
    // Add current sort and pagination
    const currentUrl = new URL(window.location);
    const sort = currentUrl.searchParams.get('sort');
    const perPage = currentUrl.searchParams.get('per_page');
    
    if (sort) params.append('sort', sort);
    if (perPage) params.append('per_page', perPage);
    
    // Add AJAX flag
    params.append('ajax', '1');
    
    // Make AJAX request
    const url = `${window.location.pathname}?${params.toString()}`;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('📦 AJAX Response received:', data);
        updateProductGrid(data);
        updatePagination(data);
        updateProductCount(data);
        updateUrl(params);
        hideAjaxLoading();
    })
    .catch(error => {
        console.error('❌ AJAX Error:', error);
        
        // Fallback to traditional form submit
        console.log('🔄 Falling back to form submit...');
        hideAjaxLoading();
        
        // Clean form and submit normally
        cleanEmptyFormFields(filterForm);
        filterForm.submit();
    });
}

function updateProductGrid(data) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    
    if (gridView && data.products_grid_html) {
        gridView.innerHTML = data.products_grid_html;
        
        // Add fade-in animation
        gridView.style.opacity = '0';
        setTimeout(() => {
            gridView.style.transition = 'opacity 0.3s ease';
            gridView.style.opacity = '1';
        }, 50);
    }
    
    if (listView && data.products_list_html) {
        listView.innerHTML = data.products_list_html;
        
        // Add fade-in animation
        listView.style.opacity = '0';
        setTimeout(() => {
            listView.style.transition = 'opacity 0.3s ease';
            listView.style.opacity = '1';
        }, 50);
    }
    
    // Reinitialize product interactions
    reinitializeProductInteractions();
}

function updatePagination(data) {
    const paginationWrapper = document.querySelector('.pagination-wrapper');
    if (paginationWrapper && data.pagination_html) {
        paginationWrapper.innerHTML = data.pagination_html;
        
        // Reinitialize pagination clicks for AJAX
        initializePaginationAjax();
    }
}

function updateProductCount(data) {
    // Update page title
    if (data.page_title) {
        document.title = data.page_title;
    }
    
    // Update breadcrumb if needed
    const breadcrumb = document.querySelector('.breadcrumb-area');
    if (breadcrumb && data.breadcrumb_html) {
        breadcrumb.innerHTML = data.breadcrumb_html;
    }
    
    // Update filter counters
    if (data.total_products !== undefined) {
        console.log(`📊 Updated: ${data.total_products} products found`);
    }
}

function updateUrl(params) {
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    
    // Update URL without page reload
    history.pushState(null, '', newUrl);
    
    console.log('🌐 URL updated:', newUrl);
}

function initializePaginationAjax() {
    const paginationLinks = document.querySelectorAll('.pagination-area a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = new URL(this.href);
            const page = url.searchParams.get('page');
            
            if (page) {
                // Update current form with page number
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.set('page', page);
                
                // Perform AJAX search with pagination
                performAjaxPagination(page);
            }
        });
    });
}

function performAjaxPagination(page) {
    const filterForm = document.getElementById('filter-form');
    if (!filterForm) return;
    
    showAjaxLoading();
    
    // Get current URL parameters
    const currentUrl = new URL(window.location);
    const params = new URLSearchParams(currentUrl.search);
    params.set('page', page);
    params.set('ajax', '1');
    
    const url = `${window.location.pathname}?${params.toString()}`;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateProductGrid(data);
        updatePagination(data);
        updateProductCount(data);
        
        // Update URL
        const newParams = new URLSearchParams(currentUrl.search);
        newParams.set('page', page);
        updateUrl(newParams);
        
        // Scroll to top of products
        const productArea = document.querySelector('.product-area');
        if (productArea) {
            productArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        hideAjaxLoading();
    })
    .catch(error => {
        console.error('❌ Pagination AJAX Error:', error);
        hideAjaxLoading();
        // Fallback to traditional pagination
        window.location.href = url.replace('&ajax=1', '');
    });
}

function reinitializeProductInteractions() {
    // Reinitialize cart buttons
    const cartButtons = document.querySelectorAll('.add-to-cart');
    cartButtons.forEach(button => {
        // Remove existing listeners and add new ones
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        // Add cart functionality (if exists)
        if (window.initializeCartButtons) {
            window.initializeCartButtons();
        }
    });
    
    // Reinitialize wishlist buttons
    const wishlistButtons = document.querySelectorAll('.btn-product-wishlist');
    wishlistButtons.forEach(button => {
        if (window.initializeWishlistButtons) {
            window.initializeWishlistButtons();
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
}

function showAjaxLoading() {
    // Add loading overlay to product grid
    const productGrid = document.querySelector('.tab-content');
    if (productGrid) {
        productGrid.style.position = 'relative';
        productGrid.style.opacity = '0.6';
        productGrid.style.pointerEvents = 'none';
        
        // Add spinner
        let spinner = document.getElementById('ajax-spinner');
        if (!spinner) {
            spinner = document.createElement('div');
            spinner.id = 'ajax-spinner';
            spinner.innerHTML = `
                <div class="ajax-spinner-content">
                    <div class="ajax-spinner"></div>
                    <p>Đang tìm kiếm...</p>
                </div>
            `;
            spinner.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1000;
                background: rgba(255, 255, 255, 0.9);
                padding: 2rem;
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.1);
                text-align: center;
                backdrop-filter: blur(4px);
            `;
            
            const spinnerCss = `
                .ajax-spinner {
                    width: 40px;
                    height: 40px;
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #eb3e32;
                    border-radius: 50%;
                    animation: ajax-spin 1s linear infinite;
                    margin: 0 auto 1rem;
                }
                
                @keyframes ajax-spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                
                .ajax-spinner-content p {
                    margin: 0;
                    color: #495057;
                    font-weight: 500;
                }
            `;
            
            if (!document.getElementById('ajax-spinner-style')) {
                const style = document.createElement('style');
                style.id = 'ajax-spinner-style';
                style.textContent = spinnerCss;
                document.head.appendChild(style);
            }
            
            productGrid.appendChild(spinner);
        }
        
        spinner.style.display = 'block';
    }
}

function hideAjaxLoading() {
    const productGrid = document.querySelector('.tab-content');
    if (productGrid) {
        productGrid.style.opacity = '1';
        productGrid.style.pointerEvents = 'auto';
        
        const spinner = document.getElementById('ajax-spinner');
        if (spinner) {
            spinner.style.display = 'none';
        }
    }
}

// Browser back/forward button support
window.addEventListener('popstate', function(e) {
    console.log('🔄 Browser navigation detected, performing AJAX search...');
    performAjaxSearch();
});

// Utility function to clean form fields (reuse from existing script)
function cleanEmptyFormFields(form) {
    const inputs = form.querySelectorAll('input[type="text"], input[type="number"], input[type="search"]');
    inputs.forEach(input => {
        const value = input.value || '';
        const isEmpty = !value || value.trim() === '' || value === '0';
        
        if (isEmpty && input.hasAttribute('name')) {
            input.setAttribute('data-original-name', input.getAttribute('name'));
            input.removeAttribute('name');
        }
    });
    
    const radioInputs = form.querySelectorAll('input[type="radio"]:checked');
    radioInputs.forEach(input => {
        if ((!input.value || input.value.trim() === '') && input.hasAttribute('name')) {
            input.setAttribute('data-original-name', input.getAttribute('name'));
            input.removeAttribute('name');
        }
    });
    
    // Restore after delay
    setTimeout(() => {
        [...inputs, ...radioInputs].forEach(input => {
            if (input.hasAttribute('data-original-name')) {
                input.setAttribute('name', input.getAttribute('data-original-name'));
                input.removeAttribute('data-original-name');
            }
        });
    }, 100);
}

// Export functions for global access
window.performAjaxSearch = performAjaxSearch;