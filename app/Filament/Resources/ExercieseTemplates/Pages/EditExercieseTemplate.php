<?php

namespace App\Filament\Resources\ExercieseTemplates\Pages;

use App\Filament\Resources\ExercieseTemplates\ExercieseTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExercieseTemplate extends EditRecord
{
    protected static string $resource = ExercieseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
