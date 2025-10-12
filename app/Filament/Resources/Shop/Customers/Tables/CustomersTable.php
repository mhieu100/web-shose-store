<?php

namespace App\Filament\Resources\Shop\Customers\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Squire\Models\Country;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên khách hàng')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Địa chỉ email')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable(),
                TextColumn::make('country')
                    ->label('Quốc gia')
                    ->getStateUsing(fn ($record): ?string => Country::find($record->addresses->first()?->country)->name ?? null),
                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
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
            ]);
    }
}
