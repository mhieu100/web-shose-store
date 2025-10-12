<?php

namespace App\Filament\Resources\BannerResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Thông tin banner')
                    ->schema([
                        TextInput::make('title')
                            ->label('Tiêu đề')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(3)
                            ->maxLength(500),

                        TextInput::make('link_url')
                            ->label('Link URL')
                            ->url()
                            ->placeholder('https://example.com'),

                        FileUpload::make('image_path')
                            ->label('Hình ảnh banner')
                            ->image()
                            ->required()
                            ->directory('banners')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->rules([
                                'required',
                                'file',
                                'max:5120',
                                'mimetypes:image/jpeg,image/jpg,image/png,image/gif,image/webp',
                            ])
                            ->helperText('Kích thước tối đa: 5MB. Định dạng: JPG, PNG, GIF, WebP. Khuyến nghị: 1920x1080px')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                    ])
                    ->columns(2),

                Section::make('Cài đặt hiển thị')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Hiển thị')
                            ->default(true)
                            ->helperText('Bật/tắt hiển thị banner trên trang chủ'),

                        TextInput::make('sort_order')
                            ->label('Thứ tự sắp xếp')
                            ->numeric()
                            ->default(0)
                            ->helperText('Số nhỏ hơn sẽ hiển thị trước'),

                        DateTimePicker::make('start_date')
                            ->label('Ngày bắt đầu')
                            ->helperText('Để trống nếu không giới hạn thời gian bắt đầu'),

                        DateTimePicker::make('end_date')
                            ->label('Ngày kết thúc')
                            ->helperText('Để trống nếu không giới hạn thời gian kết thúc'),
                    ])
                    ->columns(2),
            ]);
    }
}
