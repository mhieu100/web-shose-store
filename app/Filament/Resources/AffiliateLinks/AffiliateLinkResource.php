<?php

namespace App\Filament\Resources\AffiliateLinks;

use App\Filament\Resources\AffiliateLinks\Pages\CreateAffiliateLink;
use App\Filament\Resources\AffiliateLinks\Pages\EditAffiliateLink;
use App\Filament\Resources\AffiliateLinks\Pages\ListAffiliateLinks;
use App\Filament\Resources\AffiliateLinks\Schemas\AffiliateLinkForm;
use App\Filament\Resources\AffiliateLinks\Tables\AffiliateLinksTable;
use App\Models\AffiliateLink;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AffiliateLinkResource extends Resource
{
    protected static ?string $model = AffiliateLink::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-link';
    
    protected static string|UnitEnum|null $navigationGroup = 'Quản lý CTV';
    
    protected static ?string $navigationLabel = 'Link Affiliate';
    
    protected static ?string $modelLabel = 'Link Affiliate';
    
    protected static ?string $pluralModelLabel = 'Link Affiliate';
    
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return AffiliateLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AffiliateLinksTable::configure($table);
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
            'index' => ListAffiliateLinks::route('/'),
            'create' => CreateAffiliateLink::route('/create'),
            'edit' => EditAffiliateLink::route('/{record}/edit'),
        ];
    }
}
