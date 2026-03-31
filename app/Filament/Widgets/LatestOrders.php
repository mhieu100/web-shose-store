<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Shop\Orders\OrderResource;
use App\Models\Shop\Order;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Squire\Models\Currency;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Đơn hàng gần đây';

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery()->with('customer'))
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Ngày đặt hàng')
                    ->date()
                    ->sortable(),
                TextColumn::make('number')
                    ->label('Số đơn hàng')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('currency')
                    ->label('Tiền tệ')
                    ->getStateUsing(function ($record): ?string {
                        static $currencyNames = null;

                        if ($currencyNames === null) {
                            $currencyNames = Currency::query()->pluck('name', 'id')->all();
                        }

                        return $currencyNames[$record->currency] ?? null;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Tổng tiền')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shipping_price')
                    ->label('Phí vận chuyển')
                    ->searchable()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Mở')
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
