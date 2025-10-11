<?php

namespace App\Filament\Resources\Blog\Links\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Tiêu đề')
                            ->maxLength(255)
                            ->required()
                            ->placeholder('Nhập tiêu đề liên kết'),

                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('https://example.com'),

                        ColorPicker::make('color')
                            ->label('Màu sắc')
                            ->required()
                            ->hex()
                            ->hexColor()
                            ->default('#3b82f6')
                            ->columnSpan('full'),

                        Textarea::make('description')
                            ->label('Mô tả')
                            ->maxLength(1024)
                            ->required()
                            ->rows(4)
                            ->placeholder('Nhập mô tả chi tiết về liên kết này...')
                            ->columnSpan('full'),

                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Hình ảnh')
                            ->collection('link-images')
                            ->acceptedFileTypes(['image/jpeg', 'image/png'])
                            ->image()
                            ->helperText('Chọn ảnh JPG hoặc PNG')
                            ->columnSpan('full'),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 3]),
            ])
            ->columns(3);
    }
}
