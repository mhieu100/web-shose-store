<?php

namespace App\Filament\Resources\AffiliateLinks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AffiliateLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('shop_product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('link_code')
                    ->required(),
                TextInput::make('original_url')
                    ->required(),
                TextInput::make('affiliate_url')
                    ->required(),
                TextInput::make('clicks')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('conversions')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_commission')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('is_active')
                    ->required(),
                DateTimePicker::make('last_clicked_at'),
            ]);
    }
}
