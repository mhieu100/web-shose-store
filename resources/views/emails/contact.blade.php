<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ từ website</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
        }
        .message-content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📧 Tin nhắn liên hệ mới</h1>
            <p>Bạn có một tin nhắn liên hệ mới từ website</p>
        </div>

        <div class="info-row">
            <div class="info-label">👤 Họ và tên:</div>
            <div class="info-value">{{ $contactData['name'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">📧 Email:</div>
            <div class="info-value">
                <a href="mailto:{{ $contactData['email'] }}" style="color: #007bff; text-decoration: none;">
                    {{ $contactData['email'] }}
                </a>
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">📝 Tiêu đề:</div>
            <div class="info-value">{{ $contactData['subject'] }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">💬 Nội dung tin nhắn:</div>
            <div class="message-content">
                {!! nl2br(e($contactData['message'])) !!}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">🕐 Thời gian gửi:</div>
            <div class="info-value">{{ $contactData['sent_at'] }}</div>
        </div>

        <div class="footer">
            <p>Email này được gửi tự động từ form liên hệ trên website.<br>
            Vui lòng phản hồi trực tiếp cho khách hàng qua email: <strong>{{ $contactData['email'] }}</strong></p>
        </div>
    </div>
</body>
</html>