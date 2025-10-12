<?php

namespace App\Filament\Resources\Commissions;

use App\Filament\Resources\Commissions\Pages\ManageCommissions;
use App\Models\Commission;
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

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';
    
    protected static string | UnitEnum | null $navigationGroup = 'Quản lý CTV';
    
    protected static ?string $navigationLabel = 'Hoa hồng CTV';
    
    protected static ?string $modelLabel = 'Hoa hồng';
    
    protected static ?string $pluralModelLabel = 'Hoa hồng CTV';
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\Commissions\Schemas\CommissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\Commissions\Tables\CommissionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCommissions::route('/'),
        ];
    }
}
