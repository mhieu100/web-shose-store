<?php

namespace App\Filament\Resources\CommissionWithdrawals\Pages;

use App\Filament\Resources\CommissionWithdrawals\CommissionWithdrawalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommissionWithdrawal extends EditRecord
{
    protected static string $resource = CommissionWithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
