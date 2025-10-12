<?php

namespace App\Filament\Clusters\Products\Resources\Products\Schemas;

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

                                TagsInput::make('sizes')
                                    ->label('Kích cỡ')
                                    ->helperText('Nhập các kích cỡ có sẵn (ví dụ: S, M, L, XL hoặc 39, 40, 41, 42)')
                                    ->placeholder('Nhập kích cỡ và nhấn Enter'),

                                TagsInput::make('colors')
                                    ->label('Màu sắc')
                                    ->helperText('Nhập các màu sắc có sẵn (ví dụ: Đỏ, Xanh, Vàng, Đen)')
                                    ->placeholder('Nhập màu sắc và nhấn Enter'),
                            ])
                            ->columns(2),

                        Section::make('Hình ảnh')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('product-images')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->reorderable()
                                    ->acceptedFileTypes(['image/jpeg'])
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),

                        Section::make('Định giá')
                            ->schema([
                                TextInput::make('price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),

                                TextInput::make('old_price')
                                    ->label('Giá so sánh')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),

                                TextInput::make('cost')
                                    ->label('Giá vốn mỗi sản phẩm')
                                    ->helperText('Khách hàng sẽ không thấy giá này.')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                            ])
                            ->columns(2),
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
                                    ->hiddenOn(ProductsRelationManager::class),

                                Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
