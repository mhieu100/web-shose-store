<?php

namespace App\Filament\Resources\CollaboratorApplications;

use App\Filament\Resources\CollaboratorApplications\Pages\CreateCollaboratorApplication;
use App\Filament\Resources\CollaboratorApplications\Pages\EditCollaboratorApplication;
use App\Filament\Resources\CollaboratorApplications\Pages\ListCollaboratorApplications;
use App\Filament\Resources\CollaboratorApplications\Schemas\CollaboratorApplicationForm;
use App\Filament\Resources\CollaboratorApplications\Tables\CollaboratorApplicationsTable;
use App\Models\CollaboratorApplication;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CollaboratorApplicationResource extends Resource
{
    protected static ?string $model = CollaboratorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';
    
    protected static string|UnitEnum|null $navigationGroup = 'Quản lý CTV';
    
    protected static ?string $navigationLabel = 'Đơn đăng ký CTV';
    
    protected static ?string $modelLabel = 'Đơn đăng ký cộng tác viên';
    
    protected static ?string $pluralModelLabel = 'Đơn đăng ký cộng tác viên';

    public static function form(Schema $schema): Schema
    {
        return CollaboratorApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollaboratorApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCollaboratorApplications::route('/'),
            'create' => CreateCollaboratorApplication::route('/create'),
            'edit' => EditCollaboratorApplication::route('/{record}/edit'),
        ];
    }
}
