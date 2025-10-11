<?php

namespace App\Filament\Resources\Commissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('CTV')
                    ->relationship('user', 'name', fn ($query) => $query->byRole('ctv'))
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Select::make('order_id')
                    ->label('Đơn hàng')
                    ->relationship('order', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Select::make('product_id')
                    ->label('Sản phẩm')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
                    
                TextInput::make('order_amount')
                    ->label('Giá trị đơn hàng')
                    ->required()
                    ->numeric()
                    ->prefix('₫')
                    ->step(1000),
                    
                TextInput::make('commission_rate')
                    ->label('Tỷ lệ hoa hồng (%)')
                    ->required()
                    ->numeric()
                    ->suffix('%')
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(100),
                    
                TextInput::make('commission_amount')
                    ->label('Số tiền hoa hồng')
                    ->required()
                    ->numeric()
                    ->prefix('₫')
                    ->step(1000),
                    
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ duyệt',
                        'approved' => 'Đã duyệt', 
                        'paid' => 'Đã thanh toán',
                        'cancelled' => 'Đã hủy'
                    ])
                    ->default('pending')
                    ->required(),
                    
                Textarea::make('notes')
                    ->label('Ghi chú')
                    ->rows(3)
                    ->columnSpanFull(),
                    
                DateTimePicker::make('approved_at')
                    ->label('Ngày duyệt'),
                    
                DateTimePicker::make('paid_at')
                    ->label('Ngày thanh toán'),
            ]);
    }
}
