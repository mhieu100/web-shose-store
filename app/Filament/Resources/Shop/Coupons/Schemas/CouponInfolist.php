<?php

namespace App\Filament\Resources\Shop\Coupons\Schemas;

use App\Enums\CouponType;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CouponInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cơ bản')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('code')
                                        ->label('Mã giảm giá')
                                        ->badge()
                                        ->color('primary')
                                        ->copyable()
                                        ->copyMessage('Đã sao chép mã!')
                                        ->size('lg'),
                                    
                                    TextEntry::make('name')
                                        ->label('Tên mã giảm giá')
                                        ->size('lg'),
                                    
                                    TextEntry::make('description')
                                        ->label('Mô tả')
                                        ->markdown()
                                        ->columnSpanFull(),
                                ]),
                                
                                Group::make([
                                    TextEntry::make('type')
                                        ->label('Loại giảm giá')
                                        ->badge(),
                                    
                                    TextEntry::make('value')
                                        ->label('Giá trị')
                                        ->formatStateUsing(function ($record) {
                                            return match ($record->type) {
                                                CouponType::Percentage => $record->value . '%',
                                                CouponType::FixedAmount => number_format($record->value, 0, ',', '.') . ' VNĐ',
                                            };
                                        })
                                        ->badge()
                                        ->color('success')
                                        ->size('lg'),
                                    
                                    TextEntry::make('status')
                                        ->label('Trạng thái')
                                        ->getStateUsing(function ($record) {
                                            if (!$record->is_active) return 'Không hoạt động';
                                            if ($record->is_expired) return 'Đã hết hạn';
                                            if ($record->is_not_started) return 'Chưa bắt đầu';
                                            if (!$record->isValid()) return 'Không hợp lệ';
                                            
                                            return 'Hoạt động';
                                        })
                                        ->badge()
                                        ->color(function ($record) {
                                            if (!$record->is_active) return 'danger';
                                            if ($record->is_expired) return 'danger';
                                            if ($record->is_not_started) return 'warning';
                                            if (!$record->isValid()) return 'danger';
                                            
                                            return 'success';
                                        }),
                                ]),
                            ]),
                    ]),

                Section::make('Điều kiện áp dụng')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('minimum_amount')
                                    ->label('Giá trị đơn hàng tối thiểu')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') . ' VNĐ' : 'Không giới hạn')
                                    ->icon('heroicon-m-currency-dollar'),
                                
                                TextEntry::make('maximum_amount')
                                    ->label('Giá trị giảm tối đa')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') . ' VNĐ' : 'Không giới hạn')
                                    ->icon('heroicon-m-receipt-percent')
                                    ->visible(fn ($record) => $record->type === CouponType::Percentage),
                                
                                TextEntry::make('products_count')
                                    ->label('Số sản phẩm áp dụng')
                                    ->getStateUsing(fn ($record) => $record->products->count())
                                    ->formatStateUsing(fn ($state) => $state > 0 ? $state . ' sản phẩm' : 'Áp dụng tất cả')
                                    ->icon('heroicon-m-cube')
                                    ->badge()
                                    ->color(fn ($state) => $state > 0 ? 'info' : 'gray'),
                            ]),
                    ]),

                Section::make('Thời gian và sử dụng')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('starts_at')
                                        ->label('Bắt đầu từ')
                                        ->dateTime('d/m/Y H:i')
                                        ->placeholder('Ngay lập tức')
                                        ->icon('heroicon-m-play'),
                                    
                                    TextEntry::make('expires_at')
                                        ->label('Hết hạn vào')
                                        ->dateTime('d/m/Y H:i')
                                        ->placeholder('Không giới hạn')
                                        ->icon('heroicon-m-stop'),
                                ]),
                                
                                Group::make([
                                    TextEntry::make('usage_stats')
                                        ->label('Thống kê sử dụng')
                                        ->formatStateUsing(function ($record) {
                                            if (!$record->usage_limit) {
                                                return $record->used_count . ' / ∞';
                                            }
                                            return $record->used_count . ' / ' . $record->usage_limit;
                                        })
                                        ->badge()
                                        ->color(function ($record) {
                                            if (!$record->usage_limit) return 'gray';
                                            
                                            $percentage = ($record->used_count / $record->usage_limit) * 100;
                                            
                                            if ($percentage >= 100) return 'danger';
                                            if ($percentage >= 80) return 'warning';
                                            if ($percentage >= 50) return 'info';
                                            
                                            return 'success';
                                        })
                                        ->icon('heroicon-m-chart-bar'),
                                    
                                    TextEntry::make('remaining_usage')
                                        ->label('Còn lại')
                                        ->getStateUsing(fn ($record) => $record->remaining_usage)
                                        ->formatStateUsing(fn ($state) => $state ? $state . ' lần' : 'Không giới hạn')
                                        ->icon('heroicon-m-clock'),
                                ]),
                            ]),
                    ]),

                Section::make('Thông tin hệ thống')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Tạo lúc')
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-m-plus'),
                                
                                TextEntry::make('updated_at')
                                    ->label('Cập nhật lần cuối')
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-m-pencil'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}