# Module Quản lý Banner Trang chủ

## Tổng quan
Module Banner cho phép quản lý các banner hiển thị trên trang chủ với đầy đủ chức năng CRUD (Create, Read, Update, Delete) và các tính năng nâng cao.

## Tính năng

### 1. Quản lý Banner (Admin Panel)
- **Thêm banner mới**: Upload hình ảnh, thêm tiêu đề, mô tả, link
- **Chỉnh sửa banner**: Cập nhật thông tin và hình ảnh
- **Xóa banner**: Xóa banner không cần thiết
- **Bật/tắt hiển thị**: Toggle trạng thái hiển thị banner
- **Sắp xếp thứ tự**: Điều chỉnh thứ tự hiển thị
- **Lên lịch hiển thị**: Đặt ngày bắt đầu và kết thúc

### 2. Hiển thị Frontend
- **Slider tự động**: Banner tự động chuyển đổi
- **Navigation**: Nút điều hướng và dots indicator
- **Responsive**: Tối ưu cho mobile và desktop
- **SEO friendly**: Alt text và structured data

## Cấu trúc File

### Models
- `app/Models/Banner.php` - Model chính với relationships và scopes

### Database
- `database/migrations/2025_01_16_000000_create_banners_table.php` - Migration tạo bảng
- `database/factories/BannerFactory.php` - Factory tạo dữ liệu test
- `database/seeders/BannerSeeder.php` - Seeder tạo dữ liệu mẫu

### Filament Admin
- `app/Filament/Resources/BannerResource.php` - Resource chính
- `app/Filament/Resources/BannerResource/Schemas/BannerForm.php` - Form schema
- `app/Filament/Resources/BannerResource/Tables/BannersTable.php` - Table configuration
- `app/Filament/Resources/BannerResource/Pages/` - Các page (List, Create, Edit)

### Controllers & Routes
- `app/Http/Controllers/BannerController.php` - API controller
- `routes/api.php` - API route `/api/banners`

### Views
- `resources/views/components/banner-slider.blade.php` - Component hiển thị slider

## Cách sử dụng

### 1. Truy cập Admin Panel
1. Đăng nhập vào admin panel
2. Tìm menu "Banners" trong navigation
3. Click để quản lý banners

### 2. Tạo Banner mới
1. Click "Tạo banner mới"
2. Điền thông tin:
   - **Tiêu đề**: Tên banner
   - **Mô tả**: Mô tả ngắn (tùy chọn)
   - **Link URL**: Đường dẫn khi click banner (tùy chọn)
   - **Hình ảnh**: Upload file ảnh (bắt buộc)
   - **Hiển thị**: Bật/tắt hiển thị
   - **Thứ tự**: Số thứ tự sắp xếp
   - **Ngày bắt đầu/kết thúc**: Lên lịch hiển thị (tùy chọn)

### 3. Hiển thị trên Frontend
Thêm component vào view:
```blade
<x-banner-slider :banners="$banners" />
```

Hoặc sử dụng API:
```javascript
fetch('/api/banners')
  .then(response => response.json())
  .then(banners => {
    // Xử lý hiển thị banners
  });
```

### 4. Trong Controller
```php
use App\Http\Controllers\BannerController;

public function index()
{
    $banners = BannerController::getHomepageBanners();
    return view('home', compact('banners'));
}
```

## Database Schema

### Bảng `banners`
| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | bigint | Primary key |
| title | string | Tiêu đề banner |
| description | text | Mô tả (nullable) |
| link_url | string | URL liên kết (nullable) |
| is_active | boolean | Trạng thái hiển thị |
| sort_order | integer | Thứ tự sắp xếp |
| start_date | datetime | Ngày bắt đầu (nullable) |
| end_date | datetime | Ngày kết thúc (nullable) |
| created_at | timestamp | Ngày tạo |
| updated_at | timestamp | Ngày cập nhật |

### Media Library
Sử dụng Spatie Media Library để quản lý hình ảnh:
- Collection: `banner_image`
- Conversions: `thumb` (300x200px)

## API Endpoints

### GET /api/banners
Lấy danh sách banner active đang trong thời gian hiệu lực.

**Response:**
```json
[
  {
    "id": 1,
    "title": "Banner khuyến mãi mùa hè",
    "description": "Giảm giá đến 50%...",
    "link_url": "/promotions/summer-sale",
    "image_url": "/storage/banners/image.jpg",
    "thumb_url": "/storage/banners/conversions/image-thumb.jpg"
  }
]
```

## Model Methods

### Scopes
- `active()` - Lọc banner đang active
- `inDateRange()` - Lọc banner trong thời gian hiệu lực

### Attributes
- `image_url` - URL hình ảnh gốc
- `thumb_url` - URL hình ảnh thumbnail

## Cấu hình

### File Upload
- **Thư mục**: `storage/app/public/banners/`
- **Kích thước tối đa**: 5MB
- **Định dạng**: JPG, PNG, GIF, WebP
- **Tỷ lệ khung hình**: 16:9, 4:3, 1:1

### Auto-slide
- **Thời gian**: 5 giây
- **Transition**: 300ms ease-in-out

## Tính năng nâng cao

### 1. Responsive Images
Banner tự động tối ưu cho các thiết bị khác nhau.

### 2. SEO Optimization
- Alt text cho hình ảnh
- Structured data markup
- Fast loading với lazy loading

### 3. Performance
- Image optimization với conversions
- Caching với model relationships
- Minimal DOM manipulation

## Troubleshooting

### 1. Banner không hiển thị
- Kiểm tra `is_active = true`
- Kiểm tra `start_date` và `end_date`
- Kiểm tra file hình ảnh tồn tại

### 2. Lỗi upload hình ảnh
- Kiểm tra quyền thư mục `storage/`
- Kiểm tra kích thước file < 5MB
- Kiểm tra định dạng file được hỗ trợ

### 3. Admin panel không load
- Chạy `php artisan route:clear`
- Chạy `php artisan config:clear`
- Kiểm tra Filament version compatibility

## Migration Commands

```bash
# Chạy migration
php artisan migrate

# Seed dữ liệu mẫu
php artisan db:seed --class=BannerSeeder

# Tạo symbolic link cho storage
php artisan storage:link
```

## Kết luận
Module Banner đã được tích hợp hoàn chỉnh với:
- ✅ CRUD operations
- ✅ File upload với Media Library
- ✅ Admin panel với Filament
- ✅ API endpoints
- ✅ Frontend components
- ✅ Database migrations và seeders
- ✅ Responsive design
- ✅ SEO optimization