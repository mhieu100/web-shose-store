<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Post;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Post::class;

    public function definition(): array
    {
        $titles = [
            'Xu hướng công nghệ mới nhất năm 2024',
            'Cách khởi nghiệp thành công tại Việt Nam',
            'Phương pháp học tập hiệu quả cho sinh viên',
            'Bí quyết sống khỏe trong cuộc sống hiện đại',
            'Top 10 điểm du lịch đẹp nhất Việt Nam',
            'Món ăn truyền thống Việt Nam nên thử',
            'Lịch thi đấu và kết quả thể thao mới nhất',
            'Những bộ phim hay nhất mọi thời đại',
            'Công nghệ AI và tương lai',
            'Kinh nghiệm đầu tư chứng khoán',
            'Cách học tiếng Anh hiệu quả',
            'Chế độ ăn uống lành mạnh',
            'Du lịch bụi khám phá Việt Nam',
            'Văn hóa ẩm thực ba miền',
            'Thể thao và sức khỏe',
            'Review phim và sách hay'
        ];
        
        $title = $this->faker->randomElement($titles) . ' - ' . $this->faker->numberBetween(1, 1000);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => 'Nội dung bài viết về ' . $title . '. Đây là một bài viết chất lượng cao với thông tin hữu ích và cập nhật.',
            'published_at' => $this->faker->dateTimeBetween('-6 month', '+1 month'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function configure(): PostFactory
    {
        return $this->afterCreating(function (Post $product): void {
            $product
                ->addMedia(LocalImages::getRandomFile(LocalImages::SIZE_200x200))
                ->preservingOriginal()
                ->toMediaCollection('post-images');
        });
    }
}
