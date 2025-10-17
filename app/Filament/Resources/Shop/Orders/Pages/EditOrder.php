<?php

namespace App\Filament\Resources\Shop\Orders\Pages;

use App\Filament\Resources\Shop\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Xem chi tiết')
                ->icon('heroicon-o-eye'),
                
            Action::make('print_invoice')
                ->label('In hóa đơn')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn () => route('invoice.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => in_array($this->record->status, ['delivered', 'shipped'])),
                
            Action::make('mark_processing')
                ->label('Đánh dấu đang xử lý')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->action(function () {
                    $this->record->update(['status' => 'processing']);
                    Notification::make()
                        ->title('Đã cập nhật trạng thái đơn hàng')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'new')
                ->requiresConfirmation(),
                
            Action::make('mark_shipped')
                ->label('Đánh dấu đã giao')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->action(function () {
                    $this->record->update([
                        'status' => 'shipped',
                        'shipped_at' => now()
                    ]);
                    Notification::make()
                        ->title('Đã đánh dấu đơn hàng đã giao')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'processing')
                ->requiresConfirmation(),
                
            Action::make('mark_delivered')
                ->label('Đánh dấu đã nhận')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function () {
                    $this->record->update([
                        'status' => 'delivered',
                        'delivered_at' => now(),
                        'payment_status' => 'completed'
                    ]);
                    Notification::make()
                        ->title('Đã hoàn thành đơn hàng')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'shipped')
                ->requiresConfirmation(),
                
            DeleteAction::make()
                ->requiresConfirmation()
                ->visible(fn () => $this->record->canBeCancelled()),
                
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
