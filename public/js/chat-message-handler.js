/**
 * Chat Message Handler
 * Xử lý các loại tin nhắn: text, image, file
 */

// Gửi tin nhắn text
function sendTextMessage(text, type = 'user') {
    if (!text || !text.trim()) return null;

    return window.addChatMessage({
        type: type,
        text: text.trim(),
        time: getCurrentTime()
    });
}

// Gửi tin nhắn với hình ảnh
function sendImageMessage(imageUrl, caption = null, type = 'user') {
    if (!imageUrl) return null;

    return window.addChatMessage({
        type: type,
        text: caption,
        image: imageUrl,
        time: getCurrentTime()
    });
}

// Gửi tin nhắn với file
function sendFileMessage(file, type = 'user') {
    if (!file || !file.name || !file.url) return null;

    return window.addChatMessage({
        type: type,
        file: {
            name: file.name,
            url: file.url,
            size: file.size || 0
        },
        time: getCurrentTime()
    });
}

// Gửi tin nhắn hỗn hợp (text + image hoặc text + file)
function sendMixedMessage(options) {
    const { type = 'user', text, image, file } = options;

    return window.addChatMessage({
        type: type,
        text: text || null,
        image: image || null,
        file: file || null,
        time: getCurrentTime()
    });
}

// Lấy thời gian hiện tại định dạng HH:mm
function getCurrentTime() {
    return new Date().toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Format timestamp thành định dạng dễ đọc
function formatMessageTime(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 1) return 'Vừa xong';
    if (diffMins < 60) return `${diffMins} phút trước`;
    if (diffHours < 24) return `${diffHours} giờ trước`;
    if (diffDays < 7) return `${diffDays} ngày trước`;

    return date.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Hiển thị trạng thái typing (3 chấm trong bubble)
function showTypingIndicator() {
    const aiThinking = document.getElementById('ai-thinking-message');
    if (aiThinking) {
        aiThinking.classList.add('show');
        // Auto scroll to show thinking indicator
        scrollToBottomSmooth();
    }
}

// Ẩn trạng thái typing
function hideTypingIndicator() {
    const aiThinking = document.getElementById('ai-thinking-message');
    if (aiThinking) {
        aiThinking.classList.remove('show');
    }
}

// Helper: Smooth scroll to bottom
function scrollToBottomSmooth() {
    const chatMessages = document.getElementById('chat-messages');
    if (chatMessages) {
        chatMessages.scrollTo({
            top: chatMessages.scrollHeight,
            behavior: 'smooth'
        });
    }
}

// Simulate bot typing và gửi response
function sendBotResponse(message, delay = 1500) {
    return new Promise((resolve) => {
        // Hiển thị 3 chấm thinking
        showTypingIndicator();

        setTimeout(() => {
            // Ẩn 3 chấm
            hideTypingIndicator();

            // Hiển thị message thực
            const botMessage = typeof message === 'string'
                ? sendTextMessage(message, 'bot')
                : window.addChatMessage({ ...message, type: 'bot' });

            resolve(botMessage);
        }, delay);
    });
}// Validate và upload file (cần implement backend)
async function uploadFile(fileInput) {
    const file = fileInput.files[0];
    if (!file) return null;

    // Validate file size (max 10MB)
    const maxSize = 10 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('File quá lớn! Vui lòng chọn file nhỏ hơn 10MB.');
        return null;
    }

    // Validate file type
    const allowedTypes = [
        'image/jpeg', 'image/png', 'image/gif',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (!allowedTypes.includes(file.type)) {
        alert('Loại file không được hỗ trợ!');
        return null;
    }

    try {
        // TODO: Implement actual file upload to server
        // const formData = new FormData();
        // formData.append('file', file);
        // const response = await fetch('/api/upload', { method: 'POST', body: formData });
        // const data = await response.json();
        // return data;

        // Mock response for demo
        return {
            name: file.name,
            url: URL.createObjectURL(file),
            size: file.size,
            type: file.type
        };
    } catch (error) {
        console.error('Upload error:', error);
        alert('Có lỗi xảy ra khi upload file!');
        return null;
    }
}

// Xử lý paste image từ clipboard
function handlePasteImage(event) {
    const items = event.clipboardData?.items;
    if (!items) return;

    for (let item of items) {
        if (item.type.indexOf('image') !== -1) {
            const blob = item.getAsFile();
            const reader = new FileReader();

            reader.onload = function(e) {
                sendImageMessage(e.target.result, 'Hình ảnh từ clipboard');
            };

            reader.readAsDataURL(blob);
            event.preventDefault();
            break;
        }
    }
}

// Clear all messages
function clearAllMessages() {
    const chatMessages = document.getElementById('chat-messages');
    if (!chatMessages) return;

    // Keep welcome message
    const welcomeMessage = chatMessages.querySelector('[data-message-id="welcome"]');
    chatMessages.innerHTML = '';

    if (welcomeMessage) {
        chatMessages.appendChild(welcomeMessage);
    }
}

// Add product recommendations
function addProductRecommendations(products) {
    if (typeof window.showProductRecommendations === 'function') {
        window.showProductRecommendations(products);
    }
}

// Hide product recommendations
function hideProductRecommendations() {
    if (typeof window.hideProductRecommendations === 'function') {
        window.hideProductRecommendations();
    }
}

// Export functions for global use
if (typeof window !== 'undefined') {
    window.ChatMessageHandler = {
        sendTextMessage,
        sendImageMessage,
        sendFileMessage,
        sendMixedMessage,
        sendBotResponse,
        showTypingIndicator,
        hideTypingIndicator,
        scrollToBottomSmooth,
        uploadFile,
        handlePasteImage,
        clearAllMessages,
        formatMessageTime,
        getCurrentTime,
        addProductRecommendations,
        hideProductRecommendations
    };
}
