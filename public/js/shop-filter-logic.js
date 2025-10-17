// Shop Filter and Search Logic

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔍 Shop filter logic initialized');
    
    // Initialize all filter components
    initializeFilters();
    initializeSearch();
    initializePriceRange();
    initializeSortAndView();
    initializePagination();
    
    // Restore filter states from URL
    restoreFilterStates();
});

// === FILTER INITIALIZATION ===
function initializeFilters() {
    const filterForm = document.getElementById('filter-form');
    if (!filterForm) {
        console.warn('Filter form not found');
        return;
    }
    
    // Auto-submit form when filters change (radio buttons)
    const radioInputs = filterForm.querySelectorAll('input[type="radio"]');
    radioInputs.forEach(input => {
        input.addEventListener('change', function() {
            console.log('Filter changed:', this.name, '=', this.value);
            
            // Clean empty fields before submit
            cleanEmptyFormFields(filterForm);
            
            // Show loading immediately
            showLoadingOverlay();
            
            // Submit form directly
            setTimeout(() => {
                filterForm.submit();
            }, 50);
        });
    });
    
    // Handle checkbox inputs differently
    const checkboxInputs = filterForm.querySelectorAll('input[type="checkbox"]');
    checkboxInputs.forEach(input => {
        input.addEventListener('change', function() {
            console.log('Checkbox changed:', this.name, '=', this.checked);
            setTimeout(() => {
                submitFilters();
            }, 100);
        });
    });
    
    // Collapsible filter sections
    initializeCollapsibleSections();
    
    // Size and color filter toggles
    initializeSizeColorFilters();
    
    // Set initial active states for filter options
    updateActiveFilterStates();
}

function initializeCollapsibleSections() {
    const collapsibleHeaders = document.querySelectorAll('.filter-section-header.collapsible');
    
    collapsibleHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const content = document.getElementById(targetId);
            const icon = this.querySelector('.toggle-icon');
            
            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                this.classList.add('expanded');
            } else {
                content.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                this.classList.remove('expanded');
            }
        });
    });
}

function initializeSizeColorFilters() {
    // Size filter buttons
    const sizeButtons = document.querySelectorAll('.size-btn');
    sizeButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('active');
            updateSelectedSizes();
        });
    });
    
    // Color filter buttons
    const colorButtons = document.querySelectorAll('.color-btn');
    colorButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('active');
            updateSelectedColors();
        });
    });
}

// === SEARCH FUNCTIONALITY ===
function initializeSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    const searchClearBtn = document.querySelector('.search-clear-btn');
    let searchTimeout;
    
    if (searchInput) {
        // Auto search with debounce
        searchInput.addEventListener('input', function() {
            const clearBtn = document.querySelector('.search-clear-btn');
            if (this.value.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
            
            // Debounce search
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    submitFilters();
                }
            }, 500);
        });
        
        // Enter key submit
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                submitFilters();
            }
        });
    }
    
    if (searchClearBtn) {
        searchClearBtn.addEventListener('click', clearSearch);
    }
}

function clearSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    const clearBtn = document.querySelector('.search-clear-btn');
    
    if (searchInput) {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        submitFilters();
    }
}

// === PRICE RANGE FUNCTIONALITY ===
function initializePriceRange() {
    // Quick price range buttons
    const priceRangeButtons = document.querySelectorAll('.price-range-btn');
    priceRangeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            priceRangeButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
        });
    });
    
    // Custom price inputs
    const minPriceInput = document.getElementById('min_price_filter');
    const maxPriceInput = document.getElementById('max_price_filter');
    let priceTimeout;
    
    [minPriceInput, maxPriceInput].forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                // Validate price range
                validatePriceRange();
                
                // Auto-submit with debounce
                clearTimeout(priceTimeout);
                priceTimeout = setTimeout(() => {
                    submitFilters();
                }, 800);
            });
        }
    });
}

function selectPriceRange(min, max) {
    const minInput = document.getElementById('min_price_filter');
    const maxInput = document.getElementById('max_price_filter');
    
    if (minInput) minInput.value = min || '';
    if (maxInput) maxInput.value = max || '';
    
    // Submit filters
    setTimeout(() => {
        submitFilters();
    }, 100);
}

function validatePriceRange() {
    const minInput = document.getElementById('min_price_filter');
    const maxInput = document.getElementById('max_price_filter');
    
    if (minInput && maxInput) {
        const minVal = parseInt(minInput.value) || 0;
        const maxVal = parseInt(maxInput.value) || 0;
        
        // Ensure min is not greater than max
        if (minVal > 0 && maxVal > 0 && minVal >= maxVal) {
            maxInput.value = minVal + 100000; // Add 100k to max
        }
        
        // Remove active class from quick range buttons when custom values are entered
        if (minInput.value || maxInput.value) {
            document.querySelectorAll('.price-range-btn').forEach(btn => {
                btn.classList.remove('active');
            });
        }
    }
}

// === SORTING AND VIEW FUNCTIONALITY ===
function initializeSortAndView() {
    // Sort dropdown
    const sortSelect = document.querySelector('.shop-sort .form-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('sort', this.value);
            currentUrl.searchParams.delete('page'); // Reset to first page
            
            showLoadingOverlay();
            window.location.href = currentUrl.toString();
        });
    }
    
    // View toggle (Grid/List)
    const viewToggleButtons = document.querySelectorAll('.product-nav .nav-link');
    viewToggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all buttons
            viewToggleButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Toggle view
            const isGridView = this.id === 'nav-grid-tab';
            toggleProductView(isGridView);
            
            // Save preference
            localStorage.setItem('shop_view_preference', isGridView ? 'grid' : 'list');
        });
    });
    
    // Restore view preference
    const savedView = localStorage.getItem('shop_view_preference') || 'grid';
    toggleProductView(savedView === 'grid');
    
    // Update active button
    const targetButton = savedView === 'grid' 
        ? document.getElementById('nav-grid-tab')
        : document.getElementById('nav-list-tab');
    if (targetButton) {
        viewToggleButtons.forEach(btn => btn.classList.remove('active'));
        targetButton.classList.add('active');
    }
}

function toggleProductView(isGridView) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    
    if (gridView && listView) {
        if (isGridView) {
            gridView.style.display = 'block';
            listView.style.display = 'none';
        } else {
            gridView.style.display = 'none';
            listView.style.display = 'block';
        }
    }
}

// === PAGINATION FUNCTIONALITY ===
function initializePagination() {
    // Per page selector
    const perPageSelect = document.querySelector('.per-page-select');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            changePerPage(this.value);
        });
    }
    
    // Jump to page functionality
    const jumpInput = document.getElementById('jump-page');
    const jumpBtn = document.querySelector('.jump-btn');
    
    if (jumpInput && jumpBtn) {
        jumpBtn.addEventListener('click', jumpToPage);
        
        jumpInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                jumpToPage();
            }
        });
    }
}

function changePerPage(perPage) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('per_page', perPage);
    currentUrl.searchParams.delete('page'); // Reset to first page
    
    showLoadingOverlay();
    window.location.href = currentUrl.toString();
}

function jumpToPage() {
    const jumpInput = document.getElementById('jump-page');
    const page = parseInt(jumpInput.value);
    const maxPage = parseInt(jumpInput.getAttribute('max'));
    
    if (page && page >= 1 && page <= maxPage) {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('page', page);
        
        showLoadingOverlay();
        window.location.href = currentUrl.toString();
    } else {
        showToast('Số trang không hợp lệ', 'error');
        jumpInput.value = '';
    }
}

// === CORE FILTER SUBMISSION ===
function submitFilters() {
    const form = document.getElementById('filter-form');
    if (!form) return;
    
    // Clean empty values before submit
    cleanEmptyFormFields(form);
    
    // Show loading state
    showLoadingOverlay();
    
    // Simply submit the form - let browser handle it naturally
    form.submit();
}

function cleanEmptyFormFields(form) {
    // Clean text, number, and search inputs
    const inputs = form.querySelectorAll('input[type="text"], input[type="number"], input[type="search"]');
    inputs.forEach(input => {
        const value = input.value || '';
        const isEmpty = !value || value.trim() === '' || value === '0';
        
        if (isEmpty) {
            // Temporarily remove name attribute so field won't be submitted
            if (input.hasAttribute('name')) {
                input.setAttribute('data-original-name', input.getAttribute('name'));
                input.removeAttribute('name');
                console.log(`🧹 Removing empty field: ${input.getAttribute('data-original-name')} = "${value}"`);
            }
        }
    });
    
    // Clean radio buttons that have empty values (when "Tất cả" is selected)
    const radioInputs = form.querySelectorAll('input[type="radio"]:checked');
    radioInputs.forEach(input => {
        if (!input.value || input.value.trim() === '') {
            // Temporarily remove name attribute so field won't be submitted
            if (input.hasAttribute('name')) {
                input.setAttribute('data-original-name', input.getAttribute('name'));
                input.removeAttribute('name');
                console.log(`🧹 Removing empty radio: ${input.getAttribute('data-original-name')} = "${input.value}"`);
            }
        }
    });
    
    // Restore names after a short delay (for debugging)
    setTimeout(() => {
        inputs.forEach(input => {
            if (input.hasAttribute('data-original-name')) {
                input.setAttribute('name', input.getAttribute('data-original-name'));
                input.removeAttribute('data-original-name');
            }
        });
        radioInputs.forEach(input => {
            if (input.hasAttribute('data-original-name')) {
                input.setAttribute('name', input.getAttribute('data-original-name'));
                input.removeAttribute('data-original-name');
            }
        });
    }, 100);
}

// Alternative method for custom URL building (backup)
function submitFiltersCustom() {
    const form = document.getElementById('filter-form');
    if (!form) return;
    
    // Show loading state
    showLoadingOverlay();
    
    // Get all form data
    const formData = new FormData(form);
    const params = new URLSearchParams();
    
    // Add form data to params
    for (let [key, value] of formData.entries()) {
        if (value && value.trim() !== '') {
            params.append(key, value);
        }
    }
    
    // Add selected sizes and colors
    const selectedSizes = getSelectedSizes();
    const selectedColors = getSelectedColors();
    
    if (selectedSizes.length > 0) {
        params.append('sizes', selectedSizes.join(','));
    }
    
    if (selectedColors.length > 0) {
        params.append('colors', selectedColors.join(','));
    }
    
    // Preserve current sort and pagination settings
    const currentUrl = new URL(window.location);
    const sort = currentUrl.searchParams.get('sort');
    const perPage = currentUrl.searchParams.get('per_page');
    
    if (sort) params.append('sort', sort);
    if (perPage) params.append('per_page', perPage);
    
    // Remove page parameter to start from first page
    params.delete('page');
    
    // Navigate to new URL
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    window.location.href = newUrl;
}

// === HELPER FUNCTIONS ===
function getSelectedSizes() {
    const activeSizeButtons = document.querySelectorAll('.size-btn.active');
    return Array.from(activeSizeButtons).map(btn => btn.dataset.size);
}

function getSelectedColors() {
    const activeColorButtons = document.querySelectorAll('.color-btn.active');
    return Array.from(activeColorButtons).map(btn => btn.dataset.color);
}

function updateSelectedSizes() {
    // This function can be extended to update hidden inputs if needed
    console.log('Selected sizes:', getSelectedSizes());
}

function updateSelectedColors() {
    // This function can be extended to update hidden inputs if needed
    console.log('Selected colors:', getSelectedColors());
}

function restoreFilterStates() {
    const currentUrl = new URL(window.location);
    
    // Restore size selections
    const sizes = currentUrl.searchParams.get('sizes');
    if (sizes) {
        const sizeArray = sizes.split(',');
        sizeArray.forEach(size => {
            const button = document.querySelector(`.size-btn[data-size="${size}"]`);
            if (button) button.classList.add('active');
        });
    }
    
    // Restore color selections
    const colors = currentUrl.searchParams.get('colors');
    if (colors) {
        const colorArray = colors.split(',');
        colorArray.forEach(color => {
            const button = document.querySelector(`.color-btn[data-color="${color}"]`);
            if (button) button.classList.add('active');
        });
    }
    
    // Update price range button states
    const minPrice = currentUrl.searchParams.get('min_price');
    const maxPrice = currentUrl.searchParams.get('max_price');
    
    if (minPrice || maxPrice) {
        // Find matching quick range button
        const priceButtons = document.querySelectorAll('.price-range-btn');
        priceButtons.forEach(button => {
            const onclickValue = button.getAttribute('onclick');
            if (onclickValue && onclickValue.includes(`${minPrice}, ${maxPrice}`)) {
                button.classList.add('active');
            }
        });
    }
}

function clearAllFilters() {
    window.location.href = window.location.pathname;
}

function showLoadingOverlay() {
    // Create loading overlay if it doesn't exist
    let overlay = document.getElementById('loading-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'loading-overlay';
        overlay.innerHTML = `
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <p>Đang tải...</p>
            </div>
        `;
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(2px);
        `;
        
        const content = overlay.querySelector('.loading-content');
        content.style.cssText = `
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        `;
        
        const spinner = overlay.querySelector('.loading-spinner');
        spinner.style.cssText = `
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #eb3e32;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        `;
        
        // Add spinner animation
        if (!document.getElementById('spinner-style')) {
            const style = document.createElement('style');
            style.id = 'spinner-style';
            style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(overlay);
    }
    
    overlay.style.display = 'flex';
}

function hideLoadingOverlay() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function showToast(message, type = 'info') {
    // Reuse the toast function from shop-enhancement.js
    if (window.showToast) {
        window.showToast(message, type);
    } else {
        console.log(`${type.toUpperCase()}: ${message}`);
    }
}

// === UPDATE ACTIVE STATES ===
function updateActiveFilterStates() {
    // Update filter option active states based on current selection
    const filterOptions = document.querySelectorAll('.filter-option');
    filterOptions.forEach(option => {
        const input = option.querySelector('input');
        if (input && input.checked) {
            option.classList.add('active');
        } else {
            option.classList.remove('active');
        }
    });
    
    // Update price range button states
    updatePriceRangeButtons();
    
    // Update filter counters if needed
    updateFilterCounters();
}

function updatePriceRangeButtons() {
    const currentMin = document.getElementById('min_price_filter')?.value || '';
    const currentMax = document.getElementById('max_price_filter')?.value || '';
    
    const priceButtons = document.querySelectorAll('.price-range-btn');
    priceButtons.forEach(button => {
        button.classList.remove('active');
    });
    
    // If no custom price is set, highlight "Tất cả" button
    if (!currentMin && !currentMax) {
        const allButton = document.querySelector('.price-range-btn[onclick*="null, null"]');
        if (allButton) allButton.classList.add('active');
    }
}

function updateFilterCounters() {
    // Count active filters
    const activeFilters = document.querySelectorAll('.filter-option.active').length;
    const activeSizes = document.querySelectorAll('.size-btn.active').length;
    const activeColors = document.querySelectorAll('.color-btn.active').length;
    const activePriceRanges = document.querySelectorAll('.price-range-btn.active').length;
    
    const totalActiveFilters = activeFilters + activeSizes + activeColors + (activePriceRanges > 0 ? 1 : 0);
    
    // Update filter badge if exists
    const filterBadge = document.querySelector('.filter-count-badge');
    if (filterBadge) {
        if (totalActiveFilters > 0) {
            filterBadge.textContent = totalActiveFilters;
            filterBadge.style.display = 'inline-block';
        } else {
            filterBadge.style.display = 'none';
        }
    }
    
    console.log(`Active filters: ${totalActiveFilters}`);
}

// === GLOBAL FUNCTIONS ===
window.selectPriceRange = selectPriceRange;
window.clearSearch = clearSearch;
window.clearAllFilters = clearAllFilters;
window.changePerPage = changePerPage;
window.jumpToPage = jumpToPage;
window.submitFilters = submitFilters;
window.updateActiveFilterStates = updateActiveFilterStates;