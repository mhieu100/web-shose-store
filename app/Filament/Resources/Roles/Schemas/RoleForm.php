<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên role (slug)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('admin, ctv, manager...')
                            ->helperText('Tên duy nhất, dùng trong code. Chỉ dùng chữ thường, số và dấu gạch dưới'),

                        TextInput::make('label')
                            ->label('Tên hiển thị')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Quản trị viên, Cộng tác viên...'),

                        TextInput::make('sort_order')
                            ->label('Thứ tự sắp xếp')
                            ->numeric()
                            ->default(0)
                            ->placeholder('0'),

                        Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true)
                            ->helperText('Chỉ những role được kích hoạt mới hiển thị trong dropdown'),

                        Textarea::make('description')
                            ->label('Mô tả')
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('Mô tả vai trò và quyền hạn...')
                            ->columnSpan('full'),

                        \Filament\Forms\Components\CheckboxList::make('permissions')
                            ->label('Quyền hạn')
                            ->options([
                                'view_admin_panel' => 'Truy cập admin panel',
                                'manage_users' => 'Quản lý người dùng',
                                'manage_roles' => 'Quản lý vai trò',
                                'manage_products' => 'Quản lý sản phẩm',
                                'manage_orders' => 'Quản lý đơn hàng',
                                'manage_customers' => 'Quản lý khách hàng',
                                'manage_brands' => 'Quản lý thương hiệu',
                                'manage_categories' => 'Quản lý danh mục',
                                'manage_commissions' => 'Quản lý hoa hồng',
                                'manage_withdrawals' => 'Quản lý rút tiền',
                                'view_dashboard' => 'Xem dashboard',
                                'manage_settings' => 'Quản lý cài đặt',
                                'view_products' => 'Xem sản phẩm',
                                'create_orders' => 'Tạo đơn hàng',
                                'view_orders' => 'Xem đơn hàng',
                                'update_orders' => 'Cập nhật đơn hàng',
                                'view_customers' => 'Xem khách hàng',
                                'create_customers' => 'Tạo khách hàng',
                                'update_customers' => 'Cập nhật khách hàng',
                                'view_own_orders' => 'Xem đơn hàng của mình',
                                'view_own_profile' => 'Xem hồ sơ cá nhân',
                                'update_own_profile' => 'Cập nhật hồ sơ cá nhân',
                            ])
                            ->columns(3)
                            ->searchable()
                            ->columnSpan('full'),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 3]),
            ])
            ->columns(3);
    }
}
