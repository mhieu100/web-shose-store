<?php

namespace App\Filament\Resources\Shop\Orders\Pages;

use App\Filament\Resources\Shop\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Support\Enums\FontWeight;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Placeholder::make('order_info')
                                    ->label('')
                                    ->content(function ($record): HtmlString {
                                $html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">';

                                        // Order Number - Highlighted Card
                                        $html .= '<div style="background: linear-gradient(to bottom right, #eff6ff, #dbeafe); border-radius: 0.75rem; padding: 1rem; border: 2px solid #bfdbfe; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); transition: box-shadow 0.3s;">';
                                        $html .= '<div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">';
                                        $html .= '<svg style="width: 1rem; height: 1rem; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>';
                                        $html .= '<label style="font-size: 0.75rem; font-weight: 600; color: #1d4ed8; text-transform: uppercase; letter-spacing: 0.05em;">Mã đơn hàng</label>';
                                        $html .= '</div>';
                                        $html .= '<div style="font-size: 1.125rem; font-weight: 700; color: #1e3a8a;">' . ($record->order_number ?? 'N/A') . '</div>';
                                        $html .= '</div>';

                                        // Status
                                        $statusData = match ($record->status?->value ?? $record->status) {
                                            'new' => ['text' => 'Đơn mới', 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            'processing' => ['text' => 'Đang xử lý', 'color' => 'yellow', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>'],
                                            'shipped' => ['text' => 'Đã gửi hàng', 'color' => 'indigo', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>'],
                                            'delivered' => ['text' => 'Đã giao', 'color' => 'green', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            'cancelled' => ['text' => 'Đã hủy', 'color' => 'red', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            default => ['text' => $record->status?->value ?? $record->status ?? 'N/A', 'color' => 'gray', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                        };
                                        $html .= '<div class="bg-gradient-to-br from-' . $statusData['color'] . '-50 to-' . $statusData['color'] . '-100 rounded-xl p-4 border border-' . $statusData['color'] . '-200 shadow-sm hover:shadow-md transition-shadow">';
                                        $html .= '<div class="flex items-center gap-2 mb-2">';
                                        $html .= '<svg style="width: 1rem; height: 1rem;" class="text-' . $statusData['color'] . '-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $statusData['icon'] . '</svg>';
                                        $html .= '<label class="text-xs font-semibold text-' . $statusData['color'] . '-700 uppercase tracking-wider">Trạng thái</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-base font-bold text-' . $statusData['color'] . '-900">' . $statusData['text'] . '</div>';
                                        $html .= '</div>';

                                        // Payment Status
                                        $paymentData = match ($record->payment_status) {
                                            'pending' => ['text' => 'Chờ thanh toán', 'color' => 'amber', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            'processing' => ['text' => 'Đang xử lý', 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>'],
                                            'completed' => ['text' => 'Đã thanh toán', 'color' => 'green', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            'failed' => ['text' => 'Thất bại', 'color' => 'red', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            'cancelled' => ['text' => 'Đã hủy', 'color' => 'gray', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                            'refunded' => ['text' => 'Đã hoàn tiền', 'color' => 'purple', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>'],
                                            default => ['text' => $record->payment_status ?? 'N/A', 'color' => 'gray', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                                        };
                                        $html .= '<div class="bg-gradient-to-br from-' . $paymentData['color'] . '-50 to-' . $paymentData['color'] . '-100 rounded-xl p-4 border border-' . $paymentData['color'] . '-200 shadow-sm hover:shadow-md transition-shadow">';
                                        $html .= '<div class="flex items-center gap-2 mb-2">';
                                        $html .= '<svg style="width: 1rem; height: 1rem;" class="text-' . $paymentData['color'] . '-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $paymentData['icon'] . '</svg>';
                                        $html .= '<label class="text-xs font-semibold text-' . $paymentData['color'] . '-700 uppercase tracking-wider">Thanh toán</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-base font-bold text-' . $paymentData['color'] . '-900">' . $paymentData['text'] . '</div>';
                                        $html .= '</div>';

                                        // Payment Method
                                        $paymentMethodText = match ($record->payment_method) {
                                            'cod' => 'Thanh toán khi nhận hàng',
                                            'bank_transfer' => 'Chuyển khoản',
                                            'paypal' => 'PayPal',
                                            default => $record->payment_method ?? 'N/A',
                                        };
                                        $html .= '<div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">';
                                        $html .= '<div class="flex items-center gap-2 mb-2">';
                                        $html .= '<svg style="width: 1rem; height: 1rem;" class="text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>';
                                        $html .= '<label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Phương thức</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-sm font-medium text-gray-900">' . $paymentMethodText . '</div>';
                                        $html .= '</div>';

                                        // Created At
                                        $html .= '<div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">';
                                        $html .= '<div class="flex items-center gap-2 mb-2">';
                                        $html .= '<svg style="width: 1rem; height: 1rem;" class="text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
                                        $html .= '<label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày đặt</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-sm font-medium text-gray-900">' . ($record->created_at ? $record->created_at->format('d/m/Y H:i') : 'N/A') . '</div>';
                                        $html .= '</div>';

                                        // Shipped At
                                        $html .= '<div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">';
                                        $html .= '<div class="flex items-center gap-2 mb-2">';
                                        $html .= '<svg style="width: 1rem; height: 1rem;" class="text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>';
                                        $html .= '<label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Giao hàng</label>';
                                        $html .= '</div>';
                                        $html .= '<div class="text-sm font-medium ' . ($record->shipped_at ? 'text-gray-900' : 'text-gray-500 italic') . '">' . ($record->shipped_at ? $record->shipped_at->format('d/m/Y H:i') : 'Chưa giao hàng') . '</div>';
                                        $html .= '</div>';

                                        $html .= '</div>';
                                        return new HtmlString($html);
                            }),
                    ])
                    ->columnSpan(['lg' => 2]),

                        Section::make('Thông tin khách hàng')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Placeholder::make('customer_info')
                                    ->label('')
                                    ->content(function ($record): HtmlString {
                                        $html = '<div class="space-y-4">';

                                        // Modern Customer Card with Gradient
                                        $html .= '<div class="relative overflow-hidden bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">';

                                        // Decorative elements
                                        $html .= '<div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>';
                                        $html .= '<div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>';

                                        $html .= '<div class="relative flex items-center gap-5">';

                                        // Avatar with ring and status
                                        $customerName = $record->user ? $record->user->name : 'Khách vãng lai';
                                        $initials = strtoupper(substr($customerName, 0, 2));
                                        $html .= '<div class="flex-shrink-0">';
                                        $html .= '<div class="relative">';
                                        $html .= '<div class="w-20 h-20 rounded-full bg-white bg-opacity-20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white ring-opacity-30">';
                                        $html .= '<span class="text-2xl font-bold">' . $initials . '</span>';
                                        $html .= '</div>';
                                        $html .= '<div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-4 border-white shadow-sm"></div>';
                                        $html .= '</div>';
                                        $html .= '</div>';

                                        // Customer Info
                                        $html .= '<div class="flex-1 min-w-0">';
                                        $html .= '<h3 class="text-2xl font-bold text-white mb-3">' . htmlspecialchars($customerName) . '</h3>';

                                        $html .= '<div class="space-y-2">';

                                        // Email
                                        if ($record->user && $record->user->email) {
                                            $html .= '<div class="flex items-center text-white text-opacity-90">';
                                            $html .= '<div style="width: 2rem; height: 2rem;" class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">';
                                            $html .= '<svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
                                            $html .= '</div>';
                                            $html .= '<span class="text-sm font-medium truncate">' . htmlspecialchars($record->user->email) . '</span>';
                                            $html .= '</div>';
                                        }

                                        // Phone
                                        if ($record->user && $record->user->phone) {
                                            $html .= '<div class="flex items-center text-white text-opacity-90">';
                                            $html .= '<div style="width: 2rem; height: 2rem;" class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">';
                                            $html .= '<svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>';
                                            $html .= '</div>';
                                            $html .= '<span class="text-sm font-medium">' . htmlspecialchars($record->user->phone) . '</span>';
                                            $html .= '</div>';
                                        }

                                        $html .= '</div>'; // space-y-2
                                        $html .= '</div>'; // flex-1
                                        $html .= '</div>'; // flex items-center
                                        $html .= '</div>'; // gradient card

                                        // Order Notes - Modern Style
                                        if ($record->notes) {
                                            $html .= '<div class="relative bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 shadow-sm">';
                                            $html .= '<div class="flex gap-4">';
                                            $html .= '<div class="flex-shrink-0">';
                                            $html .= '<div style="width: 2.25rem; height: 2.25rem;" class="bg-amber-100 rounded-lg flex items-center justify-center">';
                                            $html .= '<svg style="width: 1.25rem; height: 1.25rem;" class="text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>';
                                            $html .= '</div>';
                                            $html .= '</div>';
                                            $html .= '<div class="flex-1">';
                                            $html .= '<h4 class="text-sm font-bold text-amber-900 mb-1 uppercase tracking-wide">Ghi chú đơn hàng</h4>';
                                            $html .= '<div class="text-sm text-amber-800 leading-relaxed">';
                                            $html .= nl2br(htmlspecialchars($record->notes));
                                            $html .= '</div>';
                                            $html .= '</div>';
                                            $html .= '</div>';
                                            $html .= '</div>';
                                        }

                                        $html .= '</div>';
                                        return new HtmlString($html);
                                    }),
                            ]),

                        // Financial Summary Card - Enhanced
                        Section::make('Tổng kết tài chính')
                            ->description('Chi tiết về số tiền và thanh toán')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Placeholder::make('financial_card')
                                    ->label('')
                                    ->content(function ($record): HtmlString {
                                        $html = '<div class="space-y-4">';

                                        // Payment Method - Enhanced Card
                                        $paymentMethodText = match ($record->payment_method) {
                                            'cod' => 'Thanh toán khi nhận hàng',
                                            'bank_transfer' => 'Chuyển khoản ngân hàng',
                                            'paypal' => 'PayPal',
                                            'credit_card' => 'Thẻ tín dụng',
                                            default => $record->payment_method ?? 'Chưa xác định',
                                        };

                                        $paymentData = match ($record->payment_method) {
                                            'cod' => ['icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'green'],
                                            'bank_transfer' => ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => 'blue'],
                                            'paypal' => ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => 'indigo'],
                                            default => ['icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'gray'],
                                        };

                                        $html .= '<div class="relative overflow-hidden bg-gradient-to-br from-' . $paymentData['color'] . '-50 to-' . $paymentData['color'] . '-100 rounded-xl p-5 border border-' . $paymentData['color'] . '-200 shadow-sm">';
                                        $html .= '<div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white opacity-10 rounded-full"></div>';
                                        $html .= '<div class="relative flex items-center gap-4">';
                                        $html .= '<div style="width: 2.5rem; height: 2.5rem;" class="bg-' . $paymentData['color'] . '-500 rounded-xl flex items-center justify-center shadow-md">';
                                        $html .= '<svg style="width: 1.25rem; height: 1.25rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $paymentData['icon'] . '"/></svg>';
                                        $html .= '</div>';
                                        $html .= '<div>';
                                        $html .= '<h4 class="text-xs font-semibold text-' . $paymentData['color'] . '-700 uppercase tracking-wider mb-1">Phương thức thanh toán</h4>';
                                        $html .= '<p class="text-base font-bold text-' . $paymentData['color'] . '-900">' . $paymentMethodText . '</p>';
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        $html .= '</div>';

                                        // Price Breakdown - Modern Design
                                        $html .= '<div class="bg-white rounded-xl border-2 border-gray-200 shadow-sm overflow-hidden">';

                                        // Header
                                        $html .= '<div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-3 border-b border-gray-200">';
                                        $html .= '<h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Chi tiết thanh toán</h4>';
                                        $html .= '</div>';

                                        $html .= '<div class="p-5 space-y-3">';

                                        // Subtotal
                                        $html .= '<div class="flex justify-between items-center py-2">';
                                        $html .= '<span class="text-sm text-gray-600 flex items-center gap-2">';
                                        $html .= '<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>';
                                        $html .= 'Tạm tính</span>';
                                        $html .= '<span class="font-semibold text-gray-900">' . number_format($record->subtotal ?? 0, 0, ',', '.') . ' ₫</span>';
                                        $html .= '</div>';

                                        // Coupon discount
                                        if ($record->coupon_code && $record->coupon_discount > 0) {
                                            $html .= '<div class="flex justify-between items-center py-2 bg-green-50 -mx-5 px-5">';
                                            $html .= '<span class="text-sm text-green-700 flex items-center gap-2 font-medium">';
                                            $html .= '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>';
                                            $html .= 'Giảm giá (' . htmlspecialchars($record->coupon_code) . ')';
                                            $html .= '</span>';
                                            $html .= '<span class="font-semibold text-green-700">-' . number_format($record->coupon_discount, 0, ',', '.') . ' ₫</span>';
                                            $html .= '</div>';
                                        }

                                        // Shipping
                                        if ($record->shipping_amount > 0) {
                                            $html .= '<div class="flex justify-between items-center py-2">';
                                            $html .= '<span class="text-sm text-gray-600 flex items-center gap-2">';
                                            $html .= '<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>';
                                            $html .= 'Phí vận chuyển</span>';
                                            $html .= '<span class="font-semibold text-gray-900">' . number_format($record->shipping_amount, 0, ',', '.') . ' ₫</span>';
                                            $html .= '</div>';
                                        }

                                        // Tax
                                        if ($record->tax_amount > 0) {
                                            $html .= '<div class="flex justify-between items-center py-2">';
                                            $html .= '<span class="text-sm text-gray-600 flex items-center gap-2">';
                                            $html .= '<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>';
                                            $html .= 'Thuế</span>';
                                            $html .= '<span class="font-semibold text-gray-900">' . number_format($record->tax_amount, 0, ',', '.') . ' ₫</span>';
                                            $html .= '</div>';
                                        }

                                        // Divider
                                        $html .= '<hr class="!my-4 border-gray-300 border-t-2">';

                                        // Total - Emphasized
                                        $html .= '<div class="flex justify-between items-center py-3 bg-gradient-to-r from-green-500 to-emerald-600 -mx-5 px-5 shadow-inner">';
                                        $html .= '<span class="text-base font-bold text-white flex items-center gap-2">';
                                        $html .= '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>';
                                        $html .= 'TỔNG THANH TOÁN</span>';
                                        $html .= '<span class="text-2xl font-bold text-white">' . number_format($record->total_amount ?? 0, 0, ',', '.') . ' ₫</span>';
                                        $html .= '</div>';

                                        $html .= '</div>'; // p-5
                                        $html .= '</div>'; // bg-white
                                        $html .= '</div>'; // space-y-4

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

                // Order Items Section - Enhanced Product Cards
                Section::make('Sản phẩm đã đặt')
                    ->description('Danh sách các sản phẩm trong đơn hàng')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Placeholder::make('order_items')
                            ->label('')
                            ->content(function ($record): HtmlString {
                                if (!$record || !$record->items || $record->items->count() === 0) {
                                    return new HtmlString('<div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-600">Không có sản phẩm nào trong đơn hàng</p>
                                        <p class="text-sm text-gray-400 mt-1">Đơn hàng này chưa có sản phẩm được đặt</p>
                                    </div>');
                                }

                                $html = '<div class="grid grid-cols-1 gap-4">';

                                foreach ($record->items as $index => $item) {
                                    $product = $item->product;
                                    $productName = $product ? $product->name : 'Sản phẩm đã bị xóa';
                                    $productSku = $product && $product->sku ? $product->sku : 'N/A';
                                    $total = $item->qty * $item->unit_price;

                                    // Enhanced Product Card with Gradient Border
                                    $html .= '<div class="relative group">';
                                    $html .= '<div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl opacity-0 group-hover:opacity-100 blur transition duration-300"></div>';
                                    $html .= '<div class="relative bg-white border-2 border-gray-200 rounded-2xl p-5 hover:border-transparent transition-all duration-300 shadow-sm hover:shadow-xl">';

                                    // Header with Product Info
                                    $html .= '<div class="flex items-start gap-4 mb-4">';

                                    // Stylish Number Badge
                                    $html .= '<div class="relative flex-shrink-0">';
                                    $html .= '<div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">';
                                    $html .= '<span class="text-white text-lg font-bold">' . ($index + 1) . '</span>';
                                    $html .= '</div>';
                                    $html .= '<div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>';
                                    $html .= '</div>';

                                    // Product Details
                                    $html .= '<div class="flex-1 min-w-0">';
                                    $html .= '<h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">' . htmlspecialchars($productName) . '</h4>';
                                    $html .= '<div class="flex items-center gap-2 flex-wrap">';
                                    $html .= '<span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700">';
                                    $html .= '<svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>';
                                    $html .= 'SKU: ' . htmlspecialchars($productSku);
                                    $html .= '</span>';

                                    // Size badge
                                    if ($item->size) {
                                        $html .= '<span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">';
                                        $html .= '<svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                                        $html .= 'Size: ' . htmlspecialchars($item->size);
                                        $html .= '</span>';
                                    }

                                    // Color badge
                                    if ($item->color) {
                                        $html .= '<span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-purple-100 text-purple-700">';
                                        $html .= '<svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/></svg>';
                                        $html .= 'Màu: ' . htmlspecialchars($item->color);
                                        $html .= '</span>';
                                    }

                                    $html .= '</div>';
                                    $html .= '</div>';

                                    // Total Price Badge (Large)
                                    $html .= '<div class="flex-shrink-0 text-right">';
                                    $html .= '<div class="inline-flex flex-col items-end gap-1">';
                                    $html .= '<span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</span>';
                                    $html .= '<div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-xl shadow-lg">';
                                    $html .= '<span class="text-2xl font-bold">' . number_format($total, 0, ',', '.') . '</span>';
                                    $html .= '<span class="text-sm ml-1">₫</span>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '</div>';

                                    $html .= '</div>'; // flex header

                                    // Divider
                                    $html .= '<div class="relative my-4">';
                                    $html .= '<div class="absolute inset-0 flex items-center"><div class="w-full border-t-2 border-gray-100"></div></div>';
                                    $html .= '<div class="relative flex justify-center"><span class="bg-white px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Chi tiết</span></div>';
                                    $html .= '</div>';

                                    // Product Stats Grid
                                    $html .= '<div class="grid grid-cols-3 gap-4">';

                                    // Quantity
                                    $html .= '<div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 text-center border border-blue-100">';
                                    $html .= '<div class="flex justify-center mb-2">';
                                    $html .= '<div style="width: 2rem; height: 2rem;" class="bg-blue-500 rounded-lg flex items-center justify-center">';
                                    $html .= '<svg style="width: 1rem; height: 1rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '<p class="text-xs text-blue-700 uppercase tracking-wider font-semibold mb-1">Số lượng</p>';
                                    $html .= '<p class="text-2xl font-bold text-blue-900">×' . $item->qty . '</p>';
                                    $html .= '</div>';

                                    // Unit Price
                                    $html .= '<div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 text-center border border-purple-100">';
                                    $html .= '<div class="flex justify-center mb-2">';
                                    $html .= '<div style="width: 2rem; height: 2rem;" class="bg-purple-500 rounded-lg flex items-center justify-center">';
                                    $html .= '<svg style="width: 1rem; height: 1rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '<p class="text-xs text-purple-700 uppercase tracking-wider font-semibold mb-1">Đơn giá</p>';
                                    $html .= '<p class="text-lg font-bold text-purple-900">' . number_format($item->unit_price, 0, ',', '.') . ' ₫</p>';
                                    $html .= '</div>';

                                    // Subtotal
                                    $html .= '<div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 text-center border border-green-100">';
                                    $html .= '<div class="flex justify-center mb-2">';
                                    $html .= '<div style="width: 2rem; height: 2rem;" class="bg-green-500 rounded-lg flex items-center justify-center">';
                                    $html .= '<svg style="width: 1rem; height: 1rem;" class="text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '<p class="text-xs text-green-700 uppercase tracking-wider font-semibold mb-1">Thành tiền</p>';
                                    $html .= '<p class="text-lg font-bold text-green-900">' . number_format($total, 0, ',', '.') . ' ₫</p>';
                                    $html .= '</div>';

                                    $html .= '</div>'; // grid
                                    $html .= '</div>'; // card content
                                    $html .= '</div>'; // gradient wrapper
                                }

                                $html .= '</div>'; // grid container

                                return new HtmlString($html);
                            }),
                    ])
                    ->columnSpan('full'),
            ])
            ->columns(1);
    }
}
