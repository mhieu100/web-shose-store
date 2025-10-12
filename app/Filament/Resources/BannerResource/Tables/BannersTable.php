<?php

namespace App\Filament\Resources\BannerResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Hình ảnh')
                    ->size(80)
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 100) {
                            return null;
                        }
                        return $state;
                    }),

                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Ngày bắt đầu')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Không giới hạn'),

                TextColumn::make('end_date')
                    ->label('Ngày kết thúc')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Không giới hạn'),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Trạng thái hiển thị')
                    ->options([
                        1 => 'Hiển thị',
                        0 => 'Ẩn',
                    ])
                    ->placeholder('Tất cả'),

                Filter::make('active_period')
                    ->label('Đang trong thời gian hiệu lực')
                    ->query(fn (Builder $query): Builder => $query->inDateRange()),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->emptyStateHeading('Chưa có banner nào')
            ->emptyStateDescription('Tạo banner đầu tiên để hiển thị trên trang chủ.')
            ->emptyStateIcon('heroicon-o-photo');
    }
}
