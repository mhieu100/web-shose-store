<?php

namespace App\Filament\Resources\Shop\Orders\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Squire\Models\Currency;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('order_number')
                    ->label('Mã đơn hàng')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Đã sao chép mã đơn hàng!')
                    ->weight('bold'),
                    
                TextColumn::make('user.name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable()
                    ->default('Khách vãng lai')
                    ->icon('heroicon-o-user'),
                    
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),
                    
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn ($record) => $record->status_color ?? 'secondary'),
                    
                TextColumn::make('payment_method')
                    ->label('Thanh toán')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cod' => 'Thanh toán khi nhận hàng',
                        'bank_transfer' => 'Chuyển khoản',
                        'paypal' => 'PayPal',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'cod' => 'warning',
                        'bank_transfer' => 'info',
                        'paypal' => 'success',
                        default => 'secondary',
                    }),
                    
                TextColumn::make('payment_status')
                    ->label('TT Thanh toán')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Chờ thanh toán',
                        'processing' => 'Đang xử lý',
                        'completed' => 'Đã thanh toán',
                        'failed' => 'Thất bại',
                        'cancelled' => 'Đã hủy',
                        'refunded' => 'Đã hoàn tiền',
                        default => ucfirst($state),
                    })
                    ->color(fn ($record) => $record->payment_status_color ?? 'secondary'),
                    
                TextColumn::make('subtotal')
                    ->label('Tạm tính')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('coupon_code')
                    ->label('Mã giảm giá')
                    ->badge()
                    ->color('success')
                    ->placeholder('Không có')
                    ->toggleable(),
                    
                TextColumn::make('coupon_discount')
                    ->label('Giảm giá')
                    ->money('USD')
                    ->color('success')
                    ->formatStateUsing(fn ($state) => $state > 0 ? '-$' . number_format($state, 2) : '')
                    ->placeholder('$0.00')
                    ->toggleable(),
                    
                TextColumn::make('shipping_amount')
                    ->label('Phí ship')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('tax_amount')
                    ->label('Thuế')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('total_amount')
                    ->label('Tổng cộng')
                    ->money('USD')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->summarize([
                        Sum::make()
                            ->money('USD')
                            ->label('Tổng doanh thu'),
                    ]),
                    
                TextColumn::make('created_at')
                    ->label('Ngày đặt')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('shipped_at')
                    ->label('Ngày giao')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Chưa giao')
                    ->toggleable(),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('status')
                    ->label('Trạng thái đơn hàng')
                    ->options([
                        'new' => 'Mới',
                        'processing' => 'Đang xử lý',
                        'shipped' => 'Đã giao',
                        'delivered' => 'Đã nhận',
                        'cancelled' => 'Đã hủy',
                    ])
                    ->multiple(),

                SelectFilter::make('payment_status')
                    ->label('Trạng thái thanh toán')
                    ->options([
                        'pending' => 'Chờ thanh toán',
                        'processing' => 'Đang xử lý',
                        'completed' => 'Đã thanh toán',
                        'failed' => 'Thất bại',
                        'cancelled' => 'Đã hủy',
                        'refunded' => 'Đã hoàn tiền',
                    ])
                    ->multiple(),

                SelectFilter::make('payment_method')
                    ->label('Phương thức thanh toán')
                    ->options([
                        'cod' => 'Thanh toán khi nhận hàng',
                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                        'paypal' => 'PayPal',
                    ])
                    ->multiple(),

                Filter::make('created_at')
                    ->label('Ngày đặt hàng')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Từ ngày')
                            ->placeholder(fn ($state): string => '18 Th12, ' . now()->subYear()->format('Y')),
                        DatePicker::make('created_until')
                            ->label('Đến ngày')
                            ->placeholder(fn ($state): string => now()->format('d/m/Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Đơn hàng từ ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Đơn hàng đến ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),

                Filter::make('has_coupon')
                    ->label('Có mã giảm giá')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('coupon_code'))
                    ->toggle(),

                Filter::make('high_value')
                    ->label('Đơn hàng giá trị cao (>$100)')
                    ->query(fn (Builder $query): Builder => $query->where('total_amount', '>', 100))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem chi tiết')
                    ->icon('heroicon-o-eye'),
                    
                EditAction::make()
                    ->label('Chỉnh sửa')
                    ->icon('heroicon-o-pencil'),
                    
                Action::make('mark_processing')
                    ->label('Đang xử lý')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->action(function ($record) {
                        $record->update(['status' => 'processing']);
                        Notification::make()
                            ->title('Đã cập nhật trạng thái đơn hàng')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'new'),
                    
                Action::make('mark_shipped')
                    ->label('Đã giao hàng')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'shipped',
                            'shipped_at' => now()
                        ]);
                        Notification::make()
                            ->title('Đã đánh dấu đơn hàng đã giao')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'processing'),
                    
                Action::make('mark_delivered')
                    ->label('Đã nhận hàng')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'delivered',
                            'delivered_at' => now(),
                            'payment_status' => 'completed'
                        ]);
                        Notification::make()
                            ->title('Đã hoàn thành đơn hàng')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'shipped'),
                
                Action::make('print_invoice')
                    ->label('In hóa đơn')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn ($record) => route('invoice.download', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => in_array($record->status, ['delivered', 'shipped'])),
                    
                Action::make('view_address')
                    ->label('Xem địa chỉ')
                    ->icon('heroicon-o-map-pin')
                    ->color('info')
                    ->modalContent(function ($record) {
                        $shipping = $record->shipping_address;
                        if (!$shipping) return 'Không có thông tin địa chỉ';
                        
                        return view('filament.components.address-modal', compact('shipping'));
                    })
                    ->modalHeading('Địa chỉ giao hàng')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Đóng'),
                                   
                DeleteAction::make()
                    ->label('Xóa')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận xóa đơn hàng')
                    ->modalDescription('Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác.')
                    ->modalSubmitActionLabel('Xóa')
                    ->modalCancelActionLabel('Hủy')
                    ->visible(fn ($record) => $record->canBeCancelled()),
            ])
            ->groups([
                Group::make('created_at')
                    ->label('Ngày đặt hàng')
                    ->date()
                    ->collapsible(),
                Group::make('status')
                    ->label('Trạng thái')
                    ->collapsible(),
                Group::make('payment_status')
                    ->label('Trạng thái thanh toán')
                    ->collapsible(),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->label('Xóa đã chọn')
                    ->requiresConfirmation()
                    ->modalHeading('Xóa đơn hàng đã chọn')
                    ->modalDescription('Bạn có chắc chắn muốn xóa các đơn hàng đã chọn? Hành động này không thể hoàn tác.')
                    ->modalSubmitActionLabel('Xóa')
                    ->modalCancelActionLabel('Hủy'),
                    
                Action::make('mark_processing_bulk')
                    ->label('Đánh dấu đang xử lý')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->action(function ($records) {
                        $count = $records->where('status', 'new')->count();
                        $records->where('status', 'new')->each(function ($record) {
                            $record->update(['status' => 'processing']);
                        });
                        
                        Notification::make()
                            ->title("Đã cập nhật {$count} đơn hàng sang trạng thái 'Đang xử lý'")
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                    
                Action::make('export_orders')
                    ->label('Xuất Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function ($records) {
                        // Placeholder for export functionality
                        Notification::make()
                            ->title('Tính năng xuất Excel sẽ được phát triển sau')
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}
