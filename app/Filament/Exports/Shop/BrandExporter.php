<?php

namespace App\Filament\Exports\Shop;

use App\Models\Shop\Brand;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BrandExporter extends Exporter
{
    protected static ?string $model = Brand::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Mã ID'),
            ExportColumn::make('name'),
            ExportColumn::make('slug'),
            ExportColumn::make('website'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at')
                ->label('Lần sửa cuối'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Việc xuất thương hiệu của bạn đã hoàn thành và ' . number_format($export->successful_rows) . ' ' . str('dòng')->plural($export->successful_rows) . ' đã được xuất.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
