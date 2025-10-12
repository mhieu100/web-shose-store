<?php

namespace Database\Factories\Shop;

use App\Enums\CouponType;
use App\Models\Shop\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(CouponType::cases());
        $startsAt = $this->faker->boolean(70) ? $this->faker->dateTimeBetween('-1 month', '+1 week') : null;
        $expiresAt = $this->faker->boolean(80) ? $this->faker->dateTimeBetween('now', '+3 months') : null;
        
        return [
            'code' => strtoupper($this->faker->unique()->bothify('????####')),
            'name' => $this->faker->words(3, true) . ' - ' . $this->faker->randomElement(['Giảm giá', 'Khuyến mãi', 'Sale']),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'type' => $type,
            'value' => match ($type) {
                CouponType::Percentage => $this->faker->numberBetween(5, 50),
                CouponType::FixedAmount => $this->faker->numberBetween(10000, 500000),
            },
            'minimum_amount' => $this->faker->optional(0.6)->numberBetween(50000, 1000000),
            'maximum_amount' => $type === CouponType::Percentage ? $this->faker->optional(0.4)->numberBetween(50000, 200000) : null,
            'usage_limit' => $this->faker->optional(0.8)->numberBetween(10, 1000),
            'used_count' => 0,
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
            'is_active' => $this->faker->boolean(85),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CouponType::Percentage,
            'value' => $this->faker->numberBetween(5, 50),
            'maximum_amount' => $this->faker->optional(0.5)->numberBetween(50000, 200000),
        ]);
    }

    public function fixedAmount(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CouponType::FixedAmount,
            'value' => $this->faker->numberBetween(10000, 500000),
            'maximum_amount' => null,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }

    public function notStarted(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
        ]);
    }

    public function unlimited(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_limit' => null,
            'minimum_amount' => null,
            'starts_at' => null,
            'expires_at' => null,
        ]);
    }

    public function limitedUse(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_limit' => $this->faker->numberBetween(5, 50),
            'used_count' => $this->faker->numberBetween(0, 10),
        ]);
    }
}