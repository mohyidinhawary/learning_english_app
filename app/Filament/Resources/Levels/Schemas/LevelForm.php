<?php

namespace App\Filament\Resources\Levels\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class LevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               TextInput::make('title'),
               TextInput::make('position')
                ->label('position')
                ->numeric(),

               Toggle::make('is_active')
              ->label('active')
              ->default(true)
            ]);
    }
}
