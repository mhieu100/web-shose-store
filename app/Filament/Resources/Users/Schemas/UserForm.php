<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Họ và tên')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nhập họ và tên đầy đủ'),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(\App\Models\User::class, 'email', ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('example@gmail.com'),

                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('0123456789'),

                        Select::make('role_id')
                            ->label('Vai trò')
                            ->options(\App\Models\Role::active()->ordered()->pluck('label', 'id'))
                            ->required()
                            ->native(false)
                            ->placeholder('Chọn vai trò')
                            ->searchable(),

                        Textarea::make('address')
                            ->label('Địa chỉ')
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('Nhập địa chỉ đầy đủ...')
                            ->columnSpan('full'),

                        TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(6)
                            ->placeholder('Nhập mật khẩu (tối thiểu 6 ký tự)'),

                        TextInput::make('password_confirmation')
                            ->label('Xác nhận mật khẩu')
                            ->password()
                            ->same('password')
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(false)
                            ->placeholder('Nhập lại mật khẩu để xác nhận')
                            ->visibleOn('create'),

                        Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true)
                            ->columnSpan('full'),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 3]),
            ])
            ->columns(3);
    }
}
