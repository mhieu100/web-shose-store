<?php

namespace App\Filament\Resources\CommissionSettings;

use App\Filament\Resources\CommissionSettings\Pages\ManageCommissionSettings;
use App\Models\CommissionSetting;
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

class CommissionSettingResource extends Resource
{
    protected static ?string $model = CommissionSetting::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-8-tooth';
    
    protected static string | UnitEnum | null $navigationGroup = 'Quản lý CTV';
    
    protected static ?string $navigationLabel = 'Cài đặt hoa hồng';
    
    protected static ?string $modelLabel = 'Cài đặt hoa hồng';
    
    protected static ?string $pluralModelLabel = 'Cài đặt hoa hồng';
    
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\CommissionSettings\Schemas\CommissionSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\CommissionSettings\Tables\CommissionSettingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCommissionSettings::route('/'),
        ];
    }
}
