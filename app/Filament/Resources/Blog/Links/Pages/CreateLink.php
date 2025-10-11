<?php

namespace App\Filament\Resources\Blog\Links\Pages;

use App\Filament\Resources\Blog\Links\LinkResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLink extends CreateRecord
{

    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
