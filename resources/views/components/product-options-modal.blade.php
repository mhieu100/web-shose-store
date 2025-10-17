<!-- Product Options Modal -->
<div class="modal fade" id="productOptionsModal" tabindex="-1" aria-labelledby="productOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productOptionsModalLabel">
                    <i class="fas fa-cog me-2"></i>Chọn tùy chọn sản phẩm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="product-quick-info mb-3">
                    <div class="row">
                        <div class="col-4">
                            <img id="modal-product-image" src="" alt="Product" class="img-fluid rounded">
                        </div>
                        <div class="col-8">
                            <h6 id="modal-product-name" class="mb-2"></h6>
                            <p class="price-info mb-0">
                                <span class="text-primary fw-bold" id="modal-product-price"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Color Selection -->
                <div id="color-selection" class="product-option-section" style="display: none;">
                    <h6 class="option-title">
                        <i class="fas fa-palette me-2"></i>Chọn màu sắc
                    </h6>
                    <div class="color-options" id="color-options">
                        <!-- Colors will be populated here -->
                    </div>
                </div>

                <!-- Size Selection -->
                <div id="size-selection" class="product-option-section" style="display: none;">
                    <h6 class="option-title">
                        <i class="fas fa-ruler me-2"></i>Chọn kích thước
                    </h6>
                    <div class="size-options" id="size-options">
                        <!-- Sizes will be populated here -->
                    </div>
                </div>

                <!-- Quantity Selection -->
                <div class="product-option-section">
                    <h6 class="option-title">
                        <i class="fas fa-sort-numeric-up me-2"></i>Số lượng
                    </h6>
                    <div class="quantity-selector">
                        <button type="button" class="btn btn-outline-secondary btn-sm qty-decrease">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="modal-quantity" class="form-control form-control-sm text-center mx-2" 
                               value="1" min="1" style="width: 80px; display: inline-block;">
                        <button type="button" class="btn btn-outline-secondary btn-sm qty-increase">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Selected Options Summary -->
                <div id="selected-options" class="alert alert-light mt-3" style="display: none;">
                    <h6 class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Lựa chọn của bạn:</h6>
                    <div id="selected-summary"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy
                </button>
                <button type="button" class="btn btn-primary" id="confirm-add-to-cart">
                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.product-option-section {
    margin-bottom: 1.5rem;
}

.option-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 14px;
}

.color-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.color-option {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.color-option:hover {
    transform: scale(1.1);
    border-color: #007bff;
}

.color-option.selected {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.color-option::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.color-option.selected::after {
    opacity: 1;
}

.color-option.selected::before {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #007bff;
    font-weight: bold;
    font-size: 12px;
    z-index: 1;
}

.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.size-option {
    padding: 8px 16px;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    min-width: 50px;
    text-align: center;
}

.size-option:hover {
    border-color: #007bff;
    background: #f8f9fa;
}

.size-option.selected {
    border-color: #007bff;
    background: #007bff;
    color: white;
}

.quantity-selector {
    display: flex;
    align-items: center;
}

#selected-summary {
    font-size: 14px;
}

.summary-item {
    margin-bottom: 5px;
}

.summary-item strong {
    color: #007bff;
}
</style>