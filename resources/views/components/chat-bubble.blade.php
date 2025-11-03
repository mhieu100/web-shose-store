<!-- AI Chat Bubble Widget -->
<div id="ai-chat-widget" class="ai-chat-widget">
    <!-- Chat Toggle Button -->
    <div id="chat-toggle" class="chat-toggle">
        <i class="fas fa-comments"></i>
        <span class="chat-notification" id="chat-notification">1</span>
    </div>

    <!-- Chat Window -->
    <div id="chat-window" class="chat-window">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chat-title">
                    <h4>Trợ lý AI Giày</h4>
                    <span class="chat-status">Đang trực tuyến</span>
                </div>
            </div>
            <div class="chat-header-actions">
                <button id="chat-history" class="chat-action-btn" title="Xem lịch sử">
                    <i class="fas fa-history"></i>
                </button>
                <button id="chat-clear" class="chat-action-btn" title="Xóa tin nhắn">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button id="chat-minimize" class="chat-minimize">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <!-- Message History Indicator -->
        <div id="history-indicator" class="history-indicator" style="display: none;">
            <button class="load-more-btn" id="load-more-messages">
                <i class="fas fa-chevron-up me-2"></i>
                Xem tin nhắn trước
            </button>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="chat-messages">
            <!-- Welcome Message -->
            <div class="message bot-message" data-message-id="welcome">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <div class="message-text">
                        <strong>👋 Xin chào!</strong><br><br>
                        Tôi có thể giúp bạn:<br>
                        📏 Tư vấn size giày<br>
                        💡 Giải đáp mọi thắc mắc<br><br>
                        Bạn cần hỗ trợ gì hôm nay? 😊
                    </div>
                    <div class="message-time">{{ now()->format('H:i') }}</div>
                </div>
            </div>

            <!-- AI Thinking Message (3 dots loading) -->
            <div class="message ai-thinking-message" id="ai-thinking-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="ai-thinking-bubble">
                    <div class="thinking-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Bottom Button -->
        <button class="scroll-to-bottom" id="scroll-to-bottom">
            <i class="fas fa-chevron-down"></i>
        </button>

        <!-- Product Recommendations Icon (Fixed) -->
        <button class="product-recommendations-toggle" id="product-recommendations-toggle" style="display: none;">
            <i class="fas fa-shopping-bag"></i>
            <span class="recommendations-badge" id="recommendations-badge">0</span>
        </button>

        <!-- Product Recommendations Panel (Expandable) -->
        <div id="product-recommendations-panel" class="product-recommendations-panel">
            <div class="recommendations-panel-header">
                <div class="recommendations-panel-title">
                    <i class="fas fa-sparkles"></i>
                    <span>Sản phẩm gợi ý</span>
                </div>
                <button class="recommendations-panel-close" id="recommendations-panel-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="recommendations-panel-content" id="recommendations-list">
                <!-- Products will be loaded here -->
                <div class="recommendations-empty">
                    <i class="fas fa-box-open"></i>
                    <p>Chưa có sản phẩm gợi ý</p>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-container">
            <form id="chat-form" class="chat-form">
                <div class="input-group">
                    <input type="text" id="chat-input" class="chat-input" placeholder="Nhập câu hỏi của bạn..." autocomplete="off">
                    <button type="submit" class="chat-send-btn" id="chat-send">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            <div class="chat-typing" id="chat-typing">
                <span class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                Trợ lý đang trả lời...
            </div>
        </div>
    </div>
</div>

<!-- Link to Chat Bubble CSS -->
<link rel="stylesheet" href="{{ asset('css/chat-bubble.css') }}">

<!-- Chat Message Handler -->
<script src="{{ asset('js/chat-message-handler.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const historyIndicator = document.getElementById('history-indicator');
    const loadMoreBtn = document.getElementById('load-more-messages');
    const chatHistoryBtn = document.getElementById('chat-history');
    const chatClearBtn = document.getElementById('chat-clear');

    // Simulated message history (trong thực tế sẽ load từ database/localStorage)
    let messageHistory = [];
    let currentPage = 0;
    const messagesPerPage = 10;
    let hasMoreMessages = false;

    // Load chat history from localStorage
    function loadChatHistory() {
        try {
            const savedHistory = localStorage.getItem('chatHistory');
            if (savedHistory) {
                messageHistory = JSON.parse(savedHistory);
                hasMoreMessages = messageHistory.length > 0;
                updateHistoryIndicator();
            }
        } catch (e) {
            console.error('Error loading chat history:', e);
        }
    }

    // Save message to history
    function saveMessageToHistory(message) {
        try {
            messageHistory.unshift(message); // Add to beginning
            // Keep only last 100 messages
            if (messageHistory.length > 100) {
                messageHistory = messageHistory.slice(0, 100);
            }
            localStorage.setItem('chatHistory', JSON.stringify(messageHistory));
            hasMoreMessages = messageHistory.length > messagesPerPage;
            updateHistoryIndicator();
        } catch (e) {
            console.error('Error saving message:', e);
        }
    }

    // Update history indicator visibility
    function updateHistoryIndicator() {
        if (hasMoreMessages && currentPage === 0) {
            historyIndicator.style.display = 'block';
        } else {
            historyIndicator.style.display = 'none';
        }
    }

    // Load more messages
    function loadMoreMessages() {
        const startIndex = currentPage * messagesPerPage;
        const endIndex = startIndex + messagesPerPage;
        const messagesToLoad = messageHistory.slice(startIndex, endIndex);

        if (messagesToLoad.length > 0) {
            const currentScrollHeight = chatMessages.scrollHeight;

            // Insert messages at the top
            messagesToLoad.reverse().forEach(msg => {
                const messageEl = createMessageElement(msg);
                chatMessages.insertBefore(messageEl, chatMessages.firstChild);
            });

            // Maintain scroll position
            const newScrollHeight = chatMessages.scrollHeight;
            chatMessages.scrollTop = newScrollHeight - currentScrollHeight;

            currentPage++;

            // Check if there are more messages
            if (endIndex >= messageHistory.length) {
                hasMoreMessages = false;
                updateHistoryIndicator();
            }
        }
    }

    // Create message element với xử lý text, image, file
    function createMessageElement(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.type}-message`;
        messageDiv.setAttribute('data-message-id', message.id || Date.now());

        let contentHTML = '';

        // Xử lý nội dung text
        if (message.text) {
            contentHTML += `<div class="message-text">${escapeHtml(message.text)}</div>`;
        }

        // Xử lý hình ảnh
        if (message.image) {
            contentHTML += `
                <img src="${message.image}"
                     alt="Image"
                     class="message-image"
                     onclick="window.open('${message.image}', '_blank')"
                     loading="lazy">
            `;
        }

        // Xử lý file đính kèm
        if (message.file) {
            const fileExt = message.file.name.split('.').pop().toLowerCase();
            const fileIcon = getFileIcon(fileExt);
            contentHTML += `
                <div class="message-file" onclick="window.open('${message.file.url}', '_blank')">
                    <div class="file-icon">
                        <i class="${fileIcon}"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${escapeHtml(message.file.name)}</div>
                        <div class="file-size">${formatFileSize(message.file.size)}</div>
                    </div>
                </div>
            `;
        }

        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="${message.type === 'bot' ? 'fas fa-robot' : 'fas fa-user'}"></i>
            </div>
            <div class="message-content">
                ${contentHTML}
                <div class="message-time">${message.time}</div>
            </div>
        `;

        return messageDiv;
    }

    // Escape HTML để tránh XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Lấy icon cho file
    function getFileIcon(extension) {
        const iconMap = {
            'pdf': 'fas fa-file-pdf',
            'doc': 'fas fa-file-word',
            'docx': 'fas fa-file-word',
            'xls': 'fas fa-file-excel',
            'xlsx': 'fas fa-file-excel',
            'ppt': 'fas fa-file-powerpoint',
            'pptx': 'fas fa-file-powerpoint',
            'zip': 'fas fa-file-archive',
            'rar': 'fas fa-file-archive',
            'txt': 'fas fa-file-alt',
            'jpg': 'fas fa-file-image',
            'jpeg': 'fas fa-file-image',
            'png': 'fas fa-file-image',
            'gif': 'fas fa-file-image',
        };
        return iconMap[extension] || 'fas fa-file';
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Check scroll position
    function checkScrollPosition() {
        const scrollTop = chatMessages.scrollTop;
        const scrollThreshold = 50;

        if (scrollTop < scrollThreshold && hasMoreMessages && currentPage === 0) {
            historyIndicator.style.display = 'block';
        }
    }

    // Clear chat history
    function clearChatHistory() {
        if (confirm('Bạn có chắc muốn xóa toàn bộ lịch sử chat?')) {
            localStorage.removeItem('chatHistory');
            messageHistory = [];
            currentPage = 0;
            hasMoreMessages = false;

            // Clear visible messages except welcome message
            const messages = chatMessages.querySelectorAll('.message:not(:first-child)');
            messages.forEach(msg => msg.remove());

            updateHistoryIndicator();

            // Show notification
            showNotification('Đã xóa lịch sử chat', 'success');
        }
    }

    // Show history panel
    function showHistoryPanel() {
        if (messageHistory.length === 0) {
            showNotification('Chưa có lịch sử chat', 'info');
            return;
        }

        // Scroll to top to see older messages
        chatMessages.scrollTo({ top: 0, behavior: 'smooth' });

        if (hasMoreMessages) {
            setTimeout(() => {
                historyIndicator.style.display = 'block';
            }, 300);
        }
    }

    // Show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = 'chat-notification-toast';
        notification.style.cssText = `
            position: fixed;
            bottom: 120px;
            right: 30px;
            background: ${type === 'success' ? '#00b894' : '#667eea'};
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }

    // Event listeners
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMoreMessages);
    }

    if (chatHistoryBtn) {
        chatHistoryBtn.addEventListener('click', showHistoryPanel);
    }

    if (chatClearBtn) {
        chatClearBtn.addEventListener('click', clearChatHistory);
    }

    if (chatMessages) {
        chatMessages.addEventListener('scroll', checkScrollPosition);
    }

    // Auto-scroll to bottom for new messages
    function scrollToBottom(smooth = false) {
        if (smooth) {
            chatMessages.scrollTo({
                top: chatMessages.scrollHeight,
                behavior: 'smooth'
            });
        } else {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Check if user is near bottom
    function isNearBottom() {
        const threshold = 100;
        return chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight < threshold;
    }

    // Show/hide scroll to bottom button
    const scrollToBottomBtn = document.getElementById('scroll-to-bottom');

    function updateScrollButton() {
        if (scrollToBottomBtn) {
            if (isNearBottom()) {
                scrollToBottomBtn.classList.remove('show');
            } else {
                scrollToBottomBtn.classList.add('show');
            }
        }
    }

    // Scroll button click handler
    if (scrollToBottomBtn) {
        scrollToBottomBtn.addEventListener('click', () => {
            scrollToBottom(true);
        });
    }

    // Update scroll button on scroll
    if (chatMessages) {
        chatMessages.addEventListener('scroll', () => {
            updateScrollButton();
            checkScrollPosition();
        });
    }

    // Observer for new messages
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach((node) => {
                    if (node.classList && node.classList.contains('message')) {
                        // Auto scroll if user is near bottom
                        if (isNearBottom()) {
                            setTimeout(() => scrollToBottom(true), 100);
                        } else {
                            updateScrollButton();
                        }
                    }
                });
            }
        });
    });

    observer.observe(chatMessages, { childList: true });

    // Add message to chat (helper function)
    window.addChatMessage = function(messageData) {
        const message = {
            id: messageData.id || Date.now(),
            type: messageData.type || 'bot', // 'bot' hoặc 'user'
            text: messageData.text || null,
            image: messageData.image || null,
            file: messageData.file || null, // { name, url, size }
            time: messageData.time || new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })
        };

        // Save to history
        saveMessageToHistory(message);

        // Add to UI
        const messageEl = createMessageElement(message);
        chatMessages.appendChild(messageEl);

        return message;
    };

    // Initialize
    loadChatHistory();
    scrollToBottom();
    updateScrollButton();

    // ==========================================
    // Product Recommendations Toggle
    // ==========================================
    const recommendationsToggle = document.getElementById('product-recommendations-toggle');
    const recommendationsPanel = document.getElementById('product-recommendations-panel');
    const recommendationsPanelClose = document.getElementById('recommendations-panel-close');
    const recommendationsBadge = document.getElementById('recommendations-badge');

    // Toggle panel
    if (recommendationsToggle) {
        recommendationsToggle.addEventListener('click', () => {
            recommendationsPanel.classList.toggle('show');

            // Update badge to show panel is open
            if (recommendationsPanel.classList.contains('show')) {
                recommendationsToggle.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            } else {
                recommendationsToggle.style.background = 'linear-gradient(135deg, #ff6b6b 0%, #ee5a6e 100%)';
            }
        });
    }

    // Close panel
    if (recommendationsPanelClose) {
        recommendationsPanelClose.addEventListener('click', () => {
            recommendationsPanel.classList.remove('show');
            recommendationsToggle.style.background = 'linear-gradient(135deg, #ff6b6b 0%, #ee5a6e 100%)';
        });
    }

    // Close panel when clicking outside
    document.addEventListener('click', (e) => {
        if (recommendationsPanel && recommendationsPanel.classList.contains('show')) {
            if (!recommendationsPanel.contains(e.target) &&
                !recommendationsToggle.contains(e.target)) {
                recommendationsPanel.classList.remove('show');
                recommendationsToggle.style.background = 'linear-gradient(135deg, #ff6b6b 0%, #ee5a6e 100%)';
            }
        }
    });

    // Global function to show recommendations
    window.showProductRecommendations = function(products) {
        if (!products || products.length === 0) {
            recommendationsToggle.classList.remove('show');
            return;
        }

        // Update badge
        recommendationsBadge.textContent = products.length;

        // Show toggle button
        recommendationsToggle.classList.add('show');

        // Generate product items
        const recommendationsList = document.getElementById('recommendations-list');
        const emptyState = recommendationsList.querySelector('.recommendations-empty');

        if (emptyState) {
            emptyState.remove();
        }

        recommendationsList.innerHTML = products.map(product => `
            <a href="${product.url || '#'}" class="recommendation-item" ${product.target ? `target="${product.target}"` : ''}>
                <img src="${product.image}" alt="${product.name}" class="recommendation-image" loading="lazy">
                <div class="recommendation-info">
                    <div class="recommendation-name">${product.name}</div>
                    <div class="recommendation-price">
                        ${product.price}
                        ${product.originalPrice ? `<span class="recommendation-original-price">${product.originalPrice}</span>` : ''}
                    </div>
                </div>
            </a>
        `).join('');

        // Auto show notification
        showRecommendationNotification(products.length);
    };

    // Hide recommendations
    window.hideProductRecommendations = function() {
        recommendationsToggle.classList.remove('show');
        recommendationsPanel.classList.remove('show');
    };

    // Show notification when recommendations available
    function showRecommendationNotification(count) {
        const notification = document.createElement('div');
        notification.className = 'chat-notification-toast';
        notification.style.cssText = `
            position: fixed;
            bottom: 200px;
            right: 30px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6e 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255,107,107,0.4);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
        `;
        notification.innerHTML = `<i class="fas fa-shopping-bag" style="margin-right: 8px;"></i>Có ${count} sản phẩm gợi ý cho bạn!`;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>
