{{-- Payment Methods Component --}}
<div class="payment-methods-section">
    <h4 class="mb-3">Phương Thức Thanh Toán</h4>
    
    <div class="payment-methods">
        {{-- Cash on Delivery --}}
        <div class="payment-method-item">
            <input type="radio" id="cod" name="payment_method" value="cod" checked>
            <label for="cod" class="payment-method-label">
                <div class="payment-method-content">
                    <div class="payment-method-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="payment-method-info">
                        <h5>Thanh toán khi nhận hàng (COD)</h5>
                        <p>Thanh toán bằng tiền mặt khi nhận hàng</p>
                    </div>
                </div>
            </label>
        </div>

        {{-- PayPal Payment --}}
        <div class="payment-method-item">
            <input type="radio" id="paypal" name="payment_method" value="paypal">
            <label for="paypal" class="payment-method-label">
                <div class="payment-method-content">
                    <div class="payment-method-icon">
                        <img src="{{ asset('img/photos/paypal.webp') }}" alt="PayPal" style="height: 30px;">
                    </div>
                    <div class="payment-method-info">
                        <h5>PayPal</h5>
                        <p>Thanh toán an toàn qua PayPal</p>
                    </div>
                </div>
            </label>
        </div>

        {{-- Bank Transfer --}}
        <div class="payment-method-item">
            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer">
            <label for="bank_transfer" class="payment-method-label">
                <div class="payment-method-content">
                    <div class="payment-method-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="payment-method-info">
                        <h5>Chuyển khoản ngân hàng</h5>
                        <p>Chuyển khoản trực tiếp vào tài khoản ngân hàng</p>
                    </div>
                </div>
            </label>
        </div>

        {{-- Credit Card (Placeholder for future implementation) --}}
        <div class="payment-method-item" style="opacity: 0.6;">
            <input type="radio" id="credit_card" name="payment_method" value="credit_card" disabled>
            <label for="credit_card" class="payment-method-label">
                <div class="payment-method-content">
                    <div class="payment-method-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="payment-method-info">
                        <h5>Thẻ tín dụng <span class="badge badge-secondary">Sắp có</span></h5>
                        <p>Thanh toán bằng thẻ tín dụng/ghi nợ</p>
                    </div>
                </div>
            </label>
        </div>
    </div>

    {{-- Payment Details --}}
    <div id="payment-details" class="payment-details mt-3">
        {{-- COD Details --}}
        <div id="cod-details" class="payment-detail-panel">
            <div class="alert alert-info">
                <h6><i class="fas fa-info-circle"></i> Thanh toán khi nhận hàng</h6>
                <ul class="mb-0">
                    <li>Thanh toán bằng tiền mặt khi shipper giao hàng</li>
                    <li>Kiểm tra hàng trước khi thanh toán</li>
                    <li>Phí COD: Miễn phí</li>
                </ul>
            </div>
        </div>

        {{-- PayPal Details --}}
        <div id="paypal-details" class="payment-detail-panel" style="display: none;">
            <div class="alert alert-success">
                <h6><i class="fab fa-paypal"></i> Thanh toán PayPal</h6>
                <ul class="mb-0">
                    <li>Thanh toán an toàn qua PayPal</li>
                    <li>Bảo vệ người mua 100%</li>
                    <li>Hỗ trợ thẻ tín dụng và tài khoản PayPal</li>
                    <li>Xử lý thanh toán ngay lập tức</li>
                </ul>
            </div>
        </div>

        {{-- Bank Transfer Details --}}
        <div id="bank_transfer-details" class="payment-detail-panel" style="display: none;">
            <div class="alert alert-warning">
                <h6><i class="fas fa-university"></i> Chuyển khoản ngân hàng</h6>
                <p><strong>Thông tin chuyển khoản:</strong></p>
                <div class="bank-info">
                    <p><strong>Ngân hàng:</strong> Vietcombank</p>
                    <p><strong>Số tài khoản:</strong> 1234567890</p>
                    <p><strong>Chủ tài khoản:</strong> CÔNG TY TNHH ABC</p>
                    <p><strong>Nội dung:</strong> Thanh toan don hang #[ORDER_ID]</p>
                </div>
                <small class="text-muted">Hãy gửi ảnh chụp biên lai chuyển khoản qua email để xác nhận thanh toán</small>
            </div>
        </div>
    </div>
</div>

<style>
.payment-methods-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.payment-method-item {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.payment-method-item:hover {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.payment-method-item input[type="radio"] {
    display: none;
}

.payment-method-item input[type="radio"]:checked + .payment-method-label {
    border-color: #007bff;
    background-color: #e7f3ff;
}

.payment-method-label {
    display: block;
    padding: 15px;
    cursor: pointer;
    border-radius: 6px;
    margin: 0;
    transition: all 0.3s ease;
}

.payment-method-content {
    display: flex;
    align-items: center;
}

.payment-method-icon {
    width: 50px;
    text-align: center;
    margin-right: 15px;
    font-size: 24px;
    color: #6c757d;
}

.payment-method-info h5 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
}

.payment-method-info p {
    margin: 0;
    font-size: 14px;
    color: #6c757d;
}

.payment-detail-panel {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bank-info {
    background: #fff;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #ffc107;
    margin: 10px 0;
}

.bank-info p {
    margin: 5px 0;
    font-size: 14px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentDetails = document.querySelectorAll('.payment-detail-panel');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            // Hide all payment details
            paymentDetails.forEach(detail => {
                detail.style.display = 'none';
            });
            
            // Show selected payment detail
            const selectedDetail = document.getElementById(this.value + '-details');
            if (selectedDetail) {
                selectedDetail.style.display = 'block';
            }
        });
    });
});
</script>