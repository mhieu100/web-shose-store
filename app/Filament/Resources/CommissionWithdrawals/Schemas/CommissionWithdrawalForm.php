<?php

namespace App\Filament\Resources\CommissionWithdrawals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class CommissionWithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin yêu cầu')
                    ->schema([
                        TextInput::make('withdrawal_code')
                            ->label('Mã yêu cầu')
                            ->default(fn () => \App\Models\CommissionWithdrawal::generateWithdrawalCode())
                            ->disabled()
                            ->dehydrated(),
                            
                        Select::make('user_id')
                            ->label('CTV')
                            ->relationship('user', 'name', fn ($query) => $query->byRole('ctv'))
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        TextInput::make('amount')
                            ->label('Số tiền yêu cầu')
                            ->required()
                            ->numeric()
                            ->prefix('₫')
                            ->step(1)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $fee = $get('fee') ?? 0;
                                $set('net_amount', $state - $fee);
                            }),
                            
                        TextInput::make('fee')
                            ->label('Phí giao dịch')
                            ->numeric()
                            ->prefix('₫')
                            ->step(1)
                            ->minValue(0)
                            ->default(0)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $amount = $get('amount') ?? 0;
                                $set('net_amount', $amount - $state);
                            }),
                            
                        TextInput::make('net_amount')
                            ->label('Số tiền thực nhận')
                            ->numeric()
                            ->prefix('₫')
                            ->step(1)
                            ->minValue(0)
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Section::make('Phương thức thanh toán')
                    ->schema([
                        Select::make('payment_method')
                            ->label('Phương thức')
                            ->options([
                                'bank_transfer' => 'Chuyển khoản ngân hàng',
                                'e_wallet' => 'Ví điện tử',
                                'cash' => 'Tiền mặt'
                            ])
                            ->default('bank_transfer')
                            ->required(),
                            
                        Textarea::make('payment_info')
                            ->label('Thông tin thanh toán')
                            ->helperText('Nhập thông tin tài khoản, số thẻ, địa chỉ ví...')
                            ->rows(3)
                            ->required(),
                    ])
                    ->columns(1),

                Section::make('Trạng thái và ghi chú')
                    ->schema([
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Chờ duyệt',
                                'approved' => 'Đã duyệt',
                                'processing' => 'Đang xử lý',
                                'completed' => 'Hoàn thành',
                                'rejected' => 'Từ chối',
                            ])
                            ->default('pending')
                            ->required(),
                            
                        Select::make('approved_by')
                            ->label('Người duyệt')
                            ->relationship('approvedBy', 'name', fn ($query) => $query->byRole('admin'))
                            ->searchable()
                            ->preload(),
                            
                        Textarea::make('reason')
                            ->label('Lý do yêu cầu')
                            ->rows(2)
                            ->columnSpanFull(),
                            
                        Textarea::make('admin_notes')
                            ->label('Ghi chú admin')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Thời gian')
                    ->schema([
                        DateTimePicker::make('requested_at')
                            ->label('Ngày yêu cầu')
                            ->default(now())
                            ->required(),
                            
                        DateTimePicker::make('approved_at')
                            ->label('Ngày duyệt'),
                            
                        DateTimePicker::make('completed_at')
                            ->label('Ngày hoàn thành'),
                    ])
                    ->columns(3),
            ]);
    }
}
