<?php

namespace App\Filament\Resources\CollaboratorApplications\Pages;

use App\Filament\Resources\CollaboratorApplications\CollaboratorApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCollaboratorApplication extends EditRecord
{
    protected static string $resource = CollaboratorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
