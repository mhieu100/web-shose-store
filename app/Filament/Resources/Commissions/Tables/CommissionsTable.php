<?php

namespace App\Filament\Resources\Commissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('CTV')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('order.id')
                    ->label('Mã đơn hàng')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('product.name')
                    ->label('Sản phẩm')
                    ->searchable()
                    ->limit(30),
                    
                TextColumn::make('order_amount')
                    ->label('Giá trị đơn')
                    ->money('VND')
                    ->sortable(),
                    
                TextColumn::make('commission_rate')
                    ->label('Tỷ lệ (%)')
                    ->formatStateUsing(fn (string $state): string => $state . '%')
                    ->sortable(),
                    
                TextColumn::make('commission_amount')
                    ->label('Hoa hồng')
                    ->money('VND')
                    ->sortable(),
                    
                BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn ($record) => $record->status_label)
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'approved',
                        'success' => 'paid', 
                        'danger' => 'cancelled',
                    ]),
                    
                TextColumn::make('approved_at')
                    ->label('Ngày duyệt')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Chưa duyệt'),
                    
                TextColumn::make('paid_at')
                    ->label('Ngày thanh toán')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Chưa thanh toán'),
                    
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ duyệt',
                        'approved' => 'Đã duyệt',
                        'paid' => 'Đã thanh toán',
                        'cancelled' => 'Đã hủy',
                    ]),
                    
                SelectFilter::make('user')
                    ->label('CTV')
                    ->relationship('user', 'name', fn ($query) => $query->byRole('ctv'))
                    ->searchable()
                    ->preload(),
                    
                Filter::make('created_at')
                    ->label('Ngày tạo')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Từ ngày'),
                        DatePicker::make('created_until')
                            ->label('Đến ngày'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Duyệt')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Đã duyệt hoa hồng')
                            ->success()
                            ->send();
                    }),
                    
                Action::make('pay')
                    ->label('Thanh toán')
                    ->icon('heroicon-o-banknotes')
                    ->color('info')
                    ->visible(fn ($record) => $record->status === 'approved')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Đã thanh toán hoa hồng')
                            ->success()
                            ->send();
                    }),
                    
                Action::make('cancel')
                    ->label('Hủy')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'approved']))
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'cancelled',
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Đã hủy hoa hồng')
                            ->warning()
                            ->send();
                    }),
                    
                EditAction::make()
                    ->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
