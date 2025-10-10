<?php

namespace App\Filament\Imports\Blog;

use App\Models\Blog\Category;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CategoryImporter extends Importer
{
    protected static ?string $model = Category::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('Category A'),
            ImportColumn::make('slug')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('category-a'),
            ImportColumn::make('description')
                ->example('Đây là mô tả cho Danh mục A.'),
            ImportColumn::make('is_visible')
                ->label('Hiển thị')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->example('yes'),
            ImportColumn::make('seo_title')
                ->label('Tiêu đề SEO')
                ->rules(['max:60'])
                ->example('Awesome Category A'),
            ImportColumn::make('seo_description')
                ->label('Mô tả SEO')
                ->rules(['max:160'])
                ->example('Wow! It\'s just so amazing.'),
        ];
    }

    public function resolveRecord(): ?Category
    {
        return Category::firstOrNew([
            'slug' => $this->data['slug'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Việc nhập danh mục blog của bạn đã hoàn thành và ' . number_format($import->successful_rows) . ' ' . str('dòng')->plural($import->successful_rows) . ' đã được nhập.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
