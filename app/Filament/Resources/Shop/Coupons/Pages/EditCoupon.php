<?php

namespace App\Filament\Resources\Shop\Coupons\Pages;

use App\Filament\Resources\Shop\Coupons\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoupon extends EditRecord
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Xem'),
            Actions\Action::make('duplicate')
                ->label('Nhân bản')
                ->icon('heroicon-o-document-duplicate')
                ->color('gray')
                ->action(function () {
                    $newCoupon = $this->record->replicate();
                    $newCoupon->code = $this->record->code . '_COPY';
                    $newCoupon->used_count = 0;
                    $newCoupon->save();
                    
                    // Copy product relationships
                    $newCoupon->products()->attach($this->record->products->pluck('id'));
                    
                    $this->redirect(static::getResource()::getUrl('edit', ['record' => $newCoupon]));
                })
                ->successNotificationTitle('Đã nhân bản mã giảm giá'),
            Actions\DeleteAction::make()
                ->label('Xóa')
                ->requiresConfirmation()
                ->modalHeading('Xác nhận xóa mã giảm giá')
                ->modalDescription('Bạn có chắc chắn muốn xóa mã giảm giá này? Hành động này không thể hoàn tác.')
                ->modalSubmitActionLabel('Xóa')
                ->modalCancelActionLabel('Hủy'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Mã giảm giá đã được cập nhật';
    }
}