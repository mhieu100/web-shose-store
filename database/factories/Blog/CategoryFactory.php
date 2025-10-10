<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Category;
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
            'Công nghệ',
            'Kinh doanh', 
            'Giáo dục',
            'Sức khỏe',
            'Du lịch',
            'Ẩm thực',
            'Thể thao',
            'Giải trí'
        ];
        
        $name = $this->faker->unique()->randomElement($categories);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'Danh mục ' . $name . ' với các bài viết chất lượng cao.',
            'is_visible' => true,
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
