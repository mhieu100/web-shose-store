<!-- Product Options Modal -->
<div class="modal fade" id="productOptionsModal" tabindex="-1" aria-labelledby="productOptionsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modern-modal">
            <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-times"></i>
            </button>

            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Product Image Section -->
                    <div class="col-md-5 product-image-section">
                        <div class="product-image-wrapper-modern">
                            <img id="modal-product-image"
                                 src=""
                                 alt="Product"
                                 class="product-modal-image-modern">
                            <div class="image-badge-container">
                                <span class="stock-badge" id="modal-stock-badge">
                                    <i class="fa fa-check-circle me-1"></i>Còn hàng
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-md-7 product-details-section">
                        <div class="product-details-wrapper">
                            <!-- Product Header -->
                            <div class="product-header mb-3">
                                <div class="product-category mb-2">
                                    <span class="category-badge">
                                        <i class="fa fa-tag me-1"></i>Giày thể thao
                                    </span>
                                </div>
                                <h4 id="modal-product-name" class="product-title-modern mb-2"></h4>

                                <div class="product-meta d-flex align-items-center gap-3 mb-3">
                                    <div class="product-rating-modern">
                                        <div class="stars" id="modal-product-rating"></div>
                                        <span class="rating-text" id="modal-rating-text"></span>
                                    </div>
                                    <div class="product-sku-modern">
                                        <i class="fa fa-barcode me-1"></i>
                                        <span id="modal-product-sku"></span>
                                    </div>
                                </div>

                                <div class="price-section-modern mb-4">
                                    <div class="price-wrapper">
                                        <span class="current-price-modern" id="modal-product-price"></span>
                                        <span class="original-price-modern" id="modal-original-price" style="display: none;"></span>
                                    </div>
                                    <span class="discount-badge-modern" id="modal-discount-badge" style="display: none;"></span>
                                </div>
                            </div>

                            <div class="divider-modern mb-4"></div>

                            <!-- Color Selection -->
                            <div id="color-selection" class="product-option-section-modern" style="display: none;">
                                <label class="option-label-modern">
                                    <i class="fa fa-palette me-2"></i>Màu sắc
                                    <span class="selected-indicator" id="selected-color-name"></span>
                                </label>
                                <div class="color-options-modern" id="color-options">
                                    <!-- Colors will be populated here -->
                                </div>
                            </div>

                            <!-- Size Selection -->
                            <div id="size-selection" class="product-option-section-modern" style="display: none;">
                                <label class="option-label-modern">
                                    <i class="fa fa-ruler-combined me-2"></i>Kích thước
                                    <span class="selected-indicator" id="selected-size-name"></span>
                                </label>
                                <div class="size-options-modern" id="size-options">
                                    <!-- Sizes will be populated here -->
                                </div>
                            </div>

                            <!-- Quantity Selection -->
                            <div class="product-option-section-modern">
                                <label class="option-label-modern">
                                    <i class="fa fa-shopping-basket me-2"></i>Số lượng
                                </label>
                                <div class="quantity-selector-modern">
                                    <button type="button" class="qty-btn qty-decrease">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" id="modal-quantity" class="qty-input"
                                           value="1" min="1" max="99">
                                    <button type="button" class="qty-btn qty-increase">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <span class="qty-label">sản phẩm</span>
                                </div>
                            </div>

                            <!-- Selected Options Summary -->
                            <div id="selected-options" class="selected-summary-modern" style="display: none;">
                                <div class="summary-header">
                                    <i class="fa fa-check-circle me-2"></i>
                                    <span>Tóm tắt lựa chọn</span>
                                </div>
                                <div id="selected-summary" class="summary-content"></div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="modal-actions">
                                <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                                    <i class="fa fa-times me-2"></i>Hủy
                                </button>
                                <button type="button" class="btn-add-cart" id="confirm-add-to-cart">
                                    <i class="fa fa-shopping-cart me-2"></i>
                                    <span>Thêm vào giỏ hàng</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   Modern Product Options Modal Styles
   ============================================ */

/* Modal Base Styles */
#productOptionsModal .modal-dialog {
    max-width: 750px;
    margin: 1rem auto;
}

#productOptionsModal .modal-content.modern-modal {
    border-radius: 16px;
    border: none;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Custom Close Button */
.btn-close-custom {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.btn-close-custom:hover {
    background: #ff4757;
    color: white;
    transform: rotate(90deg);
    box-shadow: 0 5px 14px rgba(255, 71, 87, 0.3);
}

.btn-close-custom i {
    font-size: 16px;
}

/* Product Image Section */
.product-image-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
}

.product-image-wrapper-modern {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.product-modal-image-modern {
    width: 100%;
    max-width: 280px;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.25));
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    animation: floatImage 3s ease-in-out infinite;
}

@keyframes floatImage {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.product-image-wrapper-modern:hover .product-modal-image-modern {
    transform: scale(1.05);
}

.image-badge-container {
    position: absolute;
    top: 15px;
    left: 15px;
}

.stock-badge {
    background: rgba(46, 213, 115, 0.95);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 3px 10px rgba(46, 213, 115, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 4px 12px rgba(46, 213, 115, 0.3);
    }
    50% {
        box-shadow: 0 4px 20px rgba(46, 213, 115, 0.5);
    }
}

/* Product Details Section */
.product-details-section {
    background: #ffffff;
}

.product-details-wrapper {
    padding: 1.75rem;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Product Header */
.category-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.product-title-modern {
    color: #2d3436;
    font-weight: 700;
    font-size: 1.35rem;
    line-height: 1.3;
    margin: 0;
}

.product-meta {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 0.75rem;
}

.product-rating-modern {
    display: flex;
    align-items: center;
    gap: 6px;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    color: #ffa502;
    font-size: 12px;
}

.star.empty {
    color: #dfe6e9;
}

.rating-text {
    color: #636e72;
    font-size: 11px;
    font-weight: 500;
}

.product-sku-modern {
    color: #95a5a6;
    font-size: 11px;
    font-weight: 500;
}

.product-sku-modern i {
    color: #b2bec3;
}

/* Price Section */
.price-section-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #fff5f5 0%, #ffe9e9 100%);
    padding: 0.75rem 1rem;
    border-radius: 10px;
}

.price-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.current-price-modern {
    color: #ff4757;
    font-weight: 800;
    font-size: 1.5rem;
    line-height: 1;
}

.original-price-modern {
    color: #95a5a6;
    text-decoration: line-through;
    font-size: 0.95rem;
    font-weight: 600;
}

.discount-badge-modern {
    background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 3px 10px rgba(255, 71, 87, 0.3);
}

.divider-modern {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e1e8ed, transparent);
}

/* Product Options Section */
.product-option-section-modern {
    margin-bottom: 1.25rem;
}

.option-label-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #2d3436;
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 10px;
}

.option-label-modern i {
    color: #667eea;
}

.selected-indicator {
    color: #667eea;
    font-weight: 600;
    font-size: 11px;
    background: #f0f3ff;
    padding: 3px 10px;
    border-radius: 12px;
}

/* Color Options */
.color-options-modern {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.color-option {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 3px solid transparent;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.color-option:hover {
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.color-option.selected {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    transform: scale(1.1);
}

.color-option.selected::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: white;
}

.color-option.selected::before {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #667eea;
    font-weight: bold;
    font-size: 12px;
    z-index: 1;
}

/* Size Options */
.size-options-modern {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.size-option {
    padding: 10px 16px;
    border: 2px solid #dfe6e9;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 13px;
    min-width: 55px;
    text-align: center;
    color: #2d3436;
}

.size-option:hover {
    border-color: #667eea;
    background: #f0f3ff;
    transform: translateY(-2px);
}

.size-option.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: scale(1.03);
    box-shadow: 0 5px 14px rgba(102, 126, 234, 0.3);
}

/* Quantity Selector */
.quantity-selector-modern {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    padding: 6px;
    border-radius: 10px;
    width: fit-content;
}

.qty-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    background: white;
    color: #667eea;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.qty-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: scale(1.08);
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
}

.qty-btn:active {
    transform: scale(0.95);
}

.qty-input {
    width: 60px;
    height: 36px;
    border: 2px solid #dfe6e9;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    font-size: 14px;
    color: #2d3436;
    background: white;
}

.qty-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.qty-label {
    color: #636e72;
    font-size: 12px;
    font-weight: 600;
}

/* Selected Summary */
.selected-summary-modern {
    background: linear-gradient(135deg, #f0f3ff 0%, #e8eeff 100%);
    border-left: 3px solid #667eea;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin-top: 1rem;
}

.summary-header {
    display: flex;
    align-items: center;
    color: #2d3436;
    font-weight: 700;
    font-size: 12px;
    margin-bottom: 8px;
}

.summary-header i {
    color: #00b894;
}

.summary-content {
    color: #636e72;
    font-size: 11px;
    line-height: 1.6;
}

.summary-item {
    margin-bottom: 5px;
}

.summary-item strong {
    color: #667eea;
    font-weight: 600;
}

/* Modal Actions */
.modal-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
    padding-top: 1.5rem;
}

.btn-cancel {
    flex: 1;
    padding: 12px 20px;
    border: 2px solid #dfe6e9;
    border-radius: 10px;
    background: white;
    color: #636e72;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel:hover {
    border-color: #ff4757;
    color: #ff4757;
    background: #fff5f5;
    transform: translateY(-2px);
}

.btn-add-cart {
    flex: 2;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(102, 126, 234, 0.4);
}

.btn-add-cart:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 768px) {
    #productOptionsModal .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }

    .product-image-section {
        min-height: 250px;
        padding: 1rem;
    }

    .product-modal-image-modern {
        max-width: 200px;
    }

    .product-details-wrapper {
        padding: 1.25rem;
    }

    .product-title-modern {
        font-size: 1.15rem;
    }

    .current-price-modern {
        font-size: 1.25rem;
    }

    .modal-actions {
        flex-direction: column;
    }

    .btn-close-custom {
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
    }
}

/* Z-index Management */
#productOptionsModal {
    z-index: 1060;
}

#productOptionsModal .modal-backdrop {
    z-index: 1050;
}

/* Accessibility */
#productOptionsModal:focus {
    outline: none;
}

.btn-close-custom:focus,
.qty-btn:focus,
.btn-cancel:focus,
.btn-add-cart:focus {
    outline: 3px solid rgba(102, 126, 234, 0.4);
    outline-offset: 2px;
}
</style>
