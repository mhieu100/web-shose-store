# Page Header Images

This directory contains header/hero background images used across the website.

## Current Configuration

The default page header background image is configured in `config/app.php`:

```php
'page_header_image' => env('PAGE_HEADER_IMAGE', '/img/headers/hero-1930x390.jpg'),
```

## Files

- **hero-1930x390.jpg** - Default page header background (1930x390px)
  - Used across all pages with `.page-header-area` sections
  - Shop pages, blog, cart, checkout, product details, etc.

## Usage in Blade Templates

All page header sections now reference the centralized config:

```blade
<div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
```

## Customization

To use a different header image:

1. **Option 1**: Replace `hero-1930x390.jpg` with your own image (keep same dimensions)
2. **Option 2**: Add new image and update config/app.php
3. **Option 3**: Set environment variable in `.env`:
   ```
   PAGE_HEADER_IMAGE=/img/headers/your-custom-image.jpg
   ```

## Image Specifications

- **Recommended dimensions**: 1930px × 390px
- **Format**: JPG or WebP
- **Max file size**: ~200KB for optimal loading
- **Content**: Should work well with white text overlay
