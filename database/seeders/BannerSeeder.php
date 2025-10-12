<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample banners
        $banners = [
            [
                'title' => 'Banner khuyến mãi mùa hè',
                'description' => 'Giảm giá đến 50% cho tất cả sản phẩm thời trang mùa hè',
                'link_url' => '/promotions/summer-sale',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Sản phẩm mới 2024',
                'description' => 'Khám phá bộ sưu tập mới nhất với thiết kế hiện đại',
                'link_url' => '/products/new-collection',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Miễn phí vận chuyển',
                'description' => 'Miễn phí vận chuyển cho đơn hàng từ 500.000đ',
                'link_url' => '/shipping-policy',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($banners as $bannerData) {
            $banner = Banner::create($bannerData);

            // Add a sample image from the local images if available
            $imageDir = database_path('seeders/local_images/1280x720');
            if (File::exists($imageDir)) {
                $images = File::files($imageDir);
                if (!empty($images)) {
                    $randomImage = $images[array_rand($images)];
                    $banner->addMedia($randomImage->getPathname())
                        ->toMediaCollection('banner_image');
                }
            }
        }

        // Create additional random banners
        Banner::factory(5)->create();
    }
}