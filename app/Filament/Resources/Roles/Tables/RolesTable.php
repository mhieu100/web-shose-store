<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Tên role')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                \Filament\Tables\Columns\TextColumn::make('label')
                    ->label('Tên hiển thị')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(50)
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('users_count')
                    ->label('Số users')
                    ->counts('users')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->label('Trạng thái')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái')
                    ->boolean()
                    ->trueLabel('Đang hoạt động')
                    ->falseLabel('Đã khóa')
                    ->native(false),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->label('Xem'),
                EditAction::make()
                    ->label('Sửa'),
                \Filament\Actions\DeleteAction::make()
                    ->label('Xóa')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận xóa role')
                    ->modalDescription('Bạn có chắc chắn muốn xóa role này? Hành động này không thể hoàn tác.')
                    ->modalSubmitActionLabel('Xóa')
                    ->modalCancelActionLabel('Hủy'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ])
            ->defaultSort('sort_order');
    }
}
