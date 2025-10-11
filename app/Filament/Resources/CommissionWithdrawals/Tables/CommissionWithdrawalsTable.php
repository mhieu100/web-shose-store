<?php

namespace App\Filament\Resources\CommissionWithdrawals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommissionWithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('withdrawal_code')
                    ->label('Mã yêu cầu')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user.name')
                    ->label('CTV')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Số tiền yêu cầu')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('fee')
                    ->label('Phí')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('net_amount')
                    ->label('Thực nhận')
                    ->money('VND')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn ($record) => $record->status_label)
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'approved',
                        'primary' => 'processing',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ]),

                BadgeColumn::make('payment_method')
                    ->label('Phương thức')
                    ->formatStateUsing(fn ($record) => $record->payment_method_label)
                    ->colors([
                        'primary' => 'bank_transfer',
                        'success' => 'e_wallet',
                        'warning' => 'cash',
                    ]),

                TextColumn::make('requested_at')
                    ->label('Ngày yêu cầu')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('approved_at')
                    ->label('Ngày duyệt')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Chưa duyệt')
                    ->sortable(),

                TextColumn::make('completed_at')
                    ->label('Ngày hoàn thành')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Chưa hoàn thành')
                    ->sortable(),

                TextColumn::make('approvedBy.name')
                    ->label('Người duyệt')
                    ->placeholder('Chưa có')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ duyệt',
                        'approved' => 'Đã duyệt',
                        'processing' => 'Đang xử lý',
                        'completed' => 'Hoàn thành',
                        'rejected' => 'Từ chối',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Phương thức thanh toán')
                    ->options([
                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                        'e_wallet' => 'Ví điện tử',
                        'cash' => 'Tiền mặt',
                    ]),

                SelectFilter::make('user')
                    ->label('CTV')
                    ->relationship('user', 'name', fn ($query) => $query->byRole('ctv'))
                    ->searchable()
                    ->preload(),

                Filter::make('requested_at')
                    ->label('Ngày yêu cầu')
                    ->form([
                        DatePicker::make('requested_from')
                            ->label('Từ ngày'),
                        DatePicker::make('requested_until')
                            ->label('Đến ngày'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['requested_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('requested_at', '>=', $date),
                            )
                            ->when(
                                $data['requested_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('requested_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ])
            ->defaultSort('requested_at', 'desc');
    }
}
