<?php

namespace App\Filament\Resources\Blog\Categories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('description'),
                IconEntry::make('is_visible')
                    ->label('Hiển thị'),
                TextEntry::make('updated_at')
                    ->label('Lần sửa cuối')
                    ->dateTime(),
            ])
            ->columns(1)
            ->inlineLabel();
    }
}
