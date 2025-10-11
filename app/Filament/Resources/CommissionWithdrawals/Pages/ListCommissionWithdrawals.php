<?php

namespace App\Filament\Resources\CommissionWithdrawals\Pages;

use App\Filament\Resources\CommissionWithdrawals\CommissionWithdrawalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommissionWithdrawals extends ListRecords
{
    protected static string $resource = CommissionWithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
