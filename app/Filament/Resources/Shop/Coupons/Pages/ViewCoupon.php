<?php

namespace App\Filament\Resources\Shop\Coupons\Pages;

use App\Filament\Resources\Shop\Coupons\CouponResource;
use App\Models\Shop\Coupon;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewCoupon extends ViewRecord
{
    protected static string $resource = CouponResource::class;

    public function getTitle(): string | Htmlable
    {
        /** @var Coupon */
        $record = $this->getRecord();

        return $record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Chỉnh sửa'),
            Actions\Action::make('duplicate')
                ->label('Nhân bản')
                ->icon('heroicon-o-document-duplicate')
                ->action(function () {
                    $newCoupon = $this->record->replicate();
                    $newCoupon->code = $this->record->code . '_COPY';
                    $newCoupon->used_count = 0;
                    $newCoupon->save();
                    
                    // Copy product relationships
                    $newCoupon->products()->attach($this->record->products->pluck('id'));
                    
                    $this->redirect(static::getResource()::getUrl('view', ['record' => $newCoupon]));
                })
                ->successNotificationTitle('Đã nhân bản mã giảm giá'),
            Actions\DeleteAction::make()
                ->label('Xóa'),
        ];
    }
}