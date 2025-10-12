<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        $customers = [
            'Nguyễn Văn Thành',
            'Trần Thị Mai',
            'Lê Hoàng Nam',
            'Phạm Thị Linh',
            'Hoàng Văn Đức',
            'Võ Thị Hoa',
            'Đỗ Minh Tuấn',
            'Bùi Thị Nga'
        ];
        
        $name = $this->faker->randomElement($customers) . ' ' . $this->faker->numberBetween(1, 100);
        $firstName = explode(' ', $name)[2] ?? 'Thanh';
        
        return [
            'name' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)) . '@gmail.com',
            'phone' => '0' . $this->faker->numberBetween(900000000, 999999999),
            'birthday' => $this->faker->dateTimeBetween('-35 years', '-18 years'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
