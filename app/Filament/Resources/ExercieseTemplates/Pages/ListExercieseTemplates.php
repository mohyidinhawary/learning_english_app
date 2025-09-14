<?php

namespace App\Filament\Resources\ExercieseTemplates\Pages;

use App\Filament\Resources\ExercieseTemplates\ExercieseTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExercieseTemplates extends ListRecords
{
    protected static string $resource = ExercieseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
