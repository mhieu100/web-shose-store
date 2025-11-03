<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khôi phục mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            margin-bottom: 30px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .button:hover {
            opacity: 0.9;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            padding: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #eee;
        }
        .note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .url-fallback {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            word-break: break-all;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Khôi phục mật khẩu</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $user->name }}</strong>,
            </div>

            <div class="message">
                <p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>

                <p>Để tiếp tục đặt lại mật khẩu, vui lòng nhấp vào nút bên dưới:</p>
            </div>

            <div class="button-container">
                <a href="{{ $resetUrl }}" class="button">
                    Đặt lại mật khẩu
                </a>
            </div>

            <div class="note">
                <strong>⏰ Lưu ý quan trọng:</strong><br>
                Link này sẽ hết hạn sau <strong>24 giờ</strong>. Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.
            </div>

            <div class="message">
                <p>Nếu bạn gặp vấn đề khi nhấp vào nút "Đặt lại mật khẩu", hãy sao chép và dán URL sau vào trình duyệt web của bạn:</p>
            </div>

            <div class="url-fallback">
                {{ $resetUrl }}
            </div>

            <div class="message" style="margin-top: 30px;">
                <p><strong>Lưu ý bảo mật:</strong></p>
                <ul>
                    <li>Không chia sẻ link này với bất kỳ ai</li>
                    <li>Chúng tôi sẽ không bao giờ yêu cầu mật khẩu của bạn qua email</li>
                    <li>Nếu bạn không yêu cầu đặt lại mật khẩu, hãy liên hệ ngay với chúng tôi</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>
