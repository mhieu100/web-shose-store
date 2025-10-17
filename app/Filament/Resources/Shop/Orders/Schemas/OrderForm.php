<?php

namespace App\Filament\Resources\Shop\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Filament\Clusters\Products\Resources\Products\ProductResource;
use App\Forms\Components\AddressForm;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Squire\Models\Currency;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema(static::getDetailsComponents())
                            ->columns(2),

                        Section::make('Mặt hàng đặt')
                            ->afterHeader([
                                Action::make('reset')
                                    ->modalHeading('Bạn có chắc chắn?')
                                    ->modalDescription('Tất cả các mục hiện có sẽ bị xóa khỏi đơn hàng.')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Set $set) => $set('items', [])),
                            ])
                            ->schema([
                                static::getItemsRepeater(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn (?Order $record) => $record === null ? 3 : 2]),

                Section::make('Thông tin thời gian')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Ngày đặt hàng')
                            ->state(fn (Order $record): ?string => $record->created_at?->format('d/m/Y H:i')),

                        TextEntry::make('updated_at')
                            ->label('Lần sửa cuối')
                            ->state(fn (Order $record): ?string => $record->updated_at?->format('d/m/Y H:i')),

                        TextEntry::make('shipped_at')
                            ->label('Ngày giao hàng')
                            ->state(fn (Order $record): ?string => $record->shipped_at?->format('d/m/Y H:i') ?? 'Chưa giao')
                            ->color(fn (Order $record) => $record->shipped_at ? 'success' : 'warning'),

                        TextEntry::make('delivered_at')
                            ->label('Ngày nhận hàng')
                            ->state(fn (Order $record): ?string => $record->delivered_at?->format('d/m/Y H:i') ?? 'Chưa nhận')
                            ->color(fn (Order $record) => $record->delivered_at ? 'success' : 'warning'),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Order $record) => $record === null),

                Section::make('Thông tin tài chính')
                    ->schema([
                        TextEntry::make('subtotal')
                            ->label('Tạm tính')
                            ->state(fn (Order $record): string => '$' . number_format($record->subtotal ?? 0, 2)),

                        TextEntry::make('coupon_code')
                            ->label('Mã giảm giá')
                            ->state(fn (Order $record): string => $record->coupon_code ?? 'Không có')
                            ->badge()
                            ->color(fn (Order $record) => $record->coupon_code ? 'success' : 'gray'),

                        TextEntry::make('coupon_discount')
                            ->label('Giảm giá')
                            ->state(fn (Order $record): string => $record->coupon_discount > 0 ? '-$' . number_format($record->coupon_discount, 2) : '$0.00')
                            ->color('success'),

                        TextEntry::make('shipping_amount')
                            ->label('Phí giao hàng')
                            ->state(fn (Order $record): string => '$' . number_format($record->shipping_amount ?? 0, 2)),

                        TextEntry::make('tax_amount')
                            ->label('Thuế')
                            ->state(fn (Order $record): string => '$' . number_format($record->tax_amount ?? 0, 2)),

                        TextEntry::make('total_amount')
                            ->label('Tổng cộng')
                            ->state(fn (Order $record): string => '$' . number_format($record->total_amount ?? 0, 2))
                            ->weight(FontWeight::Bold)
                            ->color('success'),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Order $record) => $record === null),

                Section::make('Địa chỉ giao hàng')
                    ->schema([
                        Placeholder::make('shipping_address_display')
                            ->label('')
                            ->content(function (?Order $record) {
                                if (!$record || !$record->shipping_address) {
                                    return new \Illuminate\Support\HtmlString('<div class="text-gray-500 italic">Chưa có thông tin địa chỉ giao hàng</div>');
                                }

                                $address = $record->shipping_address;
                                $lines = [];

                                if (!empty($address['address_line_1'])) {
                                    $lines[] = '<strong>Địa chỉ:</strong> ' . $address['address_line_1'];
                                }
                                if (!empty($address['address_line_2'])) {
                                    $lines[] = '<strong>Địa chỉ 2:</strong> ' . $address['address_line_2'];
                                }
                                if (!empty($address['city'])) {
                                    $lines[] = '<strong>Thành phố:</strong> ' . $address['city'];
                                }
                                if (!empty($address['state'])) {
                                    $lines[] = '<strong>Tỉnh/Thành:</strong> ' . $address['state'];
                                }
                                if (!empty($address['postal_code'])) {
                                    $lines[] = '<strong>Mã bưu chính:</strong> ' . $address['postal_code'];
                                }
                                if (!empty($address['country'])) {
                                    $lines[] = '<strong>Quốc gia:</strong> ' . $address['country'];
                                }
                                if (!empty($address['phone'])) {
                                    $lines[] = '<strong>Điện thoại:</strong> ' . $address['phone'];
                                }

                                return new \Illuminate\Support\HtmlString('<div class="space-y-1">' . implode('<br>', $lines) . '</div>');
                            })
                            ->extraAttributes(['class' => 'text-sm'])
                            ->hidden(fn (?Order $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->collapsed()
                    ->hidden(fn (?Order $record) => $record === null),
            ])
            ->columns(3);
    }

    /**
     * @return array<Component>
     */
    public static function getDetailsComponents(): array
    {
        return [
            TextInput::make('number')
                ->default('OR-' . random_int(100000, 999999))
                ->disabled()
                ->dehydrated()
                ->required()
                ->maxLength(32)
                ->unique(Order::class, 'number', ignoreRecord: true),

            Select::make('shop_customer_id')
                ->relationship('customer', 'name')
                ->searchable()
                ->required()
                ->createOptionForm([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Địa chỉ email')
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->unique(),

                    TextInput::make('phone')
                        ->maxLength(255),
                ])
                ->createOptionAction(function (Action $action) {
                    return $action
                        ->modalHeading('Tạo khách hàng')
                        ->modalSubmitActionLabel('Tạo khách hàng')
                        ->modalWidth('lg');
                }),

            ToggleButtons::make('status')
                ->inline()
                ->options(OrderStatus::class)
                ->required(),

            Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::firstWhere('id', $value)?->getAttribute('name'))
                ->required(),

            AddressForm::make('address')
                ->columnSpan('full'),

            RichEditor::make('notes')
                ->columnSpan('full'),
        ];
    }

    public static function getItemsRepeater(): Repeater
    {
        return Repeater::make('items')
            ->relationship()
            ->schema([
                Select::make('shop_product_id')
                    ->label('Sản phẩm')
                    ->options(Product::query()->pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Set $set) => $set('unit_price', Product::find($state)->price ?? 0))
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->searchable()
                    ->columnSpan(2),

                TextInput::make('qty')
                    ->label('Số lượng')
                    ->numeric()
                    ->default(1)
                    ->required(),

                TextInput::make('unit_price')
                    ->label('Đơn giá')
                    ->disabled()
                    ->dehydrated()
                    ->numeric()
                    ->prefix('$')
                    ->required(),
            ])
            ->columns(4)
            ->extraItemActions([
                Action::make('openProduct')
                    ->tooltip('Mở sản phẩm')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(function (array $arguments, Repeater $component): ?string {
                        $itemData = $component->getRawItemState($arguments['item']);

                        $product = Product::find($itemData['shop_product_id']);

                        if (! $product) {
                            return null;
                        }

                        return ProductResource::getUrl('edit', ['record' => $product]);
                    }, shouldOpenInNewTab: true)
                    ->hidden(fn (array $arguments, Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['shop_product_id'])),
            ])
            ->orderColumn('sort')
            ->defaultItems(1)
            ->hiddenLabel()
            ->required();
    }
}
