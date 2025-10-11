<?php

namespace App\Filament\Resources\Blog\Links\Pages;

use App\Filament\Resources\Blog\Links\LinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLinks extends ListRecords
{

    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tạo liên kết mới'),
        ];
    }
}
