<?php

namespace App\Filament\Resources\AffiliateLinks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AffiliateLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('CTV')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('user.affiliate_code')
                    ->label('Mã CTV')
                    ->searchable(),
                    
                TextColumn::make('product.name')
                    ->label('Sản phẩm')
                    ->searchable()
                    ->limit(30),
                    
                TextColumn::make('link_code')
                    ->label('Mã Link')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Đã copy mã link'),
                    
                TextColumn::make('clicks')
                    ->label('Lượt Click')
                    ->numeric()
                    ->sortable(),
                    
                TextColumn::make('conversions')
                    ->label('Chuyển Đổi')
                    ->numeric()
                    ->sortable(),
                    
                TextColumn::make('conversion_rate')
                    ->label('Tỷ Lệ (%)')
                    ->formatStateUsing(fn ($record): string => $record->conversion_rate . '%')
                    ->sortable(),
                    
                TextColumn::make('total_commission')
                    ->label('Tổng Hoa Hồng')
                    ->money('VND')
                    ->sortable(),
                    
                ToggleColumn::make('is_active')
                    ->label('Hoạt động'),
                    
                TextColumn::make('last_clicked_at')
                    ->label('Click Cuối')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Chưa có'),
                    
                TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label('CTV')
                    ->relationship('user', 'name', fn ($query) => $query->byRole('ctv'))
                    ->searchable()
                    ->preload(),
                    
                SelectFilter::make('is_active')
                    ->label('Trạng thái')
                    ->options([
                        1 => 'Hoạt động',
                        0 => 'Tạm dừng',
                    ]),
                    
                Filter::make('has_clicks')
                    ->label('Có lượt click')
                    ->query(fn (Builder $query): Builder => $query->where('clicks', '>', 0)),
                    
                Filter::make('has_conversions')
                    ->label('Có chuyển đổi')
                    ->query(fn (Builder $query): Builder => $query->where('conversions', '>', 0)),
                    
                Filter::make('created_at')
                    ->label('Ngày tạo')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Từ ngày'),
                        DatePicker::make('created_until')
                            ->label('Đến ngày'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                Action::make('copy_link')
                    ->label('Copy Link')
                    ->icon('heroicon-o-clipboard')
                    ->color('info')
                    ->url(fn ($record): string => $record->affiliate_url)
                    ->openUrlInNewTab(),
                    
                Action::make('view_product')
                    ->label('Xem SP')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record): string => route('product.show', $record->product->id))
                    ->openUrlInNewTab(),
                    
                EditAction::make()
                    ->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}