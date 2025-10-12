<?php

namespace App\Filament\Resources\Shop\Coupons\Pages;

use App\Filament\Resources\Shop\Coupons\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCoupons extends ListRecords
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tạo mã giảm giá mới'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả')
                ->badge(fn () => static::getResource()::getModel()::count()),
            'active' => Tab::make('Đang hoạt động')
                ->query(fn (Builder $query) => $query->where('is_active', true))
                ->badge(fn () => static::getResource()::getModel()::where('is_active', true)->count())
                ->badgeColor('success'),
            'valid' => Tab::make('Hợp lệ hiện tại')
                ->query(fn (Builder $query) => $query->valid())
                ->badge(fn () => static::getResource()::getModel()::valid()->count())
                ->badgeColor('info'),
            'expired' => Tab::make('Đã hết hạn')
                ->query(fn (Builder $query) => $query->whereNotNull('expires_at')->where('expires_at', '<', now()))
                ->badge(fn () => static::getResource()::getModel()::whereNotNull('expires_at')->where('expires_at', '<', now())->count())
                ->badgeColor('danger'),
            'not_started' => Tab::make('Chưa bắt đầu')
                ->query(fn (Builder $query) => $query->whereNotNull('starts_at')->where('starts_at', '>', now()))
                ->badge(fn () => static::getResource()::getModel()::whereNotNull('starts_at')->where('starts_at', '>', now())->count())
                ->badgeColor('warning'),
            'exhausted' => Tab::make('Hết lượt sử dụng')
                ->query(fn (Builder $query) => $query->whereNotNull('usage_limit')->whereColumn('used_count', '>=', 'usage_limit'))
                ->badge(fn () => static::getResource()::getModel()::whereNotNull('usage_limit')->whereColumn('used_count', '>=', 'usage_limit')->count())
                ->badgeColor('gray'),
            'inactive' => Tab::make('Không hoạt động')
                ->query(fn (Builder $query) => $query->where('is_active', false))
                ->badge(fn () => static::getResource()::getModel()::where('is_active', false)->count())
                ->badgeColor('danger'),
        ];
    }
}