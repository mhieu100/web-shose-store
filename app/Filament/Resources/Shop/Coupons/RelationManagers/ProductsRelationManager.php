<?php

namespace App\Filament\Resources\Shop\Coupons\RelationManagers;

use App\Models\Shop\Product;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Actions\AttachAction;


use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Sản phẩm áp dụng';

    protected static ?string $modelLabel = 'Sản phẩm';

    protected static ?string $pluralModelLabel = 'Sản phẩm';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('shop_product_id')
                    ->label('Sản phẩm')
                    ->relationship('products', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->getOptionLabelFromRecordUsing(fn (Product $record) => "{$record->name} (#{$record->sku})"),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('product_images')
                    ->label('Hình ảnh')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->getStateUsing(function ($record) {
                        return $record->getMedia('product-images')->take(3)->map(fn ($media) => $media->getUrl('thumb'));
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Giá')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' VNĐ')
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Thương hiệu')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Hiển thị')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pivot.created_at')
                    ->label('Thêm vào lúc')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible')
                    ->label('Hiển thị')
                    ->placeholder('Tất cả')
                    ->trueLabel('Đang hiển thị')
                    ->falseLabel('Đã ẩn'),

                Tables\Filters\SelectFilter::make('brand')
                    ->label('Thương hiệu')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Thêm sản phẩm')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'sku'])
                    ->recordSelectOptionsQuery(function ($query) {
                        return $query->where('is_visible', true);
                    })
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->multiple()
                            ->getOptionLabelFromRecordUsing(fn (Product $record) => "{$record->name} (#{$record->sku})")
                            ->searchable(['name', 'sku']),
                    ]),
            ])
            ->actions([
                DetachAction::make()
                    ->label('Gỡ bỏ'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->label('Gỡ bỏ các sản phẩm đã chọn'),
                ]),
            ])
            ->emptyStateHeading('Chưa có sản phẩm nào')
            ->emptyStateDescription('Mã giảm giá này sẽ áp dụng cho tất cả sản phẩm. Thêm sản phẩm cụ thể để giới hạn phạm vi áp dụng.')
            ->emptyStateIcon('heroicon-o-cube');
    }
}
