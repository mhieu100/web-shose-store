<?php

namespace App\Filament\Clusters\Products\Resources\Products\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->label('Hình ảnh')
                    ->collection('product-images')
                    ->conversion('thumb')
                    ->limit(1)
                    ->circular()
                    ->stacked()
                    ->size(60),

                TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand.name')
                    ->label('Thương hiệu')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_visible')
                    ->label('Hiển thị')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('price')
                    ->label('Giá')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sku')
                    ->label('Mã SKU')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('qty')
                    ->label('Số lượng')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TagsColumn::make('sizes')
                    ->label('Kích cỡ')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TagsColumn::make('colors')
                    ->label('Màu sắc')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('security_stock')
                    ->label('Tồn kho an toàn')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('published_at')
                    ->label('Ngày xuất bản')
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('name'),
                        TextConstraint::make('slug'),
                        TextConstraint::make('sku')
                            ->label('Mã SKU (Đơn vị lưu kho)'),
                        TextConstraint::make('barcode')
                            ->label('Mã vạch (ISBN, UPC, GTIN, v.v.)'),
                        TextConstraint::make('description'),
                        NumberConstraint::make('old_price')
                            ->label('Giá so sánh')
                            ->icon('heroicon-m-currency-dollar'),
                        NumberConstraint::make('price')
                            ->icon('heroicon-m-currency-dollar'),
                        NumberConstraint::make('cost')
                            ->label('Giá vốn mỗi sản phẩm')
                            ->icon('heroicon-m-currency-dollar'),
                        NumberConstraint::make('qty')
                            ->label('Số lượng'),
                        NumberConstraint::make('security_stock'),
                        BooleanConstraint::make('is_visible')
                            ->label('Hiển thị'),
                        BooleanConstraint::make('featured'),
                        BooleanConstraint::make('backorder'),
                        BooleanConstraint::make('requires_shipping')
                            ->icon('heroicon-m-truck'),
                        DateConstraint::make('published_at')
                            ->label('Ngày xuất bản'),
                    ])
                    ->constraintPickerColumns(2),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->recordActions([
                ViewAction::make()
                    ->label('Xem'),
                EditAction::make()
                    ->label('Sửa'),
                DeleteAction::make()
                    ->label('Xóa')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận xóa')
                    ->modalDescription('Bạn có chắc chắn muốn xóa? Hành động này không thể hoàn tác.')
                    ->modalSubmitActionLabel('Xóa')
                    ->modalCancelActionLabel('Hủy'),
            ]);
    }
}
