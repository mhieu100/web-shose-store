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

        // Chỉ tạo 2 CTV đã duyệt
        $approvedCtvs = array_slice($ctvUsers, 0, 2);
        foreach ($approvedCtvs as $index => $userData) {
            $ctv = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('123456'),
                    'phone' => $userData['phone'],
                    'address' => $userData['address'],
                    'role_id' => $ctvRole->id,
                    'is_active' => true,
                    'is_affiliate_active' => true, // Quan trọng: phải kích hoạt affiliate
                    'affiliate_code' => 'CTV' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'commission_rate' => 5.00,
                    'email_verified_at' => now(),
                ]
            );

            // Tạo đơn đăng ký CTV tương ứng (để lưu thông tin chi tiết)
            \App\Models\CollaboratorApplication::updateOrCreate(
                ['user_id' => $ctv->id],
                [
                    'full_name' => $ctv->name,
                    'phone' => $ctv->phone,
                    'id_card_number' => '12345678901' . ($index + 1),
                    'bank_account' => '123456789' . ($index + 1),
                    'bank_name' => $index == 0 ? 'Vietcombank' : 'Techcombank',
                    'bank_account_name' => $ctv->name,
                    'address' => $ctv->address,
                    'reason' => 'Tôi có kinh nghiệm bán hàng và muốn trở thành cộng tác viên để phát triển sự nghiệp.',
                    'experience' => $index == 0 
                        ? 'Có 3 năm kinh nghiệm bán hàng online, từng quản lý shop Shopee với 10k+ followers.'
                        : 'Influencer Facebook với 15k followers, chuyên review sản phẩm thời trang.',
                    'status' => 'approved',
                    'admin_note' => 'Ứng viên có kinh nghiệm tốt và đã được phê duyệt làm CTV.',
                    'approved_at' => now()->subDays($index + 1),
                    'approved_by' => 1, // Admin ID
                    'created_at' => now()->subDays($index + 7),
                ]
            );
        }

        // Tạo 3 users thường từ CTV còn lại (để có thể đăng ký CTV)
        $normalUsers = array_slice($ctvUsers, 2, 3);
        foreach ($normalUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('123456'),
                    'phone' => $userData['phone'],
                    'address' => $userData['address'],
                    'role_id' => $registeredRole->id, // Role user thường
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

        // Không tạo thêm CTV factory - chỉ có CTV đã duyệt mới có role CTV
        // User::factory(5)->create([
        //     'role_id' => $ctvRole->id,
        //     'is_active' => true,
        // ]);

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
        $this->command->info('🎯 CTV đã duyệt: ctv1@example.com / 123456 (Code: CTV0001)');
        $this->command->info('🎯 CTV đã duyệt: ctv2@example.com / 123456 (Code: CTV0002)');
        $this->command->info('🎯 User thường: user@example.com / 123456');
        $this->command->info('🎯 Users có thể đăng ký CTV: ctv3@example.com, ctv4@example.com, ctv5@example.com');
        $this->command->info('📝 Mọi CTV đều có đơn đăng ký tương ứng với thông tin chi tiết!');
    }
}