<?php

namespace App\Filament\Resources\Shop\Coupons\Pages;

use App\Filament\Resources\Shop\Coupons\CouponResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mã giảm giá đã được tạo thành công';
    }
}