/**
 * AI Chat Widget JavaScript
 * Handles chat interactions with Gemini AI
 */

class AIChatWidget {
    constructor() {
        this.isOpen = false;
        this.isTyping = false;
        this.context = {};
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadContext();
        this.setupNotificationCounter();
    }

    bindEvents() {
        // Toggle chat window
        $('#chat-toggle').on('click', () => this.toggleChat());
        $('#chat-minimize').on('click', () => this.toggleChat());

        // Send message
        $('#chat-form').on('submit', (e) => {
            e.preventDefault();
            this.sendMessage();
        });

        // Quick suggestions
        $(document).on('click', '.suggestion-btn', (e) => {
            const text = $(e.target).data('text');
            this.sendQuickMessage(text);
        });

        // Enter key to send
        $('#chat-input').on('keypress', (e) => {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Auto-resize input
        $('#chat-input').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Click outside to close (optional)
        $(document).on('click', (e) => {
            if (this.isOpen && !$(e.target).closest('#ai-chat-widget').length) {
                // Uncomment to enable click-outside-to-close
                // this.toggleChat();
            }
        });
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        
        if (this.isOpen) {
            $('#chat-window').fadeIn(300);
            $('#chat-input').focus();
            this.hideNotification();
            this.loadQuickSuggestions();
        } else {
            $('#chat-window').fadeOut(300);
        }
    }

    async sendMessage() {
        const input = $('#chat-input');
        const message = input.val().trim();
        
        if (!message || this.isTyping) return;

        // Add user message to chat
        this.addMessage(message, 'user');
        input.val('');
        
        // Show typing indicator
        this.showTyping();
        
        try {
            const response = await this.callChatAPI(message);
            this.hideTyping();
            
            if (response.success) {
                // Add AI response
                this.addMessage(response.response.message, 'bot');
                
                // Show product recommendations if any
                if (response.recommendations && response.recommendations.length > 0) {
                    this.showRecommendations(response.recommendations);
                }
                
                // Update suggestions if any
                if (response.response.suggestions && response.response.suggestions.length > 0) {
                    this.updateSuggestions(response.response.suggestions);
                }
            } else {
                this.addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại.', 'bot');
            }
        } catch (error) {
            console.error('Chat error:', error);
            this.hideTyping();
            this.addMessage('Không thể kết nối với server. Vui lòng thử lại sau.', 'bot');
        }
    }

    async sendQuickMessage(text) {
        $('#chat-input').val(text);
        await this.sendMessage();
    }

    async callChatAPI(message) {
        const response = await fetch('/api/chat/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                message: message,
                context: this.context
            })
        });

        if (!response.ok) {
            throw new Error('Network error');
        }

        return await response.json();
    }

    addMessage(text, type) {
        const time = new Date().toLocaleTimeString('vi-VN', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        const avatarIcon = type === 'bot' ? 'fas fa-robot' : 'fas fa-user';
        
        const messageHtml = `
            <div class="message ${type}-message">
                <div class="message-avatar">
                    <i class="${avatarIcon}"></i>
                </div>
                <div class="message-content">
                    <div class="message-text">${this.formatMessage(text)}</div>
                    <div class="message-time">${time}</div>
                </div>
            </div>
        `;
        
        $('#chat-messages').append(messageHtml);
        this.scrollToBottom();
    }

    formatMessage(text) {
        // Convert URLs to links
        text = text.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');
        
        // Convert line breaks to HTML
        text = text.replace(/\n/g, '<br>');
        
        // Make text bold between **
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        
        return text;
    }

    showTyping() {
        this.isTyping = true;
        $('#chat-typing').show();
        $('#chat-send').prop('disabled', true);
        this.scrollToBottom();
    }

    hideTyping() {
        this.isTyping = false;
        $('#chat-typing').hide();
        $('#chat-send').prop('disabled', false);
    }

    scrollToBottom() {
        const messagesContainer = $('#chat-messages');
        messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
    }

    showRecommendations(recommendations) {
        let recommendationsHtml = '';
        
        recommendations.forEach(product => {
            const imageUrl = product.image || '/img/shop/placeholder.webp';
            const price = new Intl.NumberFormat('vi-VN').format(product.price);
            
            recommendationsHtml += `
                <a href="${product.url}" class="recommendation-item" target="_blank">
                    <img src="${imageUrl}" alt="${product.name}" class="recommendation-image">
                    <div class="recommendation-info">
                        <div class="recommendation-name">${product.name}</div>
                        <div class="recommendation-price">₫${price}</div>
                    </div>
                </a>
            `;
        });
        
        $('#recommendations-list').html(recommendationsHtml);
        $('#product-recommendations').show();
    }

    updateSuggestions(suggestions) {
        let suggestionsHtml = '';
        
        suggestions.forEach(suggestion => {
            suggestionsHtml += `
                <button class="suggestion-btn" data-text="${suggestion}">${suggestion}</button>
            `;
        });
        
        $('.suggestions-list').html(suggestionsHtml);
    }

    async loadQuickSuggestions() {
        try {
            const response = await fetch('/api/chat/suggestions');
            const data = await response.json();
            
            if (data.success) {
                this.updateSuggestions(data.suggestions.slice(0, 4));
            }
        } catch (error) {
            console.error('Failed to load suggestions:', error);
        }
    }

    async loadContext() {
        try {
            // Get current page context
            const urlParams = new URLSearchParams(window.location.search);
            const pathParts = window.location.pathname.split('/');
            
            const contextData = {};
            
            // Check if on product page
            if (pathParts.includes('product') && pathParts[pathParts.length - 1]) {
                contextData.product_id = pathParts[pathParts.length - 1];
            }
            
            // Check if on category page
            if (urlParams.has('category')) {
                contextData.category_id = urlParams.get('category');
            }

            const response = await fetch('/api/chat/context', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(contextData)
            });
            
            const data = await response.json();
            if (data.success) {
                this.context = data.context;
            }
        } catch (error) {
            console.error('Failed to load context:', error);
        }
    }

    setupNotificationCounter() {
        // Show notification if first visit
        if (!localStorage.getItem('chat-visited')) {
            this.showNotification();
        }
    }

    showNotification() {
        $('#chat-notification').show();
    }

    hideNotification() {
        $('#chat-notification').hide();
        localStorage.setItem('chat-visited', 'true');
    }

    // Public methods for external integration
    openChat() {
        if (!this.isOpen) {
            this.toggleChat();
        }
    }

    sendContextMessage(message, context = {}) {
        this.context = { ...this.context, ...context };
        $('#chat-input').val(message);
        this.sendMessage();
        this.openChat();
    }
}

// Initialize chat widget when DOM is ready
$(document).ready(function() {
    window.aiChat = new AIChatWidget();
});

// Global functions for integration
window.openAIChat = function() {
    if (window.aiChat) {
        window.aiChat.openChat();
    }
};

window.sendAIChatMessage = function(message, context = {}) {
    if (window.aiChat) {
        window.aiChat.sendContextMessage(message, context);
    }
};