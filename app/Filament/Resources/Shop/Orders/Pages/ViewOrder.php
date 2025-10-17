<?php

namespace App\Filament\Resources\Shop\Orders\Pages;

use App\Filament\Resources\Shop\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Support\Enums\FontWeight;
use Filament\Notifications\Notification;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Chỉnh sửa đơn hàng')
                ->icon('heroicon-o-pencil')
                ->color('warning'),
                
            Action::make('print_invoice')
                ->label('In hóa đơn')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn () => route('invoice.download', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => in_array($this->record->status, ['delivered', 'shipped'])),
                
            Action::make('mark_processing')
                ->label('Xử lý đơn hàng')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->action(function () {
                    $this->record->update(['status' => 'processing']);
                    Notification::make()
                        ->title('Đã cập nhật trạng thái đơn hàng thành "Đang xử lý"')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'new')
                ->requiresConfirmation()
                ->modalHeading('Xác nhận xử lý đơn hàng')
                ->modalDescription('Bạn có chắc chắn muốn chuyển đơn hàng này sang trạng thái "Đang xử lý"?'),
                
            Action::make('mark_shipped')
                ->label('Giao hàng')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->action(function () {
                    $this->record->update([
                        'status' => 'shipped',
                        'shipped_at' => now()
                    ]);
                    Notification::make()
                        ->title('Đã đánh dấu đơn hàng đã giao cho đơn vị vận chuyển')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'processing')
                ->requiresConfirmation()
                ->modalHeading('Xác nhận giao hàng')
                ->modalDescription('Đơn hàng sẽ được chuyển sang trạng thái "Đã gửi" và ghi nhận thời gian giao hàng.'),
                
            Action::make('mark_delivered')
                ->label('Hoàn thành')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function () {
                    $this->record->update([
                        'status' => 'delivered',
                        'delivered_at' => now(),
                        'payment_status' => 'completed'
                    ]);
                    Notification::make()
                        ->title('Đã hoàn thành đơn hàng')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'shipped')
                ->requiresConfirmation()
                ->modalHeading('Xác nhận hoàn thành đơn hàng')
                ->modalDescription('Đơn hàng sẽ được đánh dấu là "Đã giao" và trạng thái thanh toán sẽ chuyển thành "Hoàn thành".'),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Thông tin đơn hàng')
                            ->schema([
                                Placeholder::make('order_info')
                                    ->label('')
                                    ->content(function ($record): string {
                                $html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';
                                        
                                        // Order Number
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Mã đơn hàng</label>';
                                        $html .= '<div class="mt-1 text-sm font-bold text-gray-900">' . ($record->order_number ?? 'N/A') . '</div>';
                                        $html .= '</div>';
                                        
                                        // Status
                                        $statusText = match ($record->status?->value ?? $record->status) {
                                            'new' => 'Mới',
                                            'processing' => 'Đang xử lý',
                                            'shipped' => 'Đã gửi',
                                            'delivered' => 'Đã giao',
                                            'cancelled' => 'Đã hủy',
                                            default => $record->status?->value ?? $record->status ?? 'N/A',
                                        };
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Trạng thái</label>';
                                        $html .= '<div class="mt-1"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">' . $statusText . '</span></div>';
                                        $html .= '</div>';
                                        
                                        // Payment Status
                                        $paymentStatusText = match ($record->payment_status) {
                                            'pending' => 'Chờ thanh toán',
                                            'processing' => 'Đang xử lý',
                                            'completed' => 'Đã thanh toán',
                                            'failed' => 'Thất bại',
                                            'cancelled' => 'Đã hủy',
                                            'refunded' => 'Đã hoàn tiền',
                                            default => $record->payment_status ?? 'N/A',
                                        };
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Trạng thái thanh toán</label>';
                                        $html .= '<div class="mt-1"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">' . $paymentStatusText . '</span></div>';
                                        $html .= '</div>';
                                        
                                        // Payment Method
                                        $paymentMethodText = match ($record->payment_method) {
                                            'cod' => 'Thanh toán khi nhận hàng',
                                            'bank_transfer' => 'Chuyển khoản',
                                            'paypal' => 'PayPal',
                                            default => $record->payment_method ?? 'N/A',
                                        };
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Phương thức thanh toán</label>';
                                        $html .= '<div class="mt-1"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">' . $paymentMethodText . '</span></div>';
                                        $html .= '</div>';
                                        
                                        // Currency
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Tiền tệ</label>';
                                        $html .= '<div class="mt-1"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . ($record->currency ?? 'USD') . '</span></div>';
                                        $html .= '</div>';
                                        
                                        // Created At
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Ngày đặt hàng</label>';
                                        $html .= '<div class="mt-1 text-sm text-gray-900">' . ($record->created_at ? $record->created_at->format('d/m/Y H:i') : 'N/A') . '</div>';
                                        $html .= '</div>';
                                        
                                        // Shipped At
                                        $html .= '<div>';
                                        $html .= '<label class="text-sm font-medium text-gray-700">Ngày giao hàng</label>';
                                        $html .= '<div class="mt-1 text-sm text-gray-900">' . ($record->shipped_at ? $record->shipped_at->format('d/m/Y H:i') : 'Chưa giao hàng') . '</div>';
                                        $html .= '</div>';
                                        
                                        $html .= '</div>';
                                        return $html;
                            }),
                    ])
                    ->columnSpan(['lg' => 2]),

                        Section::make('Thông tin khách hàng')
                            ->schema([
                                Placeholder::make('customer_info')
                                    ->label('')
                                    ->content(function ($record): HtmlString {
                                        $html = '<div class="space-y-6">';
                                        
                                        // Customer Avatar & Basic Info
                                        $html .= '<div class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">';
                                        
                                        // Avatar
                                        $customerName = $record->user ? $record->user->name : 'Khách vãng lai';
                                        $initials = strtoupper(substr($customerName, 0, 2));
                                        $html .= '<div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">';
                                        $html .= '<span class="text-white font-bold text-lg">' . $initials . '</span>';
                                        $html .= '</div>';
                                        
                                        // Customer Details
                                        $html .= '<div class="flex-1">';
                                        $html .= '<h3 class="text-xl font-bold text-gray-900 mb-1">' . htmlspecialchars($customerName) . '</h3>';
                                        
                                        if ($record->user && $record->user->email) {
                                            $html .= '<div class="flex items-center gap-2 text-gray-600 mb-1">';
                                            $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>';
                                            $html .= '<span class="text-sm">' . htmlspecialchars($record->user->email) . '</span>';
                                            $html .= '</div>';
                                        }
                                        
                                        if ($record->user && $record->user->phone) {
                                            $html .= '<div class="flex items-center gap-2 text-gray-600">';
                                            $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>';
                                            $html .= '<span class="text-sm">' . htmlspecialchars($record->user->phone) . '</span>';
                                            $html .= '</div>';
                                        }
                                        
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        // Order Notes
                                        if ($record->notes) {
                                            $html .= '<div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200">';
                                            $html .= '<div class="flex items-start gap-3">';
                                            $html .= '<svg class="w-4 h-4 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                                            $html .= '<div>';
                                            $html .= '<h4 class="font-semibold text-yellow-800 mb-1">Ghi chú của khách hàng</h4>';
                                            $html .= '<p class="text-yellow-700 text-sm leading-relaxed">' . nl2br(htmlspecialchars($record->notes)) . '</p>';
                                            $html .= '</div>';
                                            $html .= '</div>';
                                            $html .= '</div>';
                                        }
                                        
                                        $html .= '</div>';
                                        return new HtmlString($html);
                                    }),
                            ]),
                            
                        // Financial Summary Card
                        Section::make('Tổng kết tài chính')
                            ->description('Chi tiết về số tiền và thanh toán')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Placeholder::make('financial_card')
                                    ->label('')
                                    ->content(function ($record): HtmlString {
                                        $html = '<div class="space-y-4">';
                                        
                                        // Payment Method
                                        $paymentMethodText = match ($record->payment_method) {
                                            'cod' => 'Thanh toán khi nhận hàng',
                                            'bank_transfer' => 'Chuyển khoản ngân hàng',
                                            'paypal' => 'PayPal',
                                            'credit_card' => 'Thẻ tín dụng',
                                            default => $record->payment_method ?? 'Chưa xác định',
                                        };
                                        
                                        $paymentIcon = match ($record->payment_method) {
                                            'cod' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                                            'bank_transfer' => '<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
                                            default => '<svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                                        };
                                        
                                        $html .= '<div class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">';
                                        $html .= $paymentIcon;
                                        $html .= '<div>';
                                        $html .= '<h4 class="font-semibold text-gray-900">Phương thức thanh toán</h4>';
                                        $html .= '<p class="text-gray-600">' . $paymentMethodText . '</p>';
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        // Price Breakdown
                                        $html .= '<div class="bg-gray-50 rounded-xl p-4 space-y-3">';
                                        
                                        // Subtotal
                                        $html .= '<div class="flex justify-between items-center">';
                                        $html .= '<span class="text-gray-600">Tạm tính</span>';
                                        $html .= '<span class="font-medium">' . number_format($record->subtotal ?? 0, 0, ',', '.') . ' ₫</span>';
                                        $html .= '</div>';
                                        
                                        // Coupon discount
                                        if ($record->coupon_code && $record->coupon_discount > 0) {
                                            $html .= '<div class="flex justify-between items-center text-green-600">';
                                            $html .= '<span class="flex items-center gap-1">';
                                            $html .= '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>';
                                            $html .= 'Giảm giá (' . htmlspecialchars($record->coupon_code) . ')';
                                            $html .= '</span>';
                                            $html .= '<span class="font-medium">-' . number_format($record->coupon_discount, 0, ',', '.') . ' ₫</span>';
                                            $html .= '</div>';
                                        }
                                        
                                        // Shipping
                                        if ($record->shipping_amount > 0) {
                                            $html .= '<div class="flex justify-between items-center">';
                                            $html .= '<span class="text-gray-600">Phí giao hàng</span>';
                                            $html .= '<span class="font-medium">' . number_format($record->shipping_amount, 0, ',', '.') . ' ₫</span>';
                                            $html .= '</div>';
                                        }
                                        
                                        // Tax
                                        if ($record->tax_amount > 0) {
                                            $html .= '<div class="flex justify-between items-center">';
                                            $html .= '<span class="text-gray-600">Thuế</span>';
                                            $html .= '<span class="font-medium">' . number_format($record->tax_amount, 0, ',', '.') . ' ₫</span>';
                                            $html .= '</div>';
                                        }
                                        
                                        // Divider
                                        $html .= '<hr class="border-gray-300">';
                                        
                                        // Total
                                        $html .= '<div class="flex justify-between items-center text-lg">';
                                        $html .= '<span class="font-bold text-gray-900">Tổng cộng</span>';
                                        $html .= '<span class="font-bold text-green-600">' . number_format($record->total_amount ?? 0, 0, ',', '.') . ' ₫</span>';
                                        $html .= '</div>';
                                        
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        
                                        return new HtmlString($html);
                                    }),
                            ]),
                    ])
                    ->columns(2),

                // Shipping Address Section
                Section::make('Địa chỉ giao hàng')
                    ->description('Thông tin địa chỉ nhận hàng')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Placeholder::make('shipping_address')
                            ->label('')
                            ->content(function ($record): HtmlString {
                                if (!$record || !$record->shipping_address) {
                                    return new HtmlString('<div class="text-center py-8 text-gray-500">
                                        <svg class="w-8 h-8 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Chưa có thông tin địa chỉ giao hàng</p>
                                    </div>');
                                }
                                
                                $address = $record->shipping_address;
                                $html = '<div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">';
                                
                                // Address Header
                                $html .= '<div class="flex items-center gap-3 mb-4">';
                                $html .= '<div class="p-2 bg-blue-500 rounded-lg">';
                                $html .= '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>';
                                $html .= '</div>';
                                $html .= '<h3 class="text-lg font-bold text-gray-900">Địa chỉ nhận hàng</h3>';
                                $html .= '</div>';
                                
                                // Address Details Grid
                                $html .= '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
                                
                                if (!empty($address['address_line_1'])) {
                                    $html .= '<div class="bg-white rounded-lg p-3">';
                                    $html .= '<label class="text-xs text-gray-500 font-medium uppercase tracking-wide">Địa chỉ</label>';
                                    $html .= '<p class="text-gray-900 font-medium mt-1">' . htmlspecialchars($address['address_line_1']) . '</p>';
                                    $html .= '</div>';
                                }
                                
                                if (!empty($address['city'])) {
                                    $html .= '<div class="bg-white rounded-lg p-3">';
                                    $html .= '<label class="text-xs text-gray-500 font-medium uppercase tracking-wide">Thành phố</label>';
                                    $html .= '<p class="text-gray-900 font-medium mt-1">' . htmlspecialchars($address['city']) . '</p>';
                                    $html .= '</div>';
                                }
                                
                                if (!empty($address['state'])) {
                                    $html .= '<div class="bg-white rounded-lg p-3">';
                                    $html .= '<label class="text-xs text-gray-500 font-medium uppercase tracking-wide">Tỉnh/Thành phố</label>';
                                    $html .= '<p class="text-gray-900 font-medium mt-1">' . htmlspecialchars($address['state']) . '</p>';
                                    $html .= '</div>';
                                }
                                
                                if (!empty($address['postal_code'])) {
                                    $html .= '<div class="bg-white rounded-lg p-3">';
                                    $html .= '<label class="text-xs text-gray-500 font-medium uppercase tracking-wide">Mã bưu chính</label>';
                                    $html .= '<p class="text-gray-900 font-medium mt-1">' . htmlspecialchars($address['postal_code']) . '</p>';
                                    $html .= '</div>';
                                }
                                
                                if (!empty($address['country'])) {
                                    $html .= '<div class="bg-white rounded-lg p-3">';
                                    $html .= '<label class="text-xs text-gray-500 font-medium uppercase tracking-wide">Quốc gia</label>';
                                    $html .= '<p class="text-gray-900 font-medium mt-1">' . htmlspecialchars($address['country']) . '</p>';
                                    $html .= '</div>';
                                }
                                
                                if (!empty($address['phone'])) {
                                    $html .= '<div class="bg-white rounded-lg p-3 md:col-span-2">';
                                    $html .= '<label class="text-xs text-gray-500 font-medium uppercase tracking-wide">Số điện thoại</label>';
                                    $html .= '<p class="text-gray-900 font-medium mt-1">' . htmlspecialchars($address['phone']) . '</p>';
                                    $html .= '</div>';
                                }
                                
                                $html .= '</div>';
                                $html .= '</div>';
                                
                                return new HtmlString($html);
                            }),
                    ])
                    ->columnSpan('full'),

                // Order Items Section
                Section::make('Sản phẩm đã đặt')
                    ->description('Danh sách các sản phẩm trong đơn hàng')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Placeholder::make('order_items')
                            ->label('')
                            ->content(function ($record): HtmlString {
                                if (!$record || !$record->items || $record->items->count() === 0) {
                                    return new HtmlString('<div class="text-center py-8 text-gray-500">
                                        <svg class="w-8 h-8 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Không có sản phẩm nào trong đơn hàng</p>
                                    </div>');
                                }
                                
                                $html = '<div class="space-y-4">';
                                
                                foreach ($record->items as $index => $item) {
                                    $product = $item->product;
                                    $productName = $product ? $product->name : 'Sản phẩm đã bị xóa';
                                    $productSku = $product && $product->sku ? $product->sku : 'N/A';
                                    $total = $item->qty * $item->unit_price;
                                    
                                    $html .= '<div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow duration-200">';
                                    
                                    // Item Header
                                    $html .= '<div class="flex items-start justify-between mb-3">';
                                    $html .= '<div class="flex items-start gap-3">';
                                    
                                    // Item Number Badge
                                    $html .= '<div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">';
                                    $html .= ($index + 1);
                                    $html .= '</div>';
                                    
                                    // Product Info
                                    $html .= '<div>';
                                    $html .= '<h4 class="font-bold text-gray-900 text-lg">' . htmlspecialchars($productName) . '</h4>';
                                    $html .= '<p class="text-sm text-gray-500">SKU: ' . htmlspecialchars($productSku) . '</p>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    
                                    // Price Badge
                                    $html .= '<div class="text-right">';
                                    $html .= '<div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold">';
                                    $html .= number_format($total, 0, ',', '.') . ' ₫';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    
                                    // Item Details
                                    $html .= '<div class="grid grid-cols-3 gap-4 pt-3 border-t border-gray-100">';
                                    
                                    $html .= '<div class="text-center">';
                                    $html .= '<p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Số lượng</p>';
                                    $html .= '<p class="text-lg font-bold text-gray-900 mt-1">' . $item->qty . '</p>';
                                    $html .= '</div>';
                                    
                                    $html .= '<div class="text-center">';
                                    $html .= '<p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Đơn giá</p>';
                                    $html .= '<p class="text-lg font-bold text-gray-900 mt-1">' . number_format($item->unit_price, 0, ',', '.') . ' ₫</p>';
                                    $html .= '</div>';
                                    
                                    $html .= '<div class="text-center">';
                                    $html .= '<p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Thành tiền</p>';
                                    $html .= '<p class="text-lg font-bold text-green-600 mt-1">' . number_format($total, 0, ',', '.') . ' ₫</p>';
                                    $html .= '</div>';
                                    
                                    $html .= '</div>';
                                    $html .= '</div>';
                                }
                                
                                $html .= '</div>';
                                
                                return new HtmlString($html);
                            }),
                    ])
                    ->columnSpan('full'),
            ])
            ->columns(1);
    }
}