<?php

namespace App\Filament\Resources\Words\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class WordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               // معرف الكلمة
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                // الدرس المرتبط
                TextColumn::make('lesson.title')
                    ->label('lesson')
                    ->sortable()
                    ->searchable(),

                // النص الإنكليزي
                TextColumn::make('en_text')
                    ->label('English')
                    ->sortable()
                    ->searchable(),

                // النص العربي
                TextColumn::make('ar_text')
                    ->label('Arabic')
                    ->sortable()
                    ->searchable(),

                // صورة Preview
                ImageColumn::make('image_url')
                    ->label('image')
                    ->square(),

                // رابط الصوت
                TextColumn::make('audio_url')
                    ->label('audio')
                    ->url(fn ($record) => $record->audio_url ? asset('storage/'.$record->audio_url) : null, true)
                    ->openUrlInNewTab()
,

                // الصعوبة
                BadgeColumn::make('difficulty')
                    ->label('difficulty')
                    ->colors([
                        'success' => 'easy',
                        'warning' => 'medium',
                        'danger'  => 'hard',
                    ])
                    ->sortable(),

                // الحالة
                IconColumn::make('is_active')
                    ->label('active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
