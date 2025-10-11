<?php

namespace App\Filament\Resources\CommissionSettings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CommissionSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cơ bản')
                    ->schema([
                        Select::make('type')
                            ->label('Loại cài đặt')
                            ->options([
                                'global' => 'Toàn cục',
                                'user' => 'Theo CTV',
                                'product' => 'Theo sản phẩm',
                                'category' => 'Theo danh mục',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'global') {
                                    $set('target_id', null);
                                    $set('target_type', null);
                                }
                            }),

                        Select::make('target_id')
                            ->label('Đối tượng áp dụng')
                            ->options(function (callable $get) {
                                $type = $get('type');
                                return match($type) {
                                    'user' => \App\Models\User::byRole('ctv')->pluck('name', 'id')->toArray(),
                                    'product' => \App\Models\Shop\Product::pluck('name', 'id')->toArray(),
                                    'category' => \App\Models\Shop\Category::pluck('name', 'id')->toArray(),
                                    default => [],
                                };
                            })
                            ->searchable()
                            ->preload()
                            ->visible(fn (callable $get) => in_array($get('type'), ['user', 'product', 'category']))
                            ->required(fn (callable $get) => in_array($get('type'), ['user', 'product', 'category'])),

                        TextInput::make('target_type')
                            ->label('Loại đối tượng')
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(function (callable $get) {
                                $type = $get('type');
                                return match($type) {
                                    'user' => 'App\\Models\\User',
                                    'product' => 'App\\Models\\Shop\\Product',
                                    'category' => 'App\\Models\\Shop\\Category',
                                    default => null,
                                };
                            }),
                    ])
                    ->columns(2),

                Section::make('Cài đặt hoa hồng')
                    ->schema([
                        TextInput::make('commission_rate')
                            ->label('Tỷ lệ hoa hồng (%)')
                            ->required()
                            ->numeric()
                            ->suffix('%')
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(100),

                        TextInput::make('min_order_amount')
                            ->label('Giá trị đơn hàng tối thiểu')
                            ->required()
                            ->numeric()
                            ->prefix('₫')
                            ->step(1000)
                            ->default(0),

                        TextInput::make('max_commission')
                            ->label('Hoa hồng tối đa')
                            ->numeric()
                            ->prefix('₫')
                            ->step(1000)
                            ->helperText('Để trống nếu không giới hạn'),

                        TextInput::make('priority')
                            ->label('Độ ưu tiên')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Số càng cao, ưu tiên càng cao'),
                    ])
                    ->columns(2),

                Section::make('Trạng thái và thời hạn')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true)
                            ->required(),

                        DateTimePicker::make('valid_from')
                            ->label('Có hiệu lực từ')
                            ->helperText('Để trống nếu áp dụng ngay'),

                        DateTimePicker::make('valid_until')
                            ->label('Có hiệu lực đến')
                            ->helperText('Để trống nếu không giới hạn thời gian'),

                        Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
