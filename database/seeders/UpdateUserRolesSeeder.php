<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdateUserRolesSeeder extends Seeder
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

        // Cập nhật users hiện tại dựa trên role string cũ
        $users = User::all();
        
        foreach ($users as $user) {
            $roleId = null;
            
            // Map từ role string cũ sang role_id mới
            if (isset($user->role)) {
                switch ($user->role) {
                    case 'admin':
                        $roleId = $adminRole->id;
                        break;
                    case 'ctv':
                        $roleId = $ctvRole->id;
                        break;
                    case 'registered':
                    default:
                        $roleId = $registeredRole->id;
                        break;
                }
            } else {
                // Nếu chưa có role, set mặc định là registered
                $roleId = $registeredRole->id;
            }

            if ($roleId) {
                $user->update(['role_id' => $roleId]);
                $this->command->info("Updated user {$user->email} with role_id: {$roleId}");
            }
        }

        // Tạo/cập nhật users mẫu với role_id đúng
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

        User::updateOrCreate(
            ['email' => 'ctv@example.com'],
            [
                'name' => 'Cộng Tác Viên',
                'email' => 'ctv@example.com',
                'password' => Hash::make('123456'),
                'role_id' => $ctvRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '0987654321',
                'address' => 'TP.HCM, Việt Nam',
            ]
        );

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

        // Tạo thêm users mẫu với role_id
        if (User::count() < 20) {
            // Tạo thêm registered users
            User::factory(10)->create([
                'role_id' => $registeredRole->id,
                'is_active' => true,
            ]);

            // Tạo thêm CTV users
            User::factory(5)->create([
                'role_id' => $ctvRole->id,
                'is_active' => true,
            ]);

            // Tạo thêm admin users
            User::factory(2)->create([
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]);

            // Tạo một số users bị khóa
            User::factory(3)->create([
                'role_id' => $registeredRole->id,
                'is_active' => false,
            ]);
        }

        $this->command->info('✅ Đã cập nhật tất cả users với role_id từ bảng roles!');
        $this->command->info('🎯 Admin: admin@example.com / 123456');
        $this->command->info('🎯 CTV: ctv@example.com / 123456');
        $this->command->info('🎯 User: user@example.com / 123456');
    }
}