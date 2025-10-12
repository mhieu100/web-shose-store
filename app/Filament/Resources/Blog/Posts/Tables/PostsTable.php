<?php

namespace App\Filament\Resources\Blog\Posts\Tables;

use App\Models\Blog\Post;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->label('Hình ảnh')
                    ->collection('post-images')
                    ->conversion('thumb'),

                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Đường dẫn')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('author.name')
                    ->label('Tác giả')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->getStateUsing(fn (Post $record): string => $record->published_at?->isPast() ? 'Đã xuất bản' : 'Bản nháp')
                    ->colors([
                        'success' => 'Đã xuất bản',
                    ]),

                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('published_at')
                    ->label('Ngày xuất bản')
                    ->date(),
            ])
            ->filters([
                Filter::make('published_at')
                    ->schema([
                        DatePicker::make('published_from')
                            ->placeholder(fn ($state): string => '18 Th12, ' . now()->subYear()->format('Y')),
                        DatePicker::make('published_until')
                            ->placeholder(fn ($state): string => now()->format('d/m/Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators['published_from'] = 'Xuất bản từ ' . Carbon::parse($data['published_from'])->toFormattedDateString();
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators['published_until'] = 'Xuất bản đến ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),

                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->action(function (): void {
                        Notification::make()
                            ->title('Này, này, đừng tinh nghịch, để lại một số bản ghi cho người khác chơi với!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}
