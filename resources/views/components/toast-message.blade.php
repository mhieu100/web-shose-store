<!-- Toastify JS - Pure JavaScript Toast Notification Library -->
<!-- Include Toastify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Include Toastify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<style>
/* Custom Toastify Styles - Vietnamese Theme */
.toastify {
    font-family: 'Poppins', sans-serif !important;
    border-radius: 10px !important;
    padding: 12px 16px !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15), 0 3px 8px rgba(0, 0, 0, 0.1) !important;
    min-width: 300px !important;
    max-width: 380px !important;
}

/* Success Toast */
.toastify.toast-success {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%) !important;
    border-left: 4px solid #1e8449 !important;
}

/* Error Toast */
.toastify.toast-error {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
    border-left: 4px solid #a93226 !important;
}

/* Warning Toast */
.toastify.toast-warning {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;
    border-left: 4px solid #d68910 !important;
}

/* Info Toast */
.toastify.toast-info {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
    border-left: 4px solid #2471a3 !important;
}

/* Toast Content Styling */
.toastify-content {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    width: 100%;
}

.toastify-icon {
    font-size: 18px;
    flex-shrink: 0;
    margin-top: 2px;
}

.toastify-text {
    flex: 1;
    line-height: 1.4;
    overflow: hidden;
    min-width: 0;
}

.toastify-title {
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 2px;
    line-height: 1.3;
}

.toastify-message {
    font-size: 12px;
    opacity: 0.95;
    line-height: 1.4;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* Main toast container layout fix */
.toastify.on {
    display: flex !important;
    align-items: flex-start !important;
    padding: 12px 16px !important;
}

/* Close Button - Override Toastify default */
.toastify button {
    background: transparent !important;
    border: none !important;
    color: white !important;
    font-size: 14px !important;
    font-weight: 400 !important;
    opacity: 0.8 !important;
    padding: 0 !important;
    margin: 0 0 0 10px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    line-height: 1 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2) !important;
    border-radius: 3px !important;
    flex-shrink: 0 !important;
    align-self: flex-start !important;
    margin-top: 0 !important;
    position: relative !important;
}

.toastify button i {
    font-size: 11px !important;
    line-height: 1 !important;
    display: block !important;
}

.toastify button:hover {
    opacity: 1 !important;
    transform: scale(1.15) !important;
    background: rgba(255, 255, 255, 0.2) !important;
}

.toastify button:active {
    transform: scale(0.95) !important;
    background: rgba(255, 255, 255, 0.3) !important;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .toastify {
        min-width: auto !important;
        max-width: calc(100vw - 32px) !important;
        margin: 8px !important;
    }
}
</style>
