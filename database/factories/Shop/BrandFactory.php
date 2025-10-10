<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Brand::class;

    public function definition(): array
    {
        $brands = [
            'Nike Vietnam',
            'Adidas Việt Nam',
            'Biti\'s Hunter',
            'Ananas Vietnam',
            'Vascara',
            'Juno',
            'Charles & Keith Vietnam',
            'Daphne Vietnam',
            'Converse Vietnam',
            'New Balance VN',
            'Puma Việt Nam',
            'Vans Vietnam',
            'Reebok VN',
            'Fila Vietnam',
            'Sketchers VN'
        ];
        
        $name = $this->faker->unique()->randomElement($brands);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'website' => 'https://www.' . strtolower(str_replace([' ', '\''], ['', ''], $name)) . '.vn',
            'description' => 'Thương hiệu ' . $name . ' - Chuyên cung cấp giày dép chất lượng cao tại Việt Nam.',
            'is_visible' => true,
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
