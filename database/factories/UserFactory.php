<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'role_id' => \App\Models\Role::inRandomOrder()->first()?->id ?? 1,
            'is_active' => $this->faker->boolean(90),
            'last_login_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => \App\Models\Role::where('name', 'admin')->first()?->id ?? 1,
                'is_active' => true,
            ];
        });
    }

    public function ctv(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => \App\Models\Role::where('name', 'ctv')->first()?->id ?? 2,
                'is_active' => true,
            ];
        });
    }

    public function registered(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => \App\Models\Role::where('name', 'registered')->first()?->id ?? 3,
                'is_active' => true,
            ];
        });
    }
}
