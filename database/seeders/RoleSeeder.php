<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'label' => 'Quản trị viên',
                'description' => 'Có quyền cao nhất, quản lý toàn bộ hệ thống',
                'permissions' => [
                    'view_admin_panel',
                    'manage_users',
                    'manage_roles',
                    'manage_products',
                    'manage_orders',
                    'manage_customers',
                    'manage_brands',
                    'manage_categories',
                    'view_dashboard',
                    'manage_settings',
                    'manage_commissions',
                    'manage_withdrawals',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'ctv',
                'label' => 'Cộng tác viên',
                'description' => 'Hỗ trợ bán hàng và chăm sóc khách hàng, nhận hoa hồng',
                'permissions' => [
                    'view_products',
                    'create_orders',
                    'view_orders',
                    'update_orders',
                    'view_customers',
                    'create_customers',
                    'update_customers',
                    'view_own_profile',
                    'update_own_profile',
                    'view_own_commissions',
                    'request_withdrawals',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'registered',
                'label' => 'Người mua hàng',
                'description' => 'Khách hàng đã đăng ký, có thể mua hàng',
                'permissions' => [
                    'view_products',
                    'create_orders',
                    'view_own_orders',
                    'update_own_profile',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }

        $this->command->info('✅ Đã tạo xong các roles: Admin, CTV, Registered');
    }
}