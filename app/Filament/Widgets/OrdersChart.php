<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected ?string $heading = 'Đơn hàng theo tháng';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Đơn hàng',
                    'data' => [2433, 3454, 4566, 3300, 5545, 5765, 6787, 8767, 7565, 8576, 9686, 8996],
                    'fill' => 'start',
                ],
            ],
            'labels' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
        ];
    }
}
