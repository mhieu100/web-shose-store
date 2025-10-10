<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Product;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    public function definition(): array
    {
        $products = [
            'Giày thể thao nam Air Max Pro',
            'Giày cao gót nữ kiểu dáng thanh lịch', 
            'Giày búp bê nữ đế bệt thoải mái',
            'Sandal nữ thời trang mùa hè',
            'Boot nam da thật cao cấp',
            'Giày lười nam da bò sang trọng',
            'Giày Oxford nam công sở',
            'Sneaker nữ phong cách Hàn Quốc'
        ];
        
        $name = $this->faker->unique()->randomElement($products);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => 'SKU-' . $this->faker->unique()->numberBetween(10000, 99999),
            'barcode' => $this->faker->ean13(),
            'description' => $name . ' - Sản phẩm chất lượng cao, thiết kế thời trang, phù hợp cho mọi dịp.',
            'qty' => $this->faker->numberBetween(10, 100),
            'security_stock' => $this->faker->numberBetween(5, 20),
            'featured' => $this->faker->boolean(30),
            'is_visible' => true,
            'old_price' => $oldPrice = $this->faker->numberBetween(800000, 2000000),
            'price' => $this->faker->numberBetween(600000, $oldPrice),
            'cost' => $this->faker->numberBetween(300000, 500000),
            'type' => 'deliverable',
            'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function configure(): ProductFactory
    {
        return $this->afterCreating(function (Product $product): void {
            $product
                ->addMedia(LocalImages::getRandomFile(LocalImages::SIZE_200x200))
                ->preservingOriginal()
                ->toMediaCollection('product-images');
        });
    }
}
