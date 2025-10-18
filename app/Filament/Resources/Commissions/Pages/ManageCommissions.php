<?php

namespace App\Filament\Resources\Commissions\Pages;

use App\Filament\Resources\Commissions\CommissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageCommissions extends ManageRecords
{
    protected static string $resource = CommissionResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with([
                'product',
                'order.items.product',
                'user'
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
