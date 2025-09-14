<?php

namespace App\Filament\Resources\Words\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
class WordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 // الربط مع الدرس
                Select::make('lesson_id')
                    ->label('lesson')
                    ->relationship('lesson', 'title')
                    ->required(),

                // الكلمة بالإنكليزي
                TextInput::make('en_text')
                    ->label('en_text')
                    ->required()
                    ->maxLength(255),

                // الترجمة بالعربي
                TextInput::make('ar_text')
                    ->label('ar_text')
                    ->required()
                    ->maxLength(255),

                // صورة الكلمة
                FileUpload::make('image_url')
                    ->label('image')
                    ->image()
                    ->directory('words/images')
                    ->nullable(),

                // الصوت
                FileUpload::make('audio_url')
                    ->label('audio')
                    ->acceptedFileTypes(['audio/*'])
                    ->directory('words/audio')
                    ->nullable(),

                // مستوى الصعوبة
                Select::make('difficulty')
                    ->label('difficulty')
                    ->options([
                        'easy'   => 'easy',
                        'medium' => 'medium',
                        'hard'   => 'hard',
                    ])
                    ->nullable(),

                // الحالة (مفعل/غير مفعل)
                Toggle::make('is_active')
                    ->label('active')
                    ->default(true),
            ]);
    }
}
