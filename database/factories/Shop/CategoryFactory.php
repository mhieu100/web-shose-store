<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Giày thể thao',
            'Giày cao gót',
            'Giày búp bê',
            'Giày sandal',
            'Giày boot',
            'Giày lười',
            'Giày Oxford',
            'Giày sneaker',
            'Giày da',
            'Giày vải',
            'Giày chạy bộ',
            'Giày đi học',
            'Giày công sở',
            'Giày dép nữ',
            'Giày nam công sở'
        ];
        
        $name = $this->faker->unique()->randomElement($categories);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'Danh mục ' . $name . ' với nhiều mẫu mã đa dạng, chất lượng cao.',
            'is_visible' => true,
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
