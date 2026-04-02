<?php

namespace App\Filament\Resources\Shop\Orders\Pages;

use App\Filament\Resources\Shop\Orders\OrderResource;
use App\Enums\OrderStatus;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected string $view = 'filament.resources.shop.orders.pages.view-order';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print_invoice')
                ->label('In hóa đơn')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn () => route('invoice.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => in_array($this->record->status, [OrderStatus::Delivered, OrderStatus::Shipped])),

            Action::make('mark_processing')
                ->label('Xử lý đơn hàng')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->action(function () {
                    $this->record->update(['status' => OrderStatus::Processing]);
                    Notification::make()
                        ->title('Đã cập nhật trạng thái đơn hàng thành "Đang xử lý"')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === OrderStatus::New)
                ->requiresConfirmation()
                ->modalHeading('Xác nhận xử lý đơn hàng')
                ->modalDescription('Bạn có chắc chắn muốn chuyển đơn hàng này sang trạng thái "Đang xử lý"?'),

            Action::make('mark_shipped')
                ->label('Giao hàng')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->action(function () {
                    $this->record->update([
                        'status' => OrderStatus::Shipped,
                        'shipped_at' => now()
                    ]);
                    Notification::make()
                        ->title('Đã đánh dấu đơn hàng đã giao cho đơn vị vận chuyển')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === OrderStatus::Processing)
                ->requiresConfirmation()
                ->modalHeading('Xác nhận giao hàng')
                ->modalDescription('Đơn hàng sẽ được chuyển sang trạng thái "Đã gửi" và ghi nhận thời gian giao hàng.'),

            Action::make('mark_delivered')
                ->label('Hoàn thành')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function () {
                    $this->record->update([
                        'status' => OrderStatus::Delivered,
                        'delivered_at' => now(),
                        'payment_status' => 'completed',
                        'paid_at' => $this->record->paid_at ?? now(),
                    ]);
                    Notification::make()
                        ->title('Đã hoàn thành đơn hàng')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === OrderStatus::Shipped)
                ->requiresConfirmation()
                ->modalHeading('Xác nhận hoàn thành đơn hàng')
                ->modalDescription('Đơn hàng sẽ được đánh dấu là "Đã giao" và trạng thái thanh toán sẽ chuyển thành "Hoàn thành".'),
        ];
    }
}
