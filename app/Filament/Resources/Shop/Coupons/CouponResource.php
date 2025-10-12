<?php

namespace App\Filament\Resources\Shop\Coupons;

use App\Enums\CouponType;
use App\Filament\Resources\Shop\Coupons\Pages;
use App\Filament\Resources\Shop\Coupons\RelationManagers;
use App\Filament\Resources\Shop\Coupons\Tables\CouponsTable;
use App\Filament\Resources\Shop\Coupons\Schemas\CouponForm;
use App\Filament\Resources\Shop\Coupons\Schemas\CouponInfolist;
use App\Models\Shop\Coupon;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;
use BackedEnum;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $slug = 'shop/coupons';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Mã giảm giá';

    protected static ?string $modelLabel = 'Mã giảm giá';

    protected static ?string $pluralModelLabel = 'Mã giảm giá';

    protected static string | UnitEnum | null $navigationGroup = 'Cửa hàng';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CouponForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CouponsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CouponInfolist::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'view' => Pages\ViewCoupon::route('/{record}'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'name', 'description'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Coupon $record */

        return [
            'Loại' => $record->type->getLabel(),
            'Trạng thái' => $record->isValid() ? 'Hoạt động' : 'Không hoạt động',
        ];
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'name';
    }
}