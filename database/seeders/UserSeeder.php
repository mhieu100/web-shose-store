<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Đảm bảo roles đã tồn tại
        $adminRole = Role::where('name', 'admin')->first();
        $ctvRole = Role::where('name', 'ctv')->first();
        $registeredRole = Role::where('name', 'registered')->first();

        if (!$adminRole || !$ctvRole || !$registeredRole) {
            $this->command->error('Roles chưa tồn tại! Chạy RoleSeeder trước.');
            return;
        }

        // Tạo Admin mặc định
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'role_id' => $adminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '0123456789',
                'address' => 'Hà Nội, Việt Nam',
            ]
        );

        // Tạo CTV mẫu
        $ctvUsers = [
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'ctv1@example.com',
                'phone' => '0901234567',
                'address' => 'Hà Nội',
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'ctv2@example.com',
                'phone' => '0902345678',
                'address' => 'Hồ Chí Minh',
            ],
            [
                'name' => 'Lê Minh Cường',
                'email' => 'ctv3@example.com',
                'phone' => '0903456789',
                'address' => 'Đà Nẵng',
            ],
            [
                'name' => 'Phạm Thu Dung',
                'email' => 'ctv4@example.com',
                'phone' => '0904567890',
                'address' => 'Cần Thơ',
            ],
            [
                'name' => 'Hoàng Văn Em',
                'email' => 'ctv5@example.com',
                'phone' => '0905678901',
                'address' => 'Hải Phòng',
            ],
        ];

        foreach ($ctvUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('123456'),
                    'phone' => $userData['phone'],
                    'address' => $userData['address'],
                    'role_id' => $ctvRole->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Tạo User thường mẫu
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Người Dùng Thường',
                'email' => 'user@example.com',
                'password' => Hash::make('123456'),
                'role_id' => $registeredRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '0123987456',
                'address' => 'Đà Nẵng, Việt Nam',
            ]
        );

        // Tạo thêm một số user mẫu khác với phân bố cân bằng
        // Tạo thêm 2 admin
        User::factory(2)->create([
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        // Tạo thêm 5 CTV
        User::factory(5)->create([
            'role_id' => $ctvRole->id,
            'is_active' => true,
        ]);

        // Tạo 8 user registered
        User::factory(8)->create([
            'role_id' => $registeredRole->id,
            'is_active' => true,
        ]);

        // Tạo một số user bị khóa (2 registered)
        User::factory(2)->create([
            'role_id' => $registeredRole->id,
            'is_active' => false,
        ]);

        $this->command->info('✅ Đã tạo xong dữ liệu mẫu cho User!');
        $this->command->info('🎯 Admin: admin@example.com / 123456');
        $this->command->info('🎯 CTV: ctv1@example.com / 123456');
        $this->command->info('🎯 User: user@example.com / 123456');
    }
}