<?php

namespace App\Filament\Clusters\Products\Resources\Products\Widgets;

use App\Filament\Clusters\Products\Resources\Products\Pages\ListProducts;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProducts::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Tổng sản phẩm', $this->getPageTableQuery()->count()),
            Stat::make('Tồn kho sản phẩm', $this->getPageTableQuery()->sum('qty')),
            Stat::make('Giá trung bình', number_format((float) $this->getPageTableQuery()->avg('price'), 0, ',', '.') . ' VND'),
        ];
    }
}
