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
use Illuminate\Support\HtmlString;
use Squire\Models\Currency;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Thông tin đơn hàng')
                            ->description('Tổng quan về đơn hàng')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Placeholder::make('order_summary')
                                    ->label('')
                                    ->content(function (?Order $record): HtmlString {
                                        if (!$record) {
                                            return new HtmlString('<div style="color: #6b7280; font-style: italic; text-align: center; padding: 1rem 0;">Đang tạo đơn hàng mới</div>');
                                        }

                                        $html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">';

                                        // Order Number Card
                                        $html .= '<div style="background: linear-gradient(to bottom right, #eff6ff, #dbeafe); border-radius: 0.75rem; padding: 1rem; border: 1px solid #bfdbfe;">';
                                        $html .= '<div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">';
                                        $html .= '<svg style="width: 1rem; height: 1rem; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>';
                                        $html .= '<span style="font-size: 0.75rem; font-weight: 600; color: #1d4ed8; text-transform: uppercase;">Mã đơn hàng</span>';
                                        $html .= '</div>';
                                        $html .= '<div style="font-size: 1rem; font-weight: 700; color: #1e3a8a;">' . ($record->order_number ?? 'N/A') . '</div>';
                                        $html .= '</div>';

                                        // Customer Info Card
                                        $customerName = $record->user ? $record->user->name : 'Khách vãng lai';
                                        $html .= '<div style="background: linear-gradient(to bottom right, #faf5ff, #f3e8ff); border-radius: 0.75rem; padding: 1rem; border: 1px solid #e9d5ff;">';
                                        $html .= '<div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">';
                                        $html .= '<svg style="width: 1rem; height: 1rem; color: #9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';
                                        $html .= '<span style="font-size: 0.75rem; font-weight: 600; color: #7e22ce; text-transform: uppercase;">Khách hàng</span>';
                                        $html .= '</div>';
                                        $html .= '<div style="font-size: 1rem; font-weight: 700; color: #581c87;">' . htmlspecialchars($customerName) . '</div>';
                                        if ($record->user && $record->user->email) {
                                            $html .= '<div style="font-size: 0.75rem; color: #7e22ce; margin-top: 0.25rem;">' . htmlspecialchars($record->user->email) . '</div>';
                                        }
                                        $html .= '</div>';

                                        // Total Amount Card
                                        $html .= '<div style="background: linear-gradient(to bottom right, #f0fdf4, #dcfce7); border-radius: 0.75rem; padding: 1rem; border: 1px solid #bbf7d0;">';
                                        $html .= '<div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">';
                                        $html .= '<svg style="width: 1rem; height: 1rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        $html .= '<span style="font-size: 0.75rem; font-weight: 600; color: #15803d; text-transform: uppercase;">Tổng tiền</span>';
                                        $html .= '</div>';
                                        $html .= '<div style="font-size: 1.125rem; font-weight: 700; color: #14532d;">' . number_format($record->total_amount ?? 0, 0, ',', '.') . ' ₫</div>';
                                        $html .= '</div>';

                                        $html .= '</div>';

                                        return new HtmlString($html);
                                    })
                                    ->columnSpanFull()
                                    ->hidden(fn (?Order $record) => $record === null),

                                ToggleButtons::make('status')
                                    ->label('Trạng thái')
                                    ->inline()
                                    ->options(OrderStatus::class)
                                    ->required(),
                            ])
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
                            ->state(fn (Order $record): string => number_format($record->subtotal ?? 0, 0, ',', '.') . ' ₫'),

                        TextEntry::make('coupon_code')
                            ->label('Mã giảm giá')
                            ->state(fn (Order $record): string => $record->coupon_code ?? 'Không có')
                            ->badge()
                            ->color(fn (Order $record) => $record->coupon_code ? 'success' : 'gray'),

                        TextEntry::make('coupon_discount')
                            ->label('Giảm giá')
                            ->state(fn (Order $record): string => $record->coupon_discount > 0 ? '-' . number_format($record->coupon_discount, 0, ',', '.') . ' ₫' : '0 ₫')
                            ->color('success'),

                        TextEntry::make('shipping_amount')
                            ->label('Phí giao hàng')
                            ->state(fn (Order $record): string => number_format($record->shipping_amount ?? 0, 0, ',', '.') . ' ₫'),

                        TextEntry::make('tax_amount')
                            ->label('Thuế')
                            ->state(fn (Order $record): string => number_format($record->tax_amount ?? 0, 0, ',', '.') . ' ₫'),

                        TextEntry::make('total_amount')
                            ->label('Tổng cộng')
                            ->state(fn (Order $record): string => number_format($record->total_amount ?? 0, 0, ',', '.') . ' ₫')
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
                ->preload()
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
                    ->searchable()
                    ->columnSpanFull(),

                TextInput::make('size')
                    ->label('Size')
                    ->placeholder('VD: 39, 40, 41...')
                    ->maxLength(50)
                    ->dehydrated()
                    ->columnSpan(1),

                TextInput::make('color')
                    ->label('Màu sắc')
                    ->placeholder('VD: Đen, Trắng, Xanh...')
                    ->maxLength(50)
                    ->dehydrated()
                    ->columnSpan(1),

                TextInput::make('qty')
                    ->label('Số lượng')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->columnSpan(1),

                TextInput::make('unit_price')
                    ->label('Đơn giá')
                    ->disabled()
                    ->dehydrated()
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->columnSpan(1),
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
