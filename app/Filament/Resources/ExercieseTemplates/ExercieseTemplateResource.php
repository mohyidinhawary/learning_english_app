<?php

namespace App\Filament\Resources\ExercieseTemplates;

use App\Filament\Resources\ExercieseTemplates\Pages\CreateExercieseTemplate;
use App\Filament\Resources\ExercieseTemplates\Pages\EditExercieseTemplate;
use App\Filament\Resources\ExercieseTemplates\Pages\ListExercieseTemplates;
use App\Filament\Resources\ExercieseTemplates\Schemas\ExercieseTemplateForm;
use App\Filament\Resources\ExercieseTemplates\Tables\ExercieseTemplatesTable;
use App\Models\ExercieseTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExercieseTemplateResource extends Resource
{
    protected static ?string $model = ExercieseTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'exercies';

    public static function form(Schema $schema): Schema
    {
        return ExercieseTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExercieseTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExercieseTemplates::route('/'),
            'create' => CreateExercieseTemplate::route('/create'),
            'edit' => EditExercieseTemplate::route('/{record}/edit'),
        ];
    }
}
