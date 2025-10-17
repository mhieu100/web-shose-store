<?php

namespace App\Filament\Resources\CollaboratorApplications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CollaboratorApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin người đăng ký')
                    ->schema([
                        Select::make('user_id')
                            ->label('Người dùng')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('full_name')
                            ->label('Họ và tên')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('id_card_number')
                            ->label('Số CMND/CCCD')
                            ->required()
                            ->maxLength(20),
                    ])->columns(2),

                Section::make('Thông tin ngân hàng')
                    ->schema([
                        TextInput::make('bank_name')
                            ->label('Tên ngân hàng')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('bank_account')
                            ->label('Số tài khoản')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('bank_account_name')
                            ->label('Tên chủ tài khoản')
                            ->required()
                            ->maxLength(255),
                    ])->columns(3),

                Section::make('Thông tin bổ sung')
                    ->schema([
                        Textarea::make('address')
                            ->label('Địa chỉ')
                            ->required()
                            ->rows(3),
                        Textarea::make('reason')
                            ->label('Lý do đăng ký')
                            ->rows(3),
                        Textarea::make('experience')
                            ->label('Kinh nghiệm')
                            ->rows(3),
                    ])->columns(1),

                Section::make('Trạng thái duyệt')
                    ->schema([
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Đang chờ duyệt',
                                'approved' => 'Đã duyệt',
                                'rejected' => 'Từ chối',
                            ])
                            ->default('pending')
                            ->required()
                            ->reactive(),
                        Textarea::make('admin_note')
                            ->label('Ghi chú của admin')
                            ->rows(2),
                        Select::make('approved_by')
                            ->label('Người duyệt')
                            ->relationship('approvedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (callable $get) => in_array($get('status'), ['approved', 'rejected'])),
                        DateTimePicker::make('approved_at')
                            ->label('Thời gian duyệt')
                            ->visible(fn (callable $get) => in_array($get('status'), ['approved', 'rejected'])),
                    ])->columns(1),
            ]);
    }
}
