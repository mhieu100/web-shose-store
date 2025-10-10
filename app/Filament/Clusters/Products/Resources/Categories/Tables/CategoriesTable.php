<?php

namespace App\Filament\Clusters\Products\Resources\Categories\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.name')
                    ->label('Danh mục cha')
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
                EditAction::make(),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->action(function (): void {
                        Notification::make()
                            ->title('Này, này, đừng tinh nghịch, để lại một số bản ghi cho người khác chơi với!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}
