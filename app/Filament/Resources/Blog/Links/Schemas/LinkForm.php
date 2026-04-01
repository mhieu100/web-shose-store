<?php

namespace App\Filament\Resources\Blog\Links\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
                            ->columnSpan('full')
                            ->saveUploadedFileUsing(static function (SpatieMediaLibraryFileUpload $component, TemporaryUploadedFile $file, ?Model $record): ?string {
                                if (! $record) {
                                    return null;
                                }

                                try {
                                    if (! $file->exists()) {
                                        return null;
                                    }
                                } catch (\Throwable $exception) {
                                    return null;
                                }

                                $filePath = $file->getRealPath();

                                if (! $filePath || ! is_file($filePath)) {
                                    return null;
                                }

                                $media = $record->addMedia($filePath)
                                    ->addCustomHeaders($component->getCustomHeaders())
                                    ->usingFileName($component->getUploadedFileNameForStorage($file))
                                    ->usingName($component->getMediaName($file) ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                    ->storingConversionsOnDisk($component->getConversionsDisk() ?? '')
                                    ->withCustomProperties($component->getCustomProperties())
                                    ->withManipulations($component->getManipulations())
                                    ->withResponsiveImagesIf($component->hasResponsiveImages())
                                    ->withProperties($component->getProperties())
                                    ->toMediaCollection($component->getCollection() ?? 'default', $component->getDiskName());

                                return $media->getAttributeValue('uuid');
                            }),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 3]),
            ])
            ->columns(3);
    }
}
