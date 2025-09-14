<?php

namespace App\Filament\Resources\WordSentences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
class WordSentencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 // ID
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                // الكلمة المرتبطة
                TextColumn::make('word.en_text')
                    ->label('word')
                    ->searchable()
                    ->sortable(),

                // الجملة بالإنكليزي
                TextColumn::make('en_sentence')
                    ->label('English Sentence')
                    ->limit(50)
                    ->searchable(),

                // الجملة بالعربي
                TextColumn::make('ar_sentence')
                    ->label('Arabic Sentence')
                    ->limit(50)
                    ->searchable(),

                // رابط الصوت
                TextColumn::make('audio_url')
                    ->label('audio')
                    ->url(fn ($record) => $record->audio_url ? asset('storage/'.$record->audio_url) : null, true)
                    ->openUrlInNewTab()

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
