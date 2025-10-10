<?php

namespace App\Filament\Exports\Blog;

use App\Models\Blog\Author;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AuthorExporter extends Exporter
{
    protected static ?string $model = Author::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Mã ID'),
            ExportColumn::make('name'),
            ExportColumn::make('email')
                ->label('Địa chỉ email'),
            ExportColumn::make('github_handle')
                ->label('Tài khoản GitHub'),
            ExportColumn::make('twitter_handle'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at')
                ->label('Lần sửa cuối'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Việc xuất tác giả của bạn đã hoàn thành và ' . number_format($export->successful_rows) . ' ' . str('dòng')->plural($export->successful_rows) . ' đã được xuất.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
