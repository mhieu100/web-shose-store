<?php

namespace App\Filament\Resources\CommissionWithdrawals;

use App\Filament\Resources\CommissionWithdrawals\Pages\ManageCommissionWithdrawals;
use App\Models\CommissionWithdrawal;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use UnitEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CommissionWithdrawalResource extends Resource
{
    protected static ?string $model = CommissionWithdrawal::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';
    
    protected static string | UnitEnum | null $navigationGroup = 'Quản lý CTV';
    
    protected static ?string $navigationLabel = 'Yêu cầu rút tiền';
    
    protected static ?string $modelLabel = 'Yêu cầu rút tiền';
    
    protected static ?string $pluralModelLabel = 'Yêu cầu rút tiền';
    
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\CommissionWithdrawals\Schemas\CommissionWithdrawalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\CommissionWithdrawals\Tables\CommissionWithdrawalsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCommissionWithdrawals::route('/'),
        ];
    }
}
