<?php

namespace App\Filament\Resources\Chapters\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
class ChapterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('level_id')
                ->label('level')
                ->relationship('level', 'title'),
                TextInput::make('title'),
                  TextInput::make('subtitle'),
               TextInput::make('position')
                ->label('position')
                ->numeric(),

               Toggle::make('is_active')
              ->label('active')
              ->default(true)
            ]);



    }
}
