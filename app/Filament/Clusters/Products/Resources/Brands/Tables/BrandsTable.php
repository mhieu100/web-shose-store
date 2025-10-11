<?php

namespace App\Filament\Clusters\Products\Resources\Brands\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên thương hiệu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('website')
                    ->label('Trang web')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_visible')
                    ->label('Hiển thị')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Lần sửa cuối')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem'),
                EditAction::make()
                    ->label('Sửa'),
                DeleteAction::make()
                    ->label('Xóa')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận xóa')
                    ->modalDescription('Bạn có chắc chắn muốn xóa? Hành động này không thể hoàn tác.')
                    ->modalSubmitActionLabel('Xóa')
                    ->modalCancelActionLabel('Hủy'),
            ])
            ->defaultSort('sort')
            ->reorderable('sort');
    }
}
