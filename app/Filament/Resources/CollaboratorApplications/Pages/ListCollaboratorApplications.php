<?php

namespace App\Filament\Resources\CollaboratorApplications\Pages;

use App\Filament\Resources\CollaboratorApplications\CollaboratorApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCollaboratorApplications extends ListRecords
{
    protected static string $resource = CollaboratorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
