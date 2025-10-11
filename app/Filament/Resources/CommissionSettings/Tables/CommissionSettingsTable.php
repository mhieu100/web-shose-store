<?php

namespace App\Filament\Resources\CommissionSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CommissionSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('type')
                    ->label('Loại cài đặt')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'global' => 'Toàn cục',
                        'user' => 'Theo CTV',
                        'product' => 'Theo sản phẩm',
                        'category' => 'Theo danh mục',
                        default => $state
                    })
                    ->colors([
                        'primary' => 'global',
                        'success' => 'user',
                        'warning' => 'product',
                        'info' => 'category',
                    ]),

                TextColumn::make('target_name')
                    ->label('Đối tượng áp dụng')
                    ->formatStateUsing(function ($record) {
                        if (!$record->target_id) return 'Tất cả';
                        
                        return match($record->type) {
                            'user' => \App\Models\User::find($record->target_id)?->name ?? 'Không tìm thấy',
                            'product' => \App\Models\Shop\Product::find($record->target_id)?->name ?? 'Không tìm thấy',
                            'category' => \App\Models\Shop\Category::find($record->target_id)?->name ?? 'Không tìm thấy',
                            default => 'Tất cả'
                        };
                    })
                    ->searchable()
                    ->limit(30),

                TextColumn::make('commission_rate')
                    ->label('Tỷ lệ (%)')
                    ->formatStateUsing(fn (string $state): string => $state . '%')
                    ->sortable(),

                TextColumn::make('min_order_amount')
                    ->label('Đơn tối thiểu')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('max_commission')
                    ->label('Hoa hồng tối đa')
                    ->money('VND')
                    ->placeholder('Không giới hạn')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('priority')
                    ->label('Ưu tiên')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('valid_from')
                    ->label('Hiệu lực từ')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Ngay lập tức')
                    ->sortable(),

                TextColumn::make('valid_until')
                    ->label('Hiệu lực đến')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Không giới hạn')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Loại cài đặt')
                    ->options([
                        'global' => 'Toàn cục',
                        'user' => 'Theo CTV',
                        'product' => 'Theo sản phẩm',
                        'category' => 'Theo danh mục',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Trạng thái')
                    ->placeholder('Tất cả')
                    ->trueLabel('Đang hoạt động')
                    ->falseLabel('Tạm dừng'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ])
            ->defaultSort('priority', 'desc');
    }
}
