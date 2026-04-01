<?php

namespace App\Filament\Resources\Blog\Posts\Schemas;

use App\Models\Blog\Post;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Post::class, 'slug', ignoreRecord: true),

                        RichEditor::make('content')
                            ->required()
                            ->columnSpan('full'),

                        Select::make('blog_author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('blog_category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        DatePicker::make('published_at')
                            ->label('Ngày xuất bản'),

                        SpatieTagsInput::make('tags'),
                    ])
                    ->columns(2),

                Section::make('Hình ảnh')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('post-images')
                            ->hiddenLabel()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
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
                    ->collapsible(),
            ]);
    }
}
