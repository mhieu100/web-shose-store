<?php

namespace Database\Seeders;

use App\Models\Shop\Coupon;
use App\Models\Shop\Product;
use App\Enums\CouponType;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // Create some predefined coupons
        $predefinedCoupons = [
            [
                'code' => 'WELCOME2025',
                'name' => 'Chào mừng năm mới 2025',
                'description' => 'Mã giảm giá chào mừng năm mới dành cho khách hàng mới',
                'type' => CouponType::Percentage,
                'value' => 15,
                'minimum_amount' => 200000,
                'maximum_amount' => 100000,
                'usage_limit' => 500,
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'Miễn phí vận chuyển',
                'description' => 'Giảm 30.000đ phí vận chuyển cho đơn hàng từ 500.000đ',
                'type' => CouponType::FixedAmount,
                'value' => 30000,
                'minimum_amount' => 500000,
                'usage_limit' => 1000,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'BIGDEAL50',
                'name' => 'Siêu khuyến mãi 50%',
                'description' => 'Giảm 50% cho đơn hàng từ 1 triệu đồng',
                'type' => CouponType::Percentage,
                'value' => 50,
                'minimum_amount' => 1000000,
                'maximum_amount' => 500000,
                'usage_limit' => 100,
                'starts_at' => now()->addDays(7),
                'expires_at' => now()->addDays(14),
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED2024',
                'name' => 'Mã đã hết hạn',
                'description' => 'Mã giảm giá năm 2024 đã hết hạn',
                'type' => CouponType::Percentage,
                'value' => 20,
                'usage_limit' => 200,
                'used_count' => 150,
                'starts_at' => now()->subMonths(2),
                'expires_at' => now()->subDays(10),
                'is_active' => false,
            ],
            [
                'code' => 'FUTURE2025',
                'name' => 'Khuyến mãi tương lai',
                'description' => 'Mã giảm giá sẽ có hiệu lực trong tương lai',
                'type' => CouponType::FixedAmount,
                'value' => 100000,
                'minimum_amount' => 300000,
                'usage_limit' => 50,
                'starts_at' => now()->addWeeks(2),
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ],
        ];

        foreach ($predefinedCoupons as $couponData) {
            Coupon::create($couponData);
        }

        // Create random coupons using factory
        $coupons = collect([
            Coupon::factory()->count(5)->active()->percentage()->create(),
            Coupon::factory()->count(3)->active()->fixedAmount()->create(),
            Coupon::factory()->count(2)->inactive()->create(),
            Coupon::factory()->count(2)->expired()->create(),
            Coupon::factory()->count(2)->notStarted()->create(),
            Coupon::factory()->count(3)->unlimited()->create(),
            Coupon::factory()->count(5)->limitedUse()->create(),
        ])->flatten();

        // Get some products to attach to coupons
        $products = Product::take(10)->get();
        
        if ($products->isNotEmpty()) {
            // Attach random products to some coupons (not all)
            $coupons->random(min(10, $coupons->count()))->each(function ($coupon) use ($products) {
                // Attach 1-5 random products to each coupon
                $randomProducts = $products->random(rand(1, min(5, $products->count())));
                $coupon->products()->attach($randomProducts->pluck('id'));
            });
        }

        $this->command->info('Created ' . Coupon::count() . ' coupons');
        
        if ($products->isNotEmpty()) {
            $this->command->info('Attached products to random coupons');
        }
    }
}