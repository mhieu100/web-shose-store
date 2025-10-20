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

---

# Hướng dẫn cấu hình Form Liên hệ

## Tổng quan
Form liên hệ tại `http://127.0.0.1:8000/contact` đã được cấu hình để gửi email thông báo khi khách hàng gửi tin nhắn.

## Cách thức hoạt động
1. Khách hàng điền form liên hệ và gửi
2. `ContactController` xử lý validation và gửi email
3. Email được gửi đến admin email đã cấu hình
4. Hiển thị thông báo thành công/lỗi cho người dùng

## Cấu hình cho Form Liên hệ

### 1. Cấu hình Gmail SMTP (Khuyến nghị)

#### Bước 1: Tạo App Password cho Gmail
1. Đăng nhập vào Gmail
2. Vào **Google Account Settings** → **Security**
3. Bật **2-Step Verification** (nếu chưa có)
4. Vào **App passwords** 
5. Chọn **Mail** và **Other (custom name)**, đặt tên "Website Contact Form"
6. Copy App Password 16 ký tự được tạo

#### Bước 2: Cấu hình file .env
```env
# Email Configuration for Contact Form
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="Cửa hàng giày"

# Email nhận thông báo liên hệ từ khách hàng
MAIL_ADMIN_EMAIL=admin@yourdomain.com
```

### 2. Cập nhật cấu hình admin email

Thêm vào file `config/mail.php` (trước dòng return):
```php
/*
|--------------------------------------------------------------------------
| Admin Email Address
|--------------------------------------------------------------------------
|
| This is the email address where contact form submissions will be sent.
|
*/
'admin_email' => env('MAIL_ADMIN_EMAIL', 'admin@example.com'),
```

### 3. Test Form Liên hệ

#### Test cơ bản:
```bash
php artisan tinker
```

Trong tinker:
```php
// Test contact email
$contactData = [
    'name' => 'Nguyễn Văn A',
    'email' => 'test@example.com',
    'subject' => 'Test liên hệ',
    'message' => 'Đây là tin nhắn test',
    'sent_at' => now()->format('d/m/Y H:i:s')
];

Mail::to('your-admin@gmail.com')->send(new App\Mail\ContactMail($contactData));
```

#### Test thực tế:
1. Truy cập `http://127.0.0.1:8000/contact`
2. Điền đầy đủ thông tin form
3. Nhấn "Gửi tin nhắn"
4. Kiểm tra email admin có nhận được không

## Files liên quan đến Form Liên hệ
- `app/Http/Controllers/ContactController.php` - Controller xử lý form
- `app/Mail/ContactMail.php` - Mail class cho liên hệ
- `resources/views/emails/contact.blade.php` - Template email liên hệ
- `resources/views/pages/contact.blade.php` - Trang form liên hệ
- `routes/web.php` - Routes cho contact

## Tính năng Form Liên hệ
- ✅ Validation tiếng Việt
- ✅ AJAX submission (không reload trang)
- ✅ Loading state khi gửi
- ✅ Thông báo thành công/lỗi
- ✅ Email template đẹp có styling
- ✅ Reply-to tự động đến email khách hàng
- ✅ Auto scroll đến thông báo

## Troubleshooting Form Liên hệ

### Lỗi thường gặp:

1. **Email không được gửi:**
```bash
# Kiểm tra log
tail -f storage/logs/laravel.log

# Kiểm tra cấu hình mail
php artisan config:cache
```

2. **SMTP Authentication failed:**
- Kiểm tra App Password Gmail
- Đảm bảo 2-Step Verification đã bật
- Kiểm tra MAIL_USERNAME và MAIL_PASSWORD trong .env

3. **Form không submit:**
- Kiểm tra JavaScript console có lỗi không
- Đảm bảo jQuery đã load
- Kiểm tra route `contact.send` có hoạt động không

### Debug commands:
```bash
# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Check routes
php artisan route:list | grep contact
```