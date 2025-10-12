<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Link;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $links = [
            ['title' => 'VnExpress - Báo điện tử hàng đầu Việt Nam', 'url' => 'https://vnexpress.net', 'desc' => 'Tin tức nhanh và chính xác nhất'],
            ['title' => 'Tiki - Mua sắm trực tuyến', 'url' => 'https://tiki.vn', 'desc' => 'Siêu thị trực tuyến hàng đầu Việt Nam'],
            ['title' => 'Shopee Vietnam', 'url' => 'https://shopee.vn', 'desc' => 'Nền tảng thương mại điện tử'],
            ['title' => 'Zalo - Ứng dụng nhắn tin', 'url' => 'https://zalo.me', 'desc' => 'Ứng dụng nhắn tin phổ biến tại Việt Nam'],
            ['title' => 'VTC News', 'url' => 'https://vtc.vn', 'desc' => 'Kênh tin tức và giải trí'],
            ['title' => 'Sendo - Mua bán online', 'url' => 'https://sendo.vn', 'desc' => 'Sàn thương mại điện tử Việt Nam'],
            ['title' => 'FPT Edu - Giáo dục', 'url' => 'https://fpt.edu.vn', 'desc' => 'Hệ thống giáo dục FPT'],
            ['title' => 'VinID - Ứng dụng tiện ích', 'url' => 'https://vinid.net', 'desc' => 'Siêu ứng dụng của Vingroup']
        ];
        
        $link = $this->faker->unique()->randomElement($links);
        
        return [
            'url' => $link['url'],
            'title' => [
                'vi' => $link['title'],
                'en' => $link['title'],
            ],
            'description' => [
                'vi' => $link['desc'],
                'en' => $link['desc'],
            ],
            'color' => $this->faker->hexColor(),
        ];
    }

    public function configure(): LinkFactory
    {
        return $this->afterCreating(function (Link $product): void {
            $product
                ->addMedia(LocalImages::getRandomFile(LocalImages::SIZE_1280x720))
                ->preservingOriginal()
                ->toMediaCollection('link-images');
        });
    }
}
