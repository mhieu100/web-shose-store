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
                    ->getStateUsing(function ($record) {
                        // First try to get the direct product
                        if ($record->product_id && $record->product) {
                            return $record->product->name;
                        }
                        
                        // Show order items summary if no specific product
                        if ($record->order && $record->order->items) {
                            $itemCount = $record->order->items->count();
                            if ($itemCount === 1) {
                                $item = $record->order->items->first();
                                return $item->product ? $item->product->name : 'Sản phẩm không xác định';
                            } elseif ($itemCount > 1) {
                                return "Đơn hàng gồm {$itemCount} sản phẩm";
                            }
                        }
                        
                        return 'Không xác định';
                    })
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function ($record) {
                        if ($record->order && $record->order->items && $record->order->items->count() > 1) {
                            return $record->order->items->map(function ($item) {
                                return $item->product ? $item->product->name : 'Sản phẩm không xác định';
                            })->join(', ');
                        }
                        return null;
                    }),
                    
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
                        // Update commission status
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);
                        
                        // Add funds to user's wallet
                        $walletService = app(\App\Services\WalletService::class);
                        $wallet = $walletService->getOrCreateWallet($record->user);
                        
                        $wallet->addFunds(
                            $record->commission_amount,
                            'commission',
                            "Hoa hồng từ đơn hàng #{$record->order_id} - Mã CTV: {$record->user->affiliate_code}",
                            $record->order_id,
                            ['commission_id' => $record->id]
                        );
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Đã thanh toán hoa hồng và cộng vào ví')
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
