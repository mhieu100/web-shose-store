<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Author::class;

    public function definition(): array
    {
        $authors = [
            'Nguyễn Văn An',
            'Trần Thị Bình',
            'Lê Hoàng Cường', 
            'Phạm Thị Diệu',
            'Hoàng Văn Đức',
            'Võ Thị Giang',
            'Đỗ Minh Hải',
            'Bùi Thị Lan'
        ];
        
        $name = $this->faker->randomElement($authors) . ' ' . $this->faker->numberBetween(1, 100);
        $firstName = explode(' ', $name)[2] ?? 'An';
        
        return [
            'name' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)) . '@techblog.vn',
            'bio' => 'Tác giả ' . $name . ' - Chuyên gia về công nghệ và viết lách, có nhiều năm kinh nghiệm trong lĩnh vực truyền thông.',
            'github_handle' => strtolower($firstName) . '_dev',
            'twitter_handle' => '@' . strtolower($firstName) . '_writer',
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
