<?php

namespace App\Enums;

enum UserRole: string
{
    case REGISTERED = 'registered';
    case CTV = 'ctv';
    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::REGISTERED => 'Người mua hàng',
            self::CTV => 'Cộng tác viên',
            self::ADMIN => 'Quản trị viên',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::REGISTERED => 'Khách hàng đã đăng ký tài khoản, có thể mua hàng',
            self::CTV => 'Cộng tác viên bán hàng, hỗ trợ khách hàng',
            self::ADMIN => 'Quản trị viên hệ thống, có quyền cao nhất',
        };
    }

    public function getPermissions(): array
    {
        return match ($this) {
            self::REGISTERED => [
                'view_products',
                'create_orders',
                'view_own_orders',
                'update_own_profile',
            ],
            self::CTV => [
                'view_products',
                'create_orders',
                'view_orders',
                'update_orders',
                'view_customers',
                'create_customers',
                'update_customers',
                'view_own_profile',
                'update_own_profile',
            ],
            self::ADMIN => [
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
            ],
        };
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getLabels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->getLabel();
        }
        return $labels;
    }
}