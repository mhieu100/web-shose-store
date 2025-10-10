<?php

namespace App\Filament\Resources\Blog\Authors\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Stack::make([
                        TextColumn::make('name')
                            ->label('Tên tác giả')
                            ->searchable()
                            ->sortable()
                            ->weight('medium')
                            ->alignLeft(),

                        TextColumn::make('email')
                            ->label('Địa chỉ email')
                            ->searchable()
                            ->sortable()
                            ->color('gray')
                            ->alignLeft(),
                    ])->space(),

                    Stack::make([
                        TextColumn::make('github_handle')
                            ->icon('icon-github')
                            ->label('Tài khoản GitHub')
                            ->alignLeft(),

                        TextColumn::make('twitter_handle')
                            ->label('Tài khoản Twitter')
                            ->icon('icon-twitter')
                            ->alignLeft(),
                    ])->space(2),
                ])->from('md'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
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
