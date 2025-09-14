<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('chapter_id')
                ->label('chapter')
                ->relationship('chapter', 'title'),
                TextInput::make('title'),

               TextInput::make('position')
                ->label('position')
                ->numeric(),
        //   Toggle::make('is_free')
        //       ->label('free')
        //       ->default(false),


               Toggle::make('status')
              ->label('status')
              ->default(true),

               Select::make('difficulty')
                ->label('difficulty')->options([
                    'easy'   => 'Easy',
                    'medium' => 'Medium',
                    'hard'   => 'Hard',
                ]),
                Toggle::make('is_free')
              ->label('free')
              ->default(false),

            ]);
    }
}
