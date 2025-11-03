/**
 * Shop Page JavaScript
 * Handles view toggle, price filtering, and other shop functionality
 */

// Sort function with AJAX
function updateSort(sortValue) {
    // Update hidden input in filter form
    let $sortInput = $('#filter-form input[name="sort"]');
    if ($sortInput.length === 0) {
        // Create hidden input if not exists
        $sortInput = $('<input>').attr({
            type: 'hidden',
            name: 'sort',
            value: sortValue
        });
        $('#filter-form').append($sortInput);
    } else {
        $sortInput.val(sortValue);
    }

    // Check if AJAX filter is available
    if (window.shopAjaxFilter && typeof window.shopAjaxFilter.applyFilters === 'function') {
        console.log('🔄 Applying sort via AJAX:', sortValue);
        // Apply filters via AJAX
        window.shopAjaxFilter.applyFilters();
    } else {
        // Fallback to page reload
        console.log('⚠️ AJAX not available, reloading page');
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    }
}

// Change items per page
function changePerPage(perPageValue) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPageValue);
    url.searchParams.delete('page'); // Reset to first page

    // Add loading state
    const selectElement = document.getElementById('per-page');
    if (selectElement) {
        const originalHTML = selectElement.innerHTML;
        selectElement.innerHTML = '<option>Đang tải...</option>';
        selectElement.disabled = true;
    }

    window.location.href = url.toString();
}

// Jump to specific page
function jumpToPage() {
    const jumpInput = document.getElementById('jump-page');
    const pageNumber = parseInt(jumpInput.value);

    if (!pageNumber || pageNumber < 1) {
        showAlert('Vui lòng nhập số trang hợp lệ', 'warning');
        jumpInput.focus();
        return;
    }

    const maxPage = parseInt(jumpInput.getAttribute('max'));
    if (pageNumber > maxPage) {
        showAlert(`Số trang không thể lớn hơn ${maxPage}`, 'warning');
        jumpInput.focus();
        return;
    }

    const url = new URL(window.location.href);
    url.searchParams.set('page', pageNumber);

    // Add loading state
    const jumpBtn = document.querySelector('.jump-btn');
    if (jumpBtn) {
        const originalHTML = jumpBtn.innerHTML;
        jumpBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        jumpBtn.disabled = true;
        jumpInput.disabled = true;
    }

    window.location.href = url.toString();
}

// View toggle functionality
// View Toggle Functions
function initViewToggle() {
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');

    // Initially show only grid button and grid view
    updateViewButtons('grid');

    // Grid view button click - switch to list
    if (gridBtn) {
        gridBtn.addEventListener('click', function() {
            switchToView('list');
        });
    }

    // List view button click - switch to grid
    if (listBtn) {
        listBtn.addEventListener('click', function() {
            switchToView('grid');
        });
    }
}

function switchToView(viewType) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');

    if (viewType === 'grid') {
        // Show grid view, hide list view
        if (gridView) gridView.style.display = 'block';
        if (listView) listView.style.display = 'none';
        updateViewButtons('grid');
    } else {
        // Show list view, hide grid view
        if (listView) listView.style.display = 'block';
        if (gridView) gridView.style.display = 'none';
        updateViewButtons('list');
    }
}

function updateViewButtons(activeView) {
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');

    if (activeView === 'grid') {
        // Show only grid button as active
        if (gridBtn) {
            gridBtn.style.display = 'inline-flex';
            gridBtn.classList.add('active');
        }
        if (listBtn) {
            listBtn.style.display = 'none';
            listBtn.classList.remove('active');
        }
    } else {
        // Show only list button as active
        if (listBtn) {
            listBtn.style.display = 'inline-flex';
            listBtn.classList.add('active');
        }
        if (gridBtn) {
            gridBtn.style.display = 'none';
            gridBtn.classList.remove('active');
        }
    }
}

// Price input formatting and validation
function initPriceFilter() {
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');
    const priceForm = document.querySelector('.price-filter-form');

    if (!minPriceInput || !maxPriceInput || !priceForm) {
        return; // Elements not found, exit gracefully
    }

    // Format numbers on input
    function formatPriceInput(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value) {
                e.target.value = value;
            }
        });
    }

    formatPriceInput(minPriceInput);
    formatPriceInput(maxPriceInput);

    // Validate price range before submit
    priceForm.addEventListener('submit', function(e) {
        const minVal = parseInt(minPriceInput.value) || 0;
        const maxVal = parseInt(maxPriceInput.value) || 0;

        // Check for maximum price limit
        if (minVal > 1000000000 || maxVal > 1000000000) {
            e.preventDefault();
            showAlert('Giá không thể vượt quá 1.000.000.000 VNĐ', 'warning');
            return false;
        }

        // Check for logical price range
        if (minVal > 0 && maxVal > 0 && minVal > maxVal) {
            e.preventDefault();
            showAlert('Giá tối thiểu không thể lớn hơn giá tối đa', 'warning');
            return false;
        }
    });
}

// Enhanced alert function - Now using Toast notifications
function showAlert(message, type = 'info') {
    // Use toast notifications if available
    if (typeof window.toastHelper !== 'undefined') {
        switch(type) {
            case 'success':
                window.toastHelper.success(message);
                break;
            case 'error':
                window.toastHelper.error(message);
                break;
            case 'warning':
                window.toastHelper.warning(message);
                break;
            case 'info':
            default:
                window.toastHelper.info(message);
                break;
        }
    } else if (typeof Swal !== 'undefined') {
        Swal.fire({
            text: message,
            icon: type,
            confirmButtonText: 'OK'
        });
    } else {
        alert(message);
    }
}

// Initialize smooth scrolling for pagination
function initPaginationScroll() {
    const paginationLinks = document.querySelectorAll('.page-link:not(.disabled)');

    paginationLinks.forEach(link => {
        if (link.tagName === 'A') {
            link.addEventListener('click', function(e) {
                // Add loading state to pagination
                const paginationWrapper = document.querySelector('.pagination-wrapper');
                if (paginationWrapper) {
                    paginationWrapper.classList.add('pagination-loading');
                }

                // Scroll to top of products section after page change
                setTimeout(() => {
                    const productArea = document.querySelector('.product-area');
                    if (productArea) {
                        productArea.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            });
        }
    });
}

// Initialize pagination enhancements
function initPaginationEnhancements() {
    // Enable Enter key for jump to page
    const jumpInput = document.getElementById('jump-page');
    if (jumpInput) {
        jumpInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                jumpToPage();
            }
        });

        // Auto-select text on focus
        jumpInput.addEventListener('focus', function() {
            this.select();
        });

        // Validate input in real-time
        jumpInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.getAttribute('min'));
            const max = parseInt(this.getAttribute('max'));
            const jumpBtn = document.querySelector('.jump-btn');

            if (value < min || value > max || isNaN(value)) {
                this.style.borderColor = '#dc3545';
                if (jumpBtn) jumpBtn.disabled = true;
            } else {
                this.style.borderColor = '#28a745';
                if (jumpBtn) jumpBtn.disabled = false;
            }
        });
    }

    // Add keyboard navigation for pagination
    document.addEventListener('keydown', function(e) {
        // Only if no input is focused
        if (document.activeElement.tagName === 'INPUT') return;

        const currentPage = document.querySelector('.page-link.active');
        if (!currentPage) return;

        let targetLink = null;

        // Left arrow or 'p' for previous
        if (e.key === 'ArrowLeft' || e.key.toLowerCase() === 'p') {
            const prevLink = document.querySelector('.pagination-container .page-link[href]:not(.first-last-btn)');
            if (prevLink && prevLink.textContent.includes('Trước')) {
                targetLink = prevLink;
            }
        }

        // Right arrow or 'n' for next
        if (e.key === 'ArrowRight' || e.key.toLowerCase() === 'n') {
            const nextLink = document.querySelector('.pagination-container .page-link[href]:not(.first-last-btn)');
            if (nextLink && nextLink.textContent.includes('Tiếp')) {
                targetLink = nextLink;
            }
        }

        // Home key for first page
        if (e.key === 'Home') {
            const firstLink = document.querySelector('.pagination-container .first-last-btn[href]');
            if (firstLink && firstLink.textContent.includes('Đầu')) {
                targetLink = firstLink;
            }
        }

        // End key for last page
        if (e.key === 'End') {
            const lastLink = document.querySelector('.pagination-container .first-last-btn[href]');
            if (lastLink && lastLink.textContent.includes('Cuối')) {
                targetLink = lastLink;
            }
        }

        if (targetLink) {
            e.preventDefault();
            targetLink.click();
        }
    });
}

// Show pagination statistics on load
function showPaginationStats() {
    const paginationSummary = document.querySelector('.pagination-summary');
    if (paginationSummary) {
        // Add a small animation to highlight the stats
        paginationSummary.style.opacity = '0';
        setTimeout(() => {
            paginationSummary.style.transition = 'opacity 0.5s ease';
            paginationSummary.style.opacity = '1';
        }, 100);
    }
}

// Add loading states to buttons
function initLoadingStates() {
    const filterButtons = document.querySelectorAll('.btn-price-filter, .sidebar-search-form .btn');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang tìm...';
            this.disabled = true;

            // Re-enable button after form submission
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 2000);
        });
    });
}

// Initialize tooltips if Bootstrap is available
function initTooltips() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}

// Main initialization function
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initViewToggle();
    initPriceFilter();
    initPaginationScroll();
    initPaginationEnhancements();
    initLoadingStates();
    initTooltips();
    showPaginationStats();
    initFilterInteractions();
    initializeSelectedStates();
    initAutoSubmit();
    initSearchInput();

    // Add fade-in animation to products
    const products = document.querySelectorAll('.product-item');
    products.forEach((product, index) => {
        product.style.opacity = '0';
        product.style.transform = 'translateY(20px)';

        setTimeout(() => {
            product.style.transition = 'all 0.5s ease';
            product.style.opacity = '1';
            product.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add visual feedback for pagination
    const currentUrl = new URL(window.location.href);
    const currentPage = currentUrl.searchParams.get('page') || '1';
    const perPage = currentUrl.searchParams.get('per_page') || '12';

    // Highlight current pagination settings
    const perPageSelect = document.getElementById('per-page');
    if (perPageSelect) {
        perPageSelect.value = perPage;
    }

    // Set jump input placeholder to current page
    const jumpInput = document.getElementById('jump-page');
    if (jumpInput) {
        jumpInput.placeholder = currentPage;
    }

    // Initialize unified filter panel
    initUnifiedFilterPanel();

    console.log(`Shop page initialized successfully - Page: ${currentPage}, Per page: ${perPage}`);
});

// Unified Filter Panel Functions
function initUnifiedFilterPanel() {
    // Initialize collapsible sections
    initCollapsibleSections();

    // Initialize filter interactions
    initFilterInteractions();

    // Auto-submit on radio button changes
    initAutoSubmit();

    // Initialize search input
    initSearchInput();
}

// Collapsible sections
function initCollapsibleSections() {
    const collapsibleHeaders = document.querySelectorAll('.filter-section-header.collapsible');

    collapsibleHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const toggleIcon = this.querySelector('.toggle-icon');

            if (content.classList.contains('collapsed')) {
                content.classList.remove('collapsed');
                this.classList.remove('collapsed');
                content.style.display = 'block';
            } else {
                content.classList.add('collapsed');
                this.classList.add('collapsed');
                content.style.display = 'none';
            }
        });
    });
}

// Filter interactions
function initFilterInteractions() {
    // Price range buttons
    const priceRangeBtns = document.querySelectorAll('.price-range-btn');
    priceRangeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            priceRangeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Size buttons (multiple selection for solid-toggle)
    const sizeBtns = document.querySelectorAll('.size-btn');
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('solid-toggle')) {
                // Multi-select mode
                this.classList.toggle('active');
                updateSelectedSizes();
            } else {
                // Single select mode (traditional)
                sizeBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Color buttons (multiple selection for solid-toggle)
    const colorBtns = document.querySelectorAll('.color-btn');
    colorBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('solid-toggle')) {
                // Multi-select mode
                this.classList.toggle('active');
                updateSelectedColors();
            } else {
                // Single select mode (traditional)
                colorBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Filter option labels
    const filterOptions = document.querySelectorAll('.filter-option');
    filterOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;

                // Update active states
                const allOptions = this.closest('.filter-options').querySelectorAll('.filter-option');
                allOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
}

// Auto-submit on radio changes (DISABLED for AJAX filtering)
function initAutoSubmit() {
    // Disabled - now handled by AJAX filter
    // const radioInputs = document.querySelectorAll('.unified-filter-form input[type="radio"]');
    // radioInputs.forEach(radio => {
    //     radio.addEventListener('change', function() {
    //         // Auto-submit form after a short delay
    //         setTimeout(() => {
    //             document.getElementById('filter-form').submit();
    //         }, 300);
    //     });
    // });
}

// Search input enhancements
function initSearchInput() {
    const searchInput = document.querySelector('.search-input');
    const clearBtn = document.querySelector('.search-clear-btn');

    if (searchInput && clearBtn) {
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                clearBtn.style.display = 'flex';
            } else {
                clearBtn.style.display = 'none';
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filter-form').submit();
            }
        });
    }
}

// Clear search function
function clearSearch() {
    const searchInput = document.querySelector('.search-input');
    const clearBtn = document.querySelector('.search-clear-btn');

    if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
    }

    if (clearBtn) {
        clearBtn.style.display = 'none';
    }
}

// Select price range function
function selectPriceRange(min, max) {
    const minInput = document.getElementById('min_price_filter');
    const maxInput = document.getElementById('max_price_filter');

    if (minInput) {
        minInput.value = min === null ? '' : min;
    }

    if (maxInput) {
        maxInput.value = max === null ? '' : max;
    }

    // Update button states
    const rangeBtns = document.querySelectorAll('.price-range-btn');
    rangeBtns.forEach(btn => btn.classList.remove('active'));
    if (event && event.target) {
        event.target.classList.add('active');
    }

    // Trigger filter immediately via AJAX
    if (window.shopAjaxFilter && typeof window.shopAjaxFilter.applyFilters === 'function') {
        setTimeout(() => {
            window.shopAjaxFilter.applyFilters();
        }, 200);
    }
}

// Remove individual filter
function removeFilter(filterType) {
    const form = document.getElementById('filter-form');

    // Clear specific filter inputs
    switch(filterType) {
        case 'search':
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) searchInput.value = '';
            break;
        case 'category':
            const allCategoryRadio = document.querySelector('input[name="category"][value=""]');
            if (allCategoryRadio) allCategoryRadio.checked = true;
            break;
        case 'brand':
            const allBrandRadio = document.querySelector('input[name="brand"][value=""]');
            if (allBrandRadio) allBrandRadio.checked = true;
            break;
        case 'price':
            const minPriceInput = document.querySelector('input[name="min_price"]');
            const maxPriceInput = document.querySelector('input[name="max_price"]');
            if (minPriceInput) minPriceInput.value = '';
            if (maxPriceInput) maxPriceInput.value = '';
            break;
    }

    // Apply filters via AJAX
    if (window.shopAjaxFilter && typeof window.shopAjaxFilter.applyFilters === 'function') {
        window.shopAjaxFilter.applyFilters();
    } else {
        // Fallback to page reload if AJAX not available
        form.submit();
    }
}

// Update selected sizes for multi-select
function updateSelectedSizes() {
    const selectedSizes = [];
    const activeSizeBtns = document.querySelectorAll('.size-btn.solid-toggle.active');

    activeSizeBtns.forEach(btn => {
        const size = btn.getAttribute('data-size') || btn.textContent.trim();
        selectedSizes.push(size);
    });

    // Update or create hidden input for sizes
    let sizesInput = document.querySelector('input[name="sizes"]');
    if (!sizesInput) {
        sizesInput = document.createElement('input');
        sizesInput.type = 'hidden';
        sizesInput.name = 'sizes';
        const form = document.getElementById('filter-form') || document.querySelector('form');
        if (form) form.appendChild(sizesInput);
    }

    sizesInput.value = selectedSizes.join(',');

    console.log('Selected sizes:', selectedSizes);

    // Update selection counter
    updateSelectionCounter('size', selectedSizes.length);
    updateSelectionSummary();
}

// Update selected colors for multi-select
function updateSelectedColors() {
    const selectedColors = [];
    const activeColorBtns = document.querySelectorAll('.color-btn.solid-toggle.active');

    activeColorBtns.forEach(btn => {
        const color = btn.getAttribute('data-color') || btn.textContent.trim();
        selectedColors.push(color);
    });

    // Update or create hidden input for colors
    let colorsInput = document.querySelector('input[name="colors"]');
    if (!colorsInput) {
        colorsInput = document.createElement('input');
        colorsInput.type = 'hidden';
        colorsInput.name = 'colors';
        const form = document.getElementById('filter-form') || document.querySelector('form');
        if (form) form.appendChild(colorsInput);
    }

    colorsInput.value = selectedColors.join(',');

    console.log('Selected colors:', selectedColors);

    // Update selection counter
    updateSelectionCounter('color', selectedColors.length);
    updateSelectionSummary();
}

// Initialize selected states on page load
function initializeSelectedStates() {
    // Initialize from URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    // Initialize selected sizes
    const selectedSizes = urlParams.get('sizes');
    if (selectedSizes) {
        const sizesArray = selectedSizes.split(',');
        sizesArray.forEach(size => {
            const sizeBtn = document.querySelector(`[data-size="${size}"], .size-btn.solid-toggle:contains("${size}")`);
            if (sizeBtn) sizeBtn.classList.add('active');
        });
    }

    // Initialize selected colors
    const selectedColors = urlParams.get('colors');
    if (selectedColors) {
        const colorsArray = selectedColors.split(',');
        colorsArray.forEach(color => {
            const colorBtn = document.querySelector(`[data-color="${color}"], .color-btn.solid-toggle:contains("${color}")`);
            if (colorBtn) colorBtn.classList.add('active');
        });
    }
}

// Update selection counter
function updateSelectionCounter(type, count) {
    const section = document.querySelector(`[data-filter-type="${type}"]`);
    if (section) {
        if (count > 0) {
            section.classList.add('has-selections');
            section.setAttribute('data-count', count);
        } else {
            section.classList.remove('has-selections');
            section.removeAttribute('data-count');
        }
    }
}

// Update selection summary
function updateSelectionSummary() {
    const selectedSizes = document.querySelectorAll('.size-btn.solid-toggle.active').length;
    const selectedColors = document.querySelectorAll('.color-btn.solid-toggle.active').length;

    let summaryText = '';
    if (selectedSizes > 0) {
        summaryText += `${selectedSizes} kích cỡ`;
    }
    if (selectedColors > 0) {
        summaryText += (summaryText ? ', ' : '') + `${selectedColors} màu sắc`;
    }

    const summaryElement = document.querySelector('.selection-summary');
    if (summaryElement) {
        if (summaryText) {
            summaryElement.querySelector('.summary-text').textContent = `Đã chọn: ${summaryText}`;
            summaryElement.classList.add('show');
        } else {
            summaryElement.classList.remove('show');
        }
    }
}

// Clear all selections
function clearAllSelections() {
    document.querySelectorAll('.solid-toggle.active').forEach(btn => {
        btn.classList.remove('active');
    });

    // Clear hidden inputs
    const sizesInput = document.querySelector('input[name="sizes"]');
    const colorsInput = document.querySelector('input[name="colors"]');

    if (sizesInput) sizesInput.value = '';
    if (colorsInput) colorsInput.value = '';

    // Update counters
    updateSelectionCounter('size', 0);
    updateSelectionCounter('color', 0);
    updateSelectionSummary();
}

// Reset all filters
function resetAllFilters() {
    const form = document.getElementById('filter-form');
    if (!form) return;

    // Reset search
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) searchInput.value = '';

    // Reset category
    const allCategoryRadio = document.querySelector('input[name="category"][value=""]');
    if (allCategoryRadio) allCategoryRadio.checked = true;

    // Reset brand
    const allBrandRadio = document.querySelector('input[name="brand"][value=""]');
    if (allBrandRadio) allBrandRadio.checked = true;

    // Reset price
    const minPriceInput = document.querySelector('input[name="min_price"]');
    const maxPriceInput = document.querySelector('input[name="max_price"]');
    if (minPriceInput) minPriceInput.value = '';
    if (maxPriceInput) maxPriceInput.value = '';

    // Reset sizes and colors
    document.querySelectorAll('.solid-toggle.active').forEach(btn => {
        btn.classList.remove('active');
    });
    const sizesInput = document.querySelector('input[name="sizes"]');
    const colorsInput = document.querySelector('input[name="colors"]');
    if (sizesInput) sizesInput.value = '';
    if (colorsInput) colorsInput.value = '';

    // Apply filters via AJAX
    if (window.shopAjaxFilter && typeof window.shopAjaxFilter.applyFilters === 'function') {
        window.shopAjaxFilter.applyFilters();
    } else {
        // Fallback - redirect to clean URL
        const url = new URL(window.location.origin + window.location.pathname);
        const currentUrl = new URL(window.location.href);

        // Keep only sort and per_page if they exist
        if (currentUrl.searchParams.get('sort')) {
            url.searchParams.set('sort', currentUrl.searchParams.get('sort'));
        }
        if (currentUrl.searchParams.get('per_page')) {
            url.searchParams.set('per_page', currentUrl.searchParams.get('per_page'));
        }

        window.location.href = url.toString();
    }
}

/**
 * Toggle Show More / Show Less for collapsible filter items
 */
function toggleShowMore(button) {
    const filterContent = button.closest('.filter-content');
    const collapsibleItems = filterContent.querySelector('.collapsible-items');
    const icon = button.querySelector('i');
    const text = button.querySelector('.show-more-text');

    if (!collapsibleItems) return;

    // Toggle expanded class
    const isExpanded = collapsibleItems.classList.contains('expanded');

    if (isExpanded) {
        // Collapse
        collapsibleItems.classList.remove('expanded');
        button.classList.remove('expanded');
        text.textContent = 'Xem thêm';
        icon.style.transform = 'rotate(0deg)';
    } else {
        // Expand
        collapsibleItems.classList.add('expanded');
        button.classList.add('expanded');
        text.textContent = 'Thu gọn';
        icon.style.transform = 'rotate(180deg)';
    }
}

