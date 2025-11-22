<?php

namespace App\Filament\Clusters\Products\Resources\Products\Schemas;

use App\Enums\ProductAttributesEnum;
use App\Filament\Clusters\Products\Resources\Brands\RelationManagers\ProductsRelationManager;
use App\Models\Shop\Product;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                                        if ($operation !== 'create') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    }),

                                TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Product::class, 'slug', ignoreRecord: true),

                                RichEditor::make('description')
                                    ->columnSpan('full'),

                                Select::make('sizes')
                                    ->label('Kích cỡ')
                                    ->multiple()
                                    ->searchable()
                                    ->options(ProductAttributesEnum::getSizes())
                                    ->helperText('Chọn các kích cỡ có sẵn cho sản phẩm này')
                                    ->placeholder('Chọn kích cỡ'),

                                Select::make('colors')
                                    ->label('Màu sắc')
                                    ->multiple()
                                    ->searchable()
                                    ->options(ProductAttributesEnum::getColorNames())
                                    ->helperText('Chọn các màu sắc có sẵn cho sản phẩm này')
                                    ->placeholder('Chọn màu sắc'),
                            ])
                            ->columns(2),

                        Section::make('Hình ảnh')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('product-images')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->reorderable()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->hiddenLabel()
                                    ->maxSize(2048) // Limit to 2MB
                                    ->previewable()
                                    ->downloadable()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('800'),
                            ])
                            ->collapsible(),

                        Section::make('Định giá')
                            ->schema([
                                TextInput::make('price')
                                    ->label('Giá sản phẩm')
                                    ->rules(['required', 'string'])
                                    ->required()
                                    ->suffix('VNĐ')
                                    ->helperText('Giá bán sản phẩm cho khách hàng (tối đa 9.999.999.999 VNĐ). Nhập số nguyên hoặc có dấu chấm phân cách hàng nghìn.')
                                    ->placeholder('Ví dụ: 3000000 hoặc 3.000.000')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '')
                                    ->dehydrateStateUsing(function ($state) {
                                        if (!$state) return null;
                                        // Remove thousand separators (dots) and keep only digits
                                        $cleaned = preg_replace('/[^\d]/', '', $state);
                                        // Validate the cleaned value is numeric and within range
                                        if (!is_numeric($cleaned) || $cleaned < 0 || $cleaned > 9999999999) {
                                            throw new \Exception('Giá không hợp lệ. Vui lòng nhập số từ 0 đến 9.999.999.999');
                                        }
                                        return (int) $cleaned;
                                    }),

                                TextInput::make('old_price')
                                    ->label('Giá gốc')
                                    ->rules(['nullable', 'string'])
                                    ->suffix('VNĐ')
                                    ->helperText('Giá gốc trước khi giảm (để tạo hiệu ứng sale)')
                                    ->placeholder('Ví dụ: 4000000 hoặc 4.000.000')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '')
                                    ->dehydrateStateUsing(function ($state) {
                                        if (!$state) return null;
                                        // Remove thousand separators (dots) and keep only digits
                                        $cleaned = preg_replace('/[^\d]/', '', $state);
                                        // Validate the cleaned value is numeric and within range
                                        if (!is_numeric($cleaned) || $cleaned < 0 || $cleaned > 9999999999) {
                                            throw new \Exception('Giá gốc không hợp lệ. Vui lòng nhập số từ 0 đến 9.999.999.999');
                                        }
                                        return (int) $cleaned;
                                    }),

                                TextInput::make('cost')
                                    ->label('Giá vốn')
                                    ->rules(['nullable', 'string'])
                                    ->suffix('VNĐ')
                                    ->helperText('Giá vốn để tính toán lợi nhuận (không hiển thị cho khách hàng)')
                                    ->placeholder('Ví dụ: 2000000 hoặc 2.000.000')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '')
                                    ->dehydrateStateUsing(function ($state) {
                                        if (!$state) return null;
                                        // Remove thousand separators (dots) and keep only digits
                                        $cleaned = preg_replace('/[^\d]/', '', $state);
                                        // Validate the cleaned value is numeric and within range
                                        if (!is_numeric($cleaned) || $cleaned < 0 || $cleaned > 9999999999) {
                                            throw new \Exception('Giá vốn không hợp lệ. Vui lòng nhập số từ 0 đến 9.999.999.999');
                                        }
                                        return (int) $cleaned;
                                    }),
                            ])
                            ->columns(1),
                        Section::make('Kho hàng')
                            ->schema([
                                TextInput::make('sku')
                                    ->label('Mã SKU (Đơn vị lưu kho)')
                                    ->unique(Product::class, 'sku', ignoreRecord: true)
                                    ->maxLength(255)
                                    ->required(),

                                TextInput::make('barcode')
                                    ->label('Mã vạch (ISBN, UPC, GTIN, v.v.)')
                                    ->unique(Product::class, 'barcode', ignoreRecord: true)
                                    ->maxLength(255)
                                    ->required(),

                                TextInput::make('qty')
                                    ->label('Số lượng')
                                    ->numeric()
                                    ->rules(['integer', 'min:0'])
                                    ->required(),

                                TextInput::make('security_stock')
                                    ->helperText('Tồn kho an toàn là giới hạn tồn kho cho sản phẩm của bạn, cảnh báo khi sản phẩm sắp hết hàng.')
                                    ->numeric()
                                    ->rules(['integer', 'min:0'])
                                    ->required(),
                            ])
                            ->columns(2),

                        Section::make('Vận chuyển')
                            ->schema([
                                Checkbox::make('backorder')
                                    ->label('Sản phẩm này có thể được trả lại'),

                                Checkbox::make('requires_shipping')
                                    ->label('Sản phẩm này sẽ được vận chuyển'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Trạng thái')
                            ->schema([
                                Toggle::make('is_visible')
                                    ->label('Hiển thị')
                                    ->helperText('Sản phẩm này sẽ bị ẩn khỏi tất cả các kênh bán hàng.')
                                    ->default(true),

                                DatePicker::make('published_at')
                                    ->label('Ngày xuất bản')
                                    ->default(now())
                                    ->required(),
                            ]),

                        Section::make('Liên kết')
                            ->schema([
                                Select::make('shop_brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->hiddenOn(ProductsRelationManager::class),

                                Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
