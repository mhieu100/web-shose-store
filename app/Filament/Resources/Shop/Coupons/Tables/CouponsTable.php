<?php

namespace App\Filament\Resources\Shop\Coupons\Tables;

use App\Enums\CouponType;
use App\Models\Shop\Coupon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Mã')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Đã sao chép mã!')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('type')
                    ->label('Loại')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Giá trị')
                    ->formatStateUsing(function ($record) {
                        return match ($record->type) {
                            CouponType::Percentage => $record->value . '%',
                            CouponType::FixedAmount => number_format($record->value, 0, ',', '.') . ' VNĐ',
                        };
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('minimum_amount')
                    ->label('Tối thiểu')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') . ' VNĐ' : '---')
                    ->sortable(),

                Tables\Columns\TextColumn::make('usage_stats')
                    ->label('Sử dụng')
                    ->formatStateUsing(function ($record) {
                        if (!$record->usage_limit) {
                            return $record->used_count . ' / ∞';
                        }
                        return $record->used_count . ' / ' . $record->usage_limit;
                    })
                    ->badge()
                    ->color(function ($record) {
                        if (!$record->usage_limit) return 'gray';

                        $percentage = ($record->used_count / $record->usage_limit) * 100;

                        if ($percentage >= 100) return 'danger';
                        if ($percentage >= 80) return 'warning';
                        if ($percentage >= 50) return 'info';

                        return 'success';
                    }),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Bắt đầu')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Ngay lập tức'),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Hết hạn')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Không giới hạn'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Trạng thái')
                    ->icon(function ($record) {
                        if (!$record->is_active) return 'heroicon-o-x-circle';
                        if ($record->is_expired) return 'heroicon-o-clock';
                        if ($record->is_not_started) return 'heroicon-o-pause';
                        if (!$record->isValid()) return 'heroicon-o-exclamation-triangle';

                        return 'heroicon-o-check-circle';
                    })
                    ->color(function ($record) {
                        if (!$record->is_active) return 'danger';
                        if ($record->is_expired) return 'danger';
                        if ($record->is_not_started) return 'warning';
                        if (!$record->isValid()) return 'danger';

                        return 'success';
                    })
                    ->tooltip(function ($record) {
                        if (!$record->is_active) return 'Không hoạt động';
                        if ($record->is_expired) return 'Đã hết hạn';
                        if ($record->is_not_started) return 'Chưa bắt đầu';
                        if (!$record->isValid()) return 'Không hợp lệ';

                        return 'Hoạt động';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tạo lúc')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Loại giảm giá')
                    ->options(CouponType::class),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái hoạt động')
                    ->placeholder('Tất cả')
                    ->trueLabel('Đang hoạt động')
                    ->falseLabel('Không hoạt động'),

                Tables\Filters\Filter::make('valid_now')
                    ->label('Hợp lệ hiện tại')
                    ->query(fn (Builder $query) => $query->valid())
                    ->toggle(),

                Tables\Filters\Filter::make('expired')
                    ->label('Đã hết hạn')
                    ->query(fn (Builder $query) => $query->whereNotNull('expires_at')->where('expires_at', '<', now()))
                    ->toggle(),

                Tables\Filters\Filter::make('not_started')
                    ->label('Chưa bắt đầu')
                    ->query(fn (Builder $query) => $query->whereNotNull('starts_at')->where('starts_at', '>', now()))
                    ->toggle(),

                Tables\Filters\Filter::make('usage_exhausted')
                    ->label('Đã hết lượt sử dụng')
                    ->query(fn (Builder $query) => $query->whereNotNull('usage_limit')->whereColumn('used_count', '>=', 'usage_limit'))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem'),
                EditAction::make()
                    ->label('Sửa'),
                Action::make('duplicate')
                    ->label('Nhân bản')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (Coupon $record) {
                        $newCoupon = $record->replicate();
                        $newCoupon->code = $record->code . '_COPY';
                        $newCoupon->used_count = 0;
                        $newCoupon->save();

                        // Copy product relationships
                        $newCoupon->products()->attach($record->products->pluck('id'));
                    })
                    ->successNotificationTitle('Đã nhân bản mã giảm giá'),
                DeleteAction::make()
                    ->label('Xóa')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận xóa mã giảm giá')
                    ->modalDescription('Bạn có chắc chắn muốn xóa mã giảm giá này? Hành động này không thể hoàn tác.')
                    ->modalSubmitActionLabel('Xóa')
                    ->modalCancelActionLabel('Hủy'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('activate')
                        ->label('Kích hoạt')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('Đã kích hoạt các mã giảm giá'),
                    BulkAction::make('deactivate')
                        ->label('Tắt kích hoạt')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('Đã tắt kích hoạt các mã giảm giá'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
