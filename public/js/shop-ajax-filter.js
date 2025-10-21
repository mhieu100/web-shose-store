/**
 * Shop AJAX Filter với jQuery
 * Lọc sản phẩm real-time không reload trang
 */

(function($) {
    'use strict';

    let filterTimeout = null;
    const DEBOUNCE_DELAY = 500;

    // Khởi tạo AJAX filter
    function initAjaxFilter() {
        const $filterForm = $('#filter-form');

        if (!$filterForm.length) {
            console.error('❌ Không tìm thấy form filter');
            return;
        }

        console.log('✅ Khởi tạo AJAX Filter thành công');

        // Ngăn submit form mặc định
        $filterForm.on('submit', function(e) {
            e.preventDefault();
            console.log('🚫 Form submit prevented');
            applyFilters();
        });

        // Khởi tạo event listeners
        initFilterListeners();
    }

    // Khởi tạo listeners cho các filter
    function initFilterListeners() {
        console.log('🎧 Đang khởi tạo filter listeners...');

        // Radio buttons (Category, Brand) - lọc ngay lập tức
        $(document).on('change', '.unified-filter-form input[type="radio"]', function() {
            const name = $(this).attr('name');
            const value = $(this).val();
            console.log('📻 Radio changed:', name, '=', value);

            // Update active state cho label
            const $label = $(this).closest('label');
            $label.siblings('.filter-option').removeClass('active');
            $label.addClass('active');

            applyFilters();
            updateSelectionSummary();
        });

        // Click trực tiếp vào label (để đảm bảo hoạt động)
        $(document).on('click', '.filter-option.compact', function(e) {
            // Nếu click vào chính input thì bỏ qua (để event change xử lý)
            if ($(e.target).is('input')) {
                return;
            }

            const $radio = $(this).find('input[type="radio"]');
            if ($radio.length) {
                $radio.prop('checked', true).trigger('change');
            }
        });

        // Search input - lọc với debounce
        const $searchInput = $('.search-input');
        if ($searchInput.length) {
            $searchInput.on('input', function() {
                const keyword = $(this).val();
                console.log('🔍 Search input:', keyword);

                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(function() {
                    applyFilters();
                    updateSelectionSummary();
                }, DEBOUNCE_DELAY);
            });

            // Enter key để search ngay
            $searchInput.on('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                clearTimeout(filterTimeout);
                    applyFilters();
                updateSelectionSummary();
                }
            });
        }

        // Price range buttons
        $(document).on('click', '.price-range-btn', function() {
            console.log('💰 Price range clicked');
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function() {
                applyFilters();
                updateSelectionSummary();
            }, 300);
        });

        // Price inputs - lọc với debounce
        $(document).on('input', '.price-input', function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function() {
                applyFilters();
                updateSelectionSummary();
            }, DEBOUNCE_DELAY);
        });

        // Size buttons
        $(document).on('click', '.size-btn.solid-toggle', function() {
            setTimeout(function() {
                applyFilters();
                updateSelectionSummary();
            }, 200);
        });

        // Color buttons
        $(document).on('click', '.color-btn.solid-toggle', function() {
            setTimeout(function() {
                applyFilters();
                updateSelectionSummary();
            }, 200);
        });

        console.log('✅ Filter listeners đã khởi tạo xong');
    }

    // Áp dụng filters
    function applyFilters() {
        console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        console.log('🔄 BẮT ĐẦU LỌC SẢN PHẨM...');

        const $form = $('#filter-form');

        if (!$form.length) {
            console.error('❌ Không tìm thấy form!');
            return;
        }

        // Lấy tất cả dữ liệu form
        const formData = $form.serializeArray();
        const params = {};

        console.log('📋 Dữ liệu form:');
        $.each(formData, function(i, field) {
            if (field.value) {
                params[field.name] = field.value;
                console.log(`  ✓ ${field.name}: ${field.value}`);
            }
        });

        // Thêm indicator AJAX
        params.ajax = '1';

        // Hiển thị loading
        showLoading();

        // Gửi AJAX request
        $.ajax({
            url: '/shop',
            type: 'GET',
            data: params,
            dataType: 'html',
            beforeSend: function() {
                console.log('📤 Đang gửi request...');
                console.log('URL:', '/shop?' + $.param(params));
            },
            success: function(response) {
                console.log('✅ Nhận được response từ server');
                console.log('Response length:', response.length, 'bytes');

                updateProductGrid(response);
                updatePagination(response);
                updateCurrentFiltersBar(response);
                updateURL(params);

                hideLoading();
                scrollToProducts();

                console.log('✅ CẬP NHẬT HOÀN TẤT!');
                console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            },
            error: function(xhr, status, error) {
                console.error('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                console.error('❌ LỖI AJAX!');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
                console.error('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

                hideLoading();
                showErrorMessage('Có lỗi xảy ra khi lọc sản phẩm. Vui lòng thử lại.');
            }
        });
    }

    // Cập nhật product grid
    function updateProductGrid(html) {
        console.log('🔄 Đang cập nhật product grid...');

        // Parse HTML response
        const $html = $('<div>').html(html);

        // Tìm grid view mới
        const $newGridView = $html.find('#grid-view');
        const $currentGridView = $('#grid-view');

        if ($newGridView.length && $currentGridView.length) {
            // Thay thế nội dung
            $currentGridView.html($newGridView.html());
            console.log('✅ Grid view đã cập nhật');
            console.log('Products:', $currentGridView.find('.product-item').length);
        } else {
            console.error('❌ Không tìm thấy grid view element');
            console.log('New grid view found:', $newGridView.length > 0);
            console.log('Current grid view found:', $currentGridView.length > 0);
        }
    }

    // Cập nhật pagination
    function updatePagination(html) {
        console.log('🔄 Đang cập nhật pagination...');

        // Parse HTML response
        const $html = $('<div>').html(html);

        // Tìm pagination mới
        const $newPagination = $html.find('.pagination-area');
        const $currentPagination = $('.pagination-area');

        if ($newPagination.length && $currentPagination.length) {
            $currentPagination.html($newPagination.html());
            console.log('✅ Pagination đã cập nhật');

            // Gắn lại event handlers cho pagination
            attachPaginationHandlers();
            updateSelectionSummary();
        } else {
            console.log('ℹ️ Không có pagination (có thể là kết quả rỗng)');
        }
    }

    // Cập nhật Current Filters Bar (phía trên product grid)
    function updateCurrentFiltersBar(html) {
        console.log('🔄 Đang cập nhật current filters bar...');

        // Parse HTML response
        const $html = $('<div>').html(html);

        // Tìm current-filters-bar mới
        const $newFiltersBar = $html.find('.current-filters-bar');
        const $currentFiltersBar = $('.current-filters-bar');

        if ($newFiltersBar.length) {
            // Có filters mới - cập nhật hoặc thêm mới
            if ($currentFiltersBar.length) {
                $currentFiltersBar.replaceWith($newFiltersBar);
                console.log('✅ Current filters bar đã cập nhật');
            } else {
                // Thêm mới vào trước .product-views
                $('.product-views').parent().prepend($newFiltersBar);
                console.log('✅ Current filters bar đã được thêm');
            }
        } else {
            // Không có filters - xóa bar hiện tại nếu có
            if ($currentFiltersBar.length) {
                $currentFiltersBar.remove();
                console.log('✅ Current filters bar đã được xóa (không còn filter)');
            }
        }
    }

    // Gắn event handlers cho pagination links
    function attachPaginationHandlers() {
        $(document).off('click', '.pagination-area a');

        $(document).on('click', '.pagination-area a', function(e) {
            e.preventDefault();

            const url = $(this).attr('href');
            if (!url || url === '#') {
                return;
            }

            console.log('📄 Pagination clicked:', url);

            // Lấy page number từ URL
            const urlParams = new URLSearchParams(url.split('?')[1]);
            const page = urlParams.get('page');

            if (page) {
                // Cập nhật hoặc thêm input page vào form
                let $pageInput = $('#filter-form input[name="page"]');

                if (!$pageInput.length) {
                    $pageInput = $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'page');
                    $('#filter-form').append($pageInput);
                }

                $pageInput.val(page);
                console.log('📄 Set page:', page);
            }

            applyFilters();
        });
    }

    // Cập nhật URL trong browser
    function updateURL(params) {
        const url = new URL(window.location);
        url.search = '';

        // Thêm params mới (trừ ajax)
        $.each(params, function(key, value) {
            if (key !== 'ajax') {
                url.searchParams.set(key, value);
            }
        });

        window.history.pushState({}, '', url.toString());
        console.log('🔗 URL updated:', url.toString());
    }

    // Hiển thị loading state
    function showLoading() {
        const $gridView = $('#grid-view');

        if ($gridView.length) {
            $gridView.css({
                'opacity': '0.5',
                'pointer-events': 'none'
            });
        }

        // Thêm spinner nếu chưa có
        const $shopContent = $('.shop-products-wrapper');
        if ($shopContent.length && !$shopContent.find('.loading-spinner').length) {
            const $spinner = $(`
                <div class="loading-spinner text-center py-5">
                    <div class="spinner-border text-danger" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-3 text-muted">Đang lọc sản phẩm...</p>
                </div>
            `);
            $shopContent.prepend($spinner);
        }

        console.log('⏳ Hiển thị loading...');
    }

    // Ẩn loading state
    function hideLoading() {
        const $gridView = $('#grid-view');

        if ($gridView.length) {
            $gridView.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        }

        $('.loading-spinner').remove();
        console.log('✅ Ẩn loading');
    }

    // Scroll đến products
    function scrollToProducts() {
        const $shopTopBar = $('.shop-top-bar');

        if ($shopTopBar.length) {
            $('html, body').animate({
                scrollTop: $shopTopBar.offset().top - 100
            }, 300);
        }
    }

    // Hiển thị error message
    function showErrorMessage(message) {
        const $alert = $(`
            <div class="alert alert-danger alert-dismissible fade show filter-error-alert"
                 style="position: fixed; top: 20px; right: 20px; z-index: 10000; max-width: 400px;
                        background: #DC3E37; color: white; border: none; border-radius: 6px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-exclamation-circle fa-lg"></i>
                    <span>${message}</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('body').append($alert);

        // Auto remove sau 5 giây
        setTimeout(function() {
            $alert.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Xử lý nút back/forward của browser
    $(window).on('popstate', function() {
        location.reload();
    });

    // API công khai
    window.shopAjaxFilter = {
        applyFilters: applyFilters,
        init: initAjaxFilter
    };

    // Auto-initialize khi DOM ready
    $(document).ready(function() {
        console.log('🚀 Khởi động Shop AJAX Filter...');
        initAjaxFilter();
        attachPaginationHandlers();

        // Đảm bảo active state được set đúng khi load trang
        $('.filter-option.compact').each(function() {
            const $radio = $(this).find('input[type="radio"]');
            if ($radio.prop('checked')) {
                $(this).addClass('active');
            }
        });
        // Mobile accordion for filter sections
        document.querySelectorAll('.filter-section-header').forEach(function(h) {
            h.addEventListener('click', function() {
                h.classList.toggle('active');
            });
        });

        // View toggle for desktop
        const gridBtn = document.getElementById('grid-view-btn');
        const listBtn = document.getElementById('list-view-btn');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        if (gridBtn && listBtn && gridView && listView) {
            gridBtn.addEventListener('click', function() {
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                gridView.style.display = 'block';
                listView.style.display = 'none';
            });
            listBtn.addEventListener('click', function() {
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                listView.style.display = 'block';
                gridView.style.display = 'none';
            });
        }

        // Show more/less handler
        $(document).on('click', '.btn-show-more', function() {
            const $btn = $(this);
            const $container = $btn.prev('.collapsible-items');
            if ($container.length) {
                $container.toggleClass('expanded');
                $btn.toggleClass('expanded');
                const isExpanded = $btn.hasClass('expanded');
                $btn.find('.show-more-text').text(isExpanded ? 'Thu gọn' : 'Xem thêm');
            }
        });

        // Clear search
        window.clearSearch = function() {
            const $input = $('.search-input');
            $input.val('');
            applyFilters();
            updateSelectionSummary();
        }

        // Remove individual filter tag
        window.removeFilter = function(type) {
            const $form = $('#filter-form');
            if (type === 'search') {
                $form.find('input[name="search"]').val('');
                $('.search-clear-btn').hide();
            } else if (type === 'category') {
                // Uncheck current và check "Tất cả"
                $form.find('input[name="category"]').prop('checked', false);
                $form.find('input[name="category"][value=""]').prop('checked', true);
                // Update active state
                $('.category-section .filter-option').removeClass('active');
                $('.category-section .filter-option').first().addClass('active');
            } else if (type === 'brand') {
                // Uncheck current và check "Tất cả"
                $form.find('input[name="brand"]').prop('checked', false);
                $form.find('input[name="brand"][value=""]').prop('checked', true);
                // Update active state
                $('.brand-section .filter-option').removeClass('active');
                $('.brand-section .filter-option').first().addClass('active');
            } else if (type === 'price') {
                $form.find('input[name="min_price"]').val('');
                $form.find('input[name="max_price"]').val('');
                // Unselect price range buttons
                $('.price-range-btn').removeClass('selected');
            }
            applyFilters();
            updateSelectionSummary();
        }

        // Clear all visible selections (UI only helpers)
        window.clearAllSelections = function() {
            const $form = $('#filter-form');

            // Reset category về "Tất cả"
            $form.find('input[name="category"]').prop('checked', false);
            $form.find('input[name="category"][value=""]').prop('checked', true);
            $('.category-section .filter-option').removeClass('active');
            $('.category-section .filter-option').first().addClass('active');

            // Reset brand về "Tất cả"
            $form.find('input[name="brand"]').prop('checked', false);
            $form.find('input[name="brand"][value=""]').prop('checked', true);
            $('.brand-section .filter-option').removeClass('active');
            $('.brand-section .filter-option').first().addClass('active');

            // Clear search
            $form.find('input[name="search"]').val('');
            $('.search-clear-btn').hide();

            // Clear price
            $form.find('input[name="min_price"], input[name="max_price"]').val('');
            $('.price-range-btn').removeClass('selected');

            // Clear size and color selections
            $('.size-btn.solid-toggle').removeClass('active');
            $('.color-btn.solid-toggle').removeClass('active');

            applyFilters();
            updateSelectionSummary();
        }

        // Reset all (kept for button behavior)
        window.resetAllFilters = function() {
            clearAllSelections();
        }

        // Initial summary
        updateSelectionSummary();
    });

    // Update selection summary text
    function updateSelectionSummary() {
        const params = new URLSearchParams(window.location.search);
        let count = 0;
        ['search','category','brand','min_price','max_price'].forEach(function(k){
            if (params.get(k)) count++;
        });
        const $summary = $('.selection-summary .summary-text');
        if ($summary.length) {
            $summary.text(`Đã chọn: ${count} bộ lọc`);
        }
    }

})(jQuery);
