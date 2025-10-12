<?php

namespace App\Filament\Resources\Shop\Coupons\Schemas;

use App\Enums\CouponType;
use App\Models\Shop\Product;
use Filament\Forms;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Thông tin cơ bản')
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->label('Mã giảm giá')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Set $set) => $set('code', Str::upper($state)))
                                    ->placeholder('VD: SALE2025, NEWUSER'),

                                Forms\Components\TextInput::make('name')
                                    ->label('Tên mã giảm giá')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('VD: Giảm giá năm mới 2025'),

                                Forms\Components\Textarea::make('description')
                                    ->label('Mô tả')
                                    ->rows(3)
                                    ->placeholder('Mô tả chi tiết về mã giảm giá...'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt')
                                    ->default(true)
                                    ->helperText('Tắt để tạm dừng sử dụng mã giảm giá'),
                            ]),

                        Section::make('Cài đặt giảm giá')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Loại giảm giá')
                                    ->options(CouponType::class)
                                    ->required()
                                    ->live()
                                    ->native(false),

                                Forms\Components\TextInput::make('value')
                                    ->label(fn (Get $get) => match ($get('type')) {
                                        CouponType::Percentage->value => 'Phần trăm giảm (%)',
                                        CouponType::FixedAmount->value => 'Số tiền giảm (VNĐ)',
                                        default => 'Giá trị'
                                    })
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(fn (Get $get) => $get('type') === CouponType::Percentage->value ? 100 : null)
                                    ->suffix(fn (Get $get) => match ($get('type')) {
                                        CouponType::Percentage->value => '%',
                                        CouponType::FixedAmount->value => 'VNĐ',
                                        default => ''
                                    }),

                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('minimum_amount')
                                            ->label('Giá trị đơn hàng tối thiểu')
                                            ->numeric()
                                            ->minValue(0)
                                            ->suffix('VNĐ')
                                            ->helperText('Để trống nếu không giới hạn'),

                                        Forms\Components\TextInput::make('maximum_amount')
                                            ->label('Giá trị giảm tối đa')
                                            ->numeric()
                                            ->minValue(0)
                                            ->suffix('VNĐ')
                                            ->helperText('Áp dụng cho loại phần trăm')
                                            ->visible(fn (Get $get) => $get('type') === CouponType::Percentage->value),
                                    ]),
                            ]),

                        Section::make('Sản phẩm áp dụng')
                            ->schema([
                                Forms\Components\Select::make('products')
                                    ->label('Chọn sản phẩm')
                                    ->relationship('products', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Để trống để áp dụng cho tất cả sản phẩm')
                                    ->getOptionLabelFromRecordUsing(fn (Product $record) => "{$record->name} (#{$record->sku})"),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Thời gian hiệu lực')
                            ->schema([
                                Forms\Components\DateTimePicker::make('starts_at')
                                    ->label('Bắt đầu từ')
                                    ->displayFormat('d/m/Y H:i')
                                    ->helperText('Để trống để có hiệu lực ngay lập tức'),

                                Forms\Components\DateTimePicker::make('expires_at')
                                    ->label('Hết hạn vào')
                                    ->displayFormat('d/m/Y H:i')
                                    ->helperText('Để trống để không giới hạn thời gian')
                                    ->after('starts_at'),
                            ]),

                        Section::make('Giới hạn sử dụng')
                            ->schema([
                                Forms\Components\TextInput::make('usage_limit')
                                    ->label('Số lần sử dụng tối đa')
                                    ->numeric()
                                    ->minValue(1)
                                    ->helperText('Để trống để không giới hạn số lần sử dụng'),

                                Forms\Components\TextInput::make('used_count')
                                    ->label('Đã sử dụng')
                                    ->numeric()
                                    ->disabled()
                                    ->default(0)
                                    ->helperText('Số lần mã đã được sử dụng'),
                            ]),

                        Section::make('Thống kê')
                            ->schema([
                                Forms\Components\Placeholder::make('remaining_usage')
                                    ->label('Còn lại')
                                    ->content(function ($record, Get $get) {
                                        if (!$record) return '---';

                                        $usageLimit = $get('usage_limit') ?? $record->usage_limit;
                                        if (!$usageLimit) return 'Không giới hạn';

                                        $usedCount = $get('used_count') ?? $record->used_count;
                                        $remaining = max(0, $usageLimit - $usedCount);

                                        return $remaining . ' lần';
                                    }),

                                Forms\Components\Placeholder::make('status')
                                    ->label('Trạng thái')
                                    ->content(function ($record) {
                                        if (!$record) return '---';

                                        if (!$record->is_active) return 'Không hoạt động';
                                        if ($record->is_expired) return 'Đã hết hạn';
                                        if ($record->is_not_started) return 'Chưa bắt đầu';
                                        if (!$record->isValid()) return 'Không hợp lệ';

                                        return 'Hoạt động';
                                    })
                                    ->badge()
                                    ->color(function ($record) {
                                        if (!$record) return 'gray';

                                        if (!$record->is_active) return 'danger';
                                        if ($record->is_expired) return 'danger';
                                        if ($record->is_not_started) return 'warning';
                                        if (!$record->isValid()) return 'danger';

                                        return 'success';
                                    }),
                            ])
                            ->hidden(fn ($record) => !$record),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
