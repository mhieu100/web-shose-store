<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Admin mặc định
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => UserRole::ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '0123456789',
                'address' => 'Hà Nội, Việt Nam',
            ]
        );

        // Tạo CTV mẫu
        User::updateOrCreate(
            ['email' => 'ctv@example.com'],
            [
                'name' => 'Cộng Tác Viên',
                'email' => 'ctv@example.com',
                'password' => Hash::make('123456'),
                'role' => UserRole::CTV,
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '0987654321',
                'address' => 'TP.HCM, Việt Nam',
            ]
        );

        // Tạo User thường mẫu
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Người Dùng Thường',
                'email' => 'user@example.com',
                'password' => Hash::make('123456'),
                'role' => UserRole::REGISTERED,
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '0123987456',
                'address' => 'Đà Nẵng, Việt Nam',
            ]
        );

        // Tạo thêm một số user mẫu khác
        User::factory(10)->create([
            'role' => UserRole::REGISTERED,
            'is_active' => true,
        ]);

        User::factory(5)->create([
            'role' => UserRole::CTV,
            'is_active' => true,
        ]);

        User::factory(2)->create([
            'role' => UserRole::ADMIN,
            'is_active' => true,
        ]);

        // Tạo một số user bị khóa
        User::factory(3)->create([
            'role' => UserRole::REGISTERED,
            'is_active' => false,
        ]);

        $this->command->info('Đã tạo xong dữ liệu mẫu cho User và Role!');
        $this->command->info('Admin: admin@example.com / 123456');
        $this->command->info('CTV: ctv@example.com / 123456');
        $this->command->info('User: user@example.com / 123456');
    }
}