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
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
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

                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Ngày đặt hàng')
                            ->state(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                        TextEntry::make('updated_at')
                            ->label('Lần sửa cuối')
                            ->state(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
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
            ->table([
                TableColumn::make('Sản phẩm'),
                TableColumn::make('Số lượng')
                    ->width(100),
                TableColumn::make('Đơn giá')
                    ->width(110),
            ])
            ->schema([
                Select::make('shop_product_id')
                    ->label('Sản phẩm')
                    ->options(Product::query()->pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Set $set) => $set('unit_price', Product::find($state)->price ?? 0))
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->searchable(),

                TextInput::make('qty')
                    ->label('Số lượng')
                    ->numeric()
                    ->default(1)
                    ->required(),

                TextInput::make('unit_price')
                    ->disabled()
                    ->dehydrated()
                    ->numeric()
                    ->required(),
            ])
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
