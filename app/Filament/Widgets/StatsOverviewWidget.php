<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        $startDate = ! is_null($this->pageFilters['startDate'] ?? null)
            ? Carbon::parse($this->pageFilters['startDate'])
            : now()->startOfMonth();

        $endDate = ! is_null($this->pageFilters['endDate'] ?? null)
            ? Carbon::parse($this->pageFilters['endDate'])
            : now();

        $paidOrdersQuery = Order::query()
            ->where('payment_status', 'completed')
            ->whereBetween('created_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()]);

        $revenue = (float) (clone $paidOrdersQuery)->sum('total_price');
        $paidOrders = (clone $paidOrdersQuery)->count();
        $newCustomers = (clone $paidOrdersQuery)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $rangeLabel = $startDate->isSameMonth($endDate)
            ? 'Tháng ' . $startDate->format('m/Y')
            : $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');

        $formatNumber = static fn (int $number): string => Number::format($number, 0);
        $formatCurrency = static fn (float $amount): string => number_format($amount, 0, ',', '.') . ' ₫';

        return [
            Stat::make('Doanh thu', $formatCurrency($revenue))
                ->description($rangeLabel)
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
            Stat::make('Khách hàng mới', $formatNumber($newCustomers))
                ->description($rangeLabel)
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            Stat::make('Đơn hàng thanh toán', $formatNumber($paidOrders))
                ->description($rangeLabel)
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
        ];
    }
}
