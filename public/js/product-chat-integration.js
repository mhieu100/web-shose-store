/**
 * Product Page Chat Integration
 * Functions to trigger AI chat with product-specific context
 */

// Get current product information
function getCurrentProductInfo() {
    const productId = document.querySelector('[data-product-id]')?.getAttribute('data-product-id');
    const productName = document.querySelector('.main-title')?.textContent?.trim();
    const productPrice = document.querySelector('.price')?.textContent?.trim();
    
    return {
        id: productId,
        name: productName,
        price: productPrice
    };
}

// Ask about the current product
function askAboutProduct() {
    const product = getCurrentProductInfo();
    const message = `Bạn có thể cho tôi biết thêm về sản phẩm ${product.name} không? Tôi muốn tìm hiểu về chất lượng, đặc điểm và cách sử dụng.`;
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            current_product: product.id,
            action: 'product_inquiry'
        });
    }
}

// Ask about size guidance
function askAboutSize() {
    const product = getCurrentProductInfo();
    const message = `Tôi cần tư vấn về size cho sản phẩm ${product.name}. Làm thế nào để chọn size phù hợp?`;
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            current_product: product.id,
            action: 'size_guidance'
        });
    }
}

// Ask about similar products
function askAboutSimilar() {
    const product = getCurrentProductInfo();
    const message = `Bạn có thể gợi ý những sản phẩm tương tự như ${product.name} không? Tôi muốn so sánh các lựa chọn khác.`;
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            current_product: product.id,
            action: 'similar_products'
        });
    }
}

// Quick chat for delivery info
function askAboutDelivery() {
    const message = "Tôi muốn biết về thời gian giao hàng và phí vận chuyển.";
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            action: 'delivery_info'
        });
    }
}

// Quick chat for return policy
function askAboutReturns() {
    const message = "Chính sách đổi trả của cửa hàng như thế nào?";
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            action: 'return_policy'
        });
    }
}

// Quick chat for promotions
function askAboutPromotions() {
    const product = getCurrentProductInfo();
    const message = `Hiện tại có khuyến mãi nào cho sản phẩm ${product.name} hoặc các sản phẩm tương tự không?`;
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            current_product: product.id,
            action: 'promotions'
        });
    }
}

// Add floating help button near product images
function addFloatingHelpButton() {
    const productThumb = document.querySelector('.product-single-thumb');
    if (productThumb && !document.querySelector('.floating-help-btn')) {
        const helpButton = document.createElement('div');
        helpButton.className = 'floating-help-btn';
        helpButton.innerHTML = `
            <button type="button" class="btn btn-primary rounded-circle" onclick="openProductHelp()" title="Cần hỗ trợ?">
                <i class="fas fa-question"></i>
            </button>
        `;
        
        // Add styles
        helpButton.style.cssText = `
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 10;
        `;
        
        productThumb.style.position = 'relative';
        productThumb.appendChild(helpButton);
    }
}

// Open product help chat
function openProductHelp() {
    const product = getCurrentProductInfo();
    const message = `Tôi đang xem sản phẩm ${product.name} và cần hỗ trợ. Bạn có thể giúp tôi không?`;
    
    if (window.sendAIChatMessage) {
        window.sendAIChatMessage(message, {
            current_product: product.id,
            action: 'general_help'
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add floating help button
    addFloatingHelpButton();
    
    // Add quick action buttons to product info section
    const productInfo = document.querySelector('.product-single-info');
    if (productInfo && !document.querySelector('.quick-chat-actions')) {
        const quickActions = document.createElement('div');
        quickActions.className = 'quick-chat-actions mt-3 pt-3 border-top';
        quickActions.innerHTML = `
            <h6 class="mb-2">Cần hỗ trợ thêm?</h6>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="askAboutDelivery()">
                    <i class="fas fa-shipping-fast"></i> Giao hàng
                </button>
                <button type="button" class="btn btn-outline-warning btn-sm" onclick="askAboutReturns()">
                    <i class="fas fa-undo"></i> Đổi trả
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="askAboutPromotions()">
                    <i class="fas fa-tags"></i> Khuyến mãi
                </button>
            </div>
        `;
        
        // Find the best place to insert (after product actions)
        const productActions = productInfo.querySelector('.product-action');
        if (productActions) {
            productActions.parentNode.insertBefore(quickActions, productActions.nextSibling);
        } else {
            productInfo.appendChild(quickActions);
        }
    }
});