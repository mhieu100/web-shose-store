/**
 * Toast Handler - Using Toastify JS Library
 * Automatically displays Laravel session messages as toast notifications
 * and provides utility functions for showing toasts throughout the application
 */

(function() {
    'use strict';

    // Wait for DOM and Toastify to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Toastify is available
        if (typeof Toastify === 'undefined') {
            console.error('Toastify library not found. Make sure Toastify JS is included.');
            return;
        }

        // Display Laravel session messages automatically
        displaySessionMessages();

        // Display validation errors if any
        displayValidationErrors();

        // Setup global error handlers
        setupErrorHandlers();
    });

    /**
     * Display Laravel session flash messages as toasts
     */
    function displaySessionMessages() {
        // Get session messages from meta tags or data attributes
        const messages = {
            success: getSessionMessage('success'),
            error: getSessionMessage('error'),
            warning: getSessionMessage('warning'),
            info: getSessionMessage('info'),
            message: getSessionMessage('message')
        };

        // Display each message type
        if (messages.success) {
            showToastifyNotification('success', 'Thành công', messages.success);
        }

        if (messages.error) {
            showToastifyNotification('error', 'Lỗi', messages.error, 7000);
        }

        if (messages.warning) {
            showToastifyNotification('warning', 'Cảnh báo', messages.warning, 6000);
        }

        if (messages.info) {
            showToastifyNotification('info', 'Thông tin', messages.info);
        }

        if (messages.message && !messages.success && !messages.error && !messages.warning && !messages.info) {
            showToastifyNotification('info', 'Thông báo', messages.message);
        }
    }

    /**
     * Display Laravel validation errors as toasts
     */
    function displayValidationErrors() {
        const validationErrorsInput = document.getElementById('validation-errors');
        if (validationErrorsInput && validationErrorsInput.value) {
            try {
                const errors = JSON.parse(validationErrorsInput.value);
                if (Array.isArray(errors) && errors.length > 0) {
                    const errorMessage = errors.join('<br>');
                    showToastifyNotification('error', 'Vui lòng kiểm tra lại', errorMessage, 8000, true);
                }
            } catch (e) {
                console.error('Error parsing validation errors:', e);
            }
        }
    }

    /**
     * Get session message from various sources
     */
    function getSessionMessage(type) {
        // Try to get from meta tag
        const metaTag = document.querySelector(`meta[name="session-${type}"]`);
        if (metaTag && metaTag.content) {
            return metaTag.content;
        }

        // Try to get from data attribute on body
        const bodyData = document.body.getAttribute(`data-session-${type}`);
        if (bodyData) {
            return bodyData;
        }

        // Try to get from hidden input
        const hiddenInput = document.getElementById(`session-${type}`);
        if (hiddenInput && hiddenInput.value) {
            return hiddenInput.value;
        }

        return null;
    }

    /**
     * Setup global error handlers
     */
    function setupErrorHandlers() {
        // Handle AJAX errors globally (if jQuery is available)
        if (typeof $ !== 'undefined') {
            $(document).ajaxError(function(event, jqxhr, settings) {
                // Only show error if not handled by specific AJAX call
                if (!settings.suppressGlobalErrorHandler) {
                    let errorMessage = 'Đã xảy ra lỗi khi xử lý yêu cầu';

                    if (jqxhr.responseJSON && jqxhr.responseJSON.message) {
                        errorMessage = jqxhr.responseJSON.message;
                    } else if (jqxhr.statusText && jqxhr.statusText !== 'error') {
                        errorMessage = jqxhr.statusText;
                    }

                    showToastifyNotification('error', 'Lỗi', errorMessage, 7000);
                }
            });
        }
    }

    /**
     * Core function to show Toastify notification
     */
    function showToastifyNotification(type, title, message, duration = 5000, escapeHtml = false) {
        const icons = {
            success: '<i class="fa fa-check-circle toastify-icon"></i>',
            error: '<i class="fa fa-times-circle toastify-icon"></i>',
            warning: '<i class="fa fa-exclamation-triangle toastify-icon"></i>',
            info: '<i class="fa fa-info-circle toastify-icon"></i>'
        };

        // Escape HTML if needed
        const safeMessage = escapeHtml ? message : escapeHtmlContent(message);

        const toastContent = `
            <div class="toastify-content">
                ${icons[type] || icons.info}
                <div class="toastify-text">
                    <div class="toastify-title">${title}</div>
                    <div class="toastify-message">${safeMessage}</div>
                </div>
            </div>
        `;

        const toastConfig = {
            text: toastContent,
            duration: duration,
            close: true,
            gravity: "top", // top or bottom
            position: "right", // left, center or right
            stopOnFocus: true, // Prevents dismissing of toast on hover
            escapeMarkup: false, // Allow HTML
            className: `toast-${type}`,
            onClick: function(){}, // Callback after click
            callback: function() {
                // Custom close button with Font Awesome icon
                setTimeout(() => {
                    const toasts = document.querySelectorAll('.toastify');
                    toasts.forEach(toast => {
                        const closeBtn = toast.querySelector('button');
                        if (closeBtn && closeBtn.innerHTML === '✖') {
                            closeBtn.innerHTML = '<i class="fa fa-times"></i>';
                            closeBtn.setAttribute('aria-label', 'Close');
                            closeBtn.setAttribute('title', 'Đóng');
                        }
                    });
                }, 10);
            }
        };

        return Toastify(toastConfig).showToast();
    }

    /**
     * Escape HTML content for security
     */
    function escapeHtmlContent(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    /**
     * Enhanced toast helper functions
     */
    window.toastHelper = {
        /**
         * Show success toast
         */
        success: function(message, title = 'Thành công', duration = 5000) {
            return showToastifyNotification('success', title, message, duration);
        },

        /**
         * Show error toast
         */
        error: function(message, title = 'Lỗi', duration = 7000) {
            return showToastifyNotification('error', title, message, duration);
        },

        /**
         * Show warning toast
         */
        warning: function(message, title = 'Cảnh báo', duration = 6000) {
            return showToastifyNotification('warning', title, message, duration);
        },

        /**
         * Show info toast
         */
        info: function(message, title = 'Thông tin', duration = 5000) {
            return showToastifyNotification('info', title, message, duration);
        },

        /**
         * Show validation errors from Laravel
         */
        validationErrors: function(errors, title = 'Lỗi nhập liệu') {
            if (typeof errors === 'object') {
                let errorMessages = [];

                for (let field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        if (Array.isArray(errors[field])) {
                            errorMessages = errorMessages.concat(errors[field]);
                        } else {
                            errorMessages.push(errors[field]);
                        }
                    }
                }

                const message = errorMessages.join('<br>');
                return showToastifyNotification('error', title, message, 8000, true);
            } else if (typeof errors === 'string') {
                return showToastifyNotification('error', title, errors, 7000);
            }
        },

        /**
         * Show cart action toast
         */
        cartAction: function(action, productName = '') {
            const messages = {
                added: productName ? `Đã thêm vào giỏ hàng` : 'Đã thêm vào giỏ hàng',
                updated: `Đã cập nhật giỏ hàng`,
                removed: `Đã xóa khỏi giỏ hàng`,
                cleared: 'Đã xóa giỏ hàng'
            };

            return this.success(messages[action] || messages.added);
        },

        /**
         * Show wishlist action toast
         */
        wishlistAction: function(action, productName = '') {
            const messages = {
                added: `Đã thêm vào yêu thích`,
                removed: `Đã xóa khỏi yêu thích`
            };

            return this.success(messages[action] || messages.added);
        },

        /**
         * Show loading toast
         */
        loading: function(message = 'Đang xử lý...', title = 'Xin chờ') {
            return showToastifyNotification('info', title, message, -1);
        },

        /**
         * Show custom toast with full Toastify options
         */
        custom: function(options) {
            return Toastify(options).showToast();
        }
    };

    // Global backward-compatible notification functions
    // These provide compatibility with existing code that uses showSuccess(), showError(), etc.
    window.showSuccess = function(message, title = 'Thành công') {
        return window.toastHelper.success(message, title);
    };

    window.showError = function(message, title = 'Lỗi') {
        return window.toastHelper.error(message, title);
    };

    window.showWarning = function(message, title = 'Cảnh báo') {
        return window.toastHelper.warning(message, title);
    };

    window.showInfo = function(message, title = 'Thông tin') {
        return window.toastHelper.info(message, title);
    };

    window.showNotification = function(message, type = 'info', title = '') {
        switch(type.toLowerCase()) {
            case 'success':
                return window.toastHelper.success(message, title || 'Thành công');
            case 'error':
            case 'danger':
                return window.toastHelper.error(message, title || 'Lỗi');
            case 'warning':
                return window.toastHelper.warning(message, title || 'Cảnh báo');
            case 'info':
            default:
                return window.toastHelper.info(message, title || 'Thông tin');
        }
    };

    // For backward compatibility with old Toast object
    window.Toast = {
        success: function(title, message, options = {}) {
            return showToastifyNotification('success', title, message, options.duration || 5000);
        },
        error: function(title, message, options = {}) {
            return showToastifyNotification('error', title, message, options.duration || 7000);
        },
        warning: function(title, message, options = {}) {
            return showToastifyNotification('warning', title, message, options.duration || 6000);
        },
        info: function(title, message, options = {}) {
            return showToastifyNotification('info', title, message, options.duration || 5000);
        },
        show: function(options = {}) {
            const type = options.type || 'info';
            const title = options.title || 'Thông báo';
            const message = options.message || '';
            const duration = options.duration || 5000;
            return showToastifyNotification(type, title, message, duration, options.allowHtml);
        }
    };

})();
