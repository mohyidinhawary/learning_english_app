<?php

namespace App\Filament\Resources\WordSentences\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class WordSentenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // الكلمة المرتبطة
                Select::make('word_id')
                    ->label('word')
                    ->relationship('word', 'en_text')
                    ->required(),

                // الجملة بالإنكليزي
                Textarea::make('en_sentence')
                    ->label('en_sentence')
                    ->rows(2)
                    ->required(),

                // الترجمة بالعربية
                Textarea::make('ar_sentence')
                    ->label('ar_sentence')
                    ->rows(2)
                    ->required(),

                // ملف الصوت
                FileUpload::make('audio_url')
                    ->label('audio')
                    ->acceptedFileTypes(['audio/*'])
                    ->directory('sentences/audio')
                    ->nullable(),
            ]);
    }
}
