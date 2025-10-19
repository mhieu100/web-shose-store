# Hướng dẫn cấu hình Email thông báo đặt hàng

## Tổng quan
Hệ thống đã được cấu hình để tự động gửi email xác nhận khi khách hàng đặt hàng thành công tại `http://127.0.0.1:8000/checkout`.

## Cách thức hoạt động
1. Khi khách hàng hoàn tất đặt hàng tại checkout, đơn hàng mới được tạo
2. `OrderObserver` tự động được kích hoạt
3. Email xác nhận được gửi đến địa chỉ email của khách hàng
4. Email bao gồm:
   - Thông tin đơn hàng chi tiết
   - Danh sách sản phẩm
   - Tổng tiền và phí
   - Địa chỉ giao hàng
   - Hướng dẫn thanh toán (tùy theo phương thức)
   - Link xem chi tiết đơn hàng

## Cấu hình Email

### Option 1: Sử dụng MailHog cho development (Đã cấu hình sẵn)
```env
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@yourstore.com"
MAIL_FROM_NAME="Your Store Name"
```

### Option 2: Sử dụng Gmail SMTP
1. Tạo App Password cho Gmail:
   - Vào Google Account Settings
   - Security → 2-Step Verification → App passwords
   - Tạo password mới cho ứng dụng

2. Cập nhật file `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="Your Store Name"
```

### Option 3: Sử dụng Mailtrap (cho testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourstore.com"
MAIL_FROM_NAME="Your Store Name"
```

## Test Email System

### 1. Kiểm tra cấu hình
```bash
php artisan tinker
```

Trong tinker console:
```php
// Test basic mail configuration
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test');
});

// Test order confirmation email với order thật
$order = App\Models\Shop\Order::latest()->first();
Mail::to('your-email@example.com')->send(new App\Mail\OrderConfirmationMail($order));
```

### 2. Kiểm tra queue (nếu sử dụng)
```bash
# Xem jobs trong queue
php artisan queue:work

# Hoặc chạy jobs immediately
php artisan queue:work --once
```

### 3. Test thực tế
1. Truy cập `http://127.0.0.1:8000`
2. Đăng ký tài khoản với email thật
3. Thêm sản phẩm vào giỏ hàng
4. Tiến hành checkout
5. Kiểm tra email inbox

## Xử lý lỗi

### Log files
Kiểm tra log tại `storage/logs/laravel.log` để debug:
```bash
tail -f storage/logs/laravel.log
```

### Các lỗi thường gặp

1. **Email không được gửi:**
   - Kiểm tra cấu hình SMTP
   - Kiểm tra queue worker đang chạy
   - Kiểm tra user có email không

2. **Template lỗi:**
   - Kiểm tra file `resources/views/emails/order-confirmation.blade.php`
   - Kiểm tra route `account.order-details` có tồn tại không

3. **SMTP Authentication failed:**
   - Kiểm tra username/password
   - Đối với Gmail, sử dụng App Password thay vì password thường

## Files liên quan
- `app/Mail/OrderConfirmationMail.php` - Mail class
- `resources/views/emails/order-confirmation.blade.php` - Email template
- `app/Observers/OrderObserver.php` - Observer gửi email
- `config/mail.php` - Mail configuration

## Customization

### Thay đổi nội dung email
Chỉnh sửa file `resources/views/emails/order-confirmation.blade.php`

### Thay đổi thời điểm gửi email
Chỉnh sửa `app/Observers/OrderObserver.php` hoặc thêm logic vào CheckoutController

### Thêm email cho admin
Trong `OrderObserver::sendOrderConfirmationEmail()`, thêm:
```php
// Send to admin
Mail::to(config('mail.admin_email'))->send(new OrderNotificationMail($order));
```

## Production Notes
- Sử dụng queue system (Redis/Database) cho production
- Cấu hình retry mechanism cho failed emails
- Monitor email delivery rates
- Sử dụng dedicated SMTP service (SendGrid, Mailgun, SES)