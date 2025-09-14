<?php

namespace App\Filament\Resources\WordSentences\Pages;

use App\Filament\Resources\WordSentences\WordSentenceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWordSentence extends EditRecord
{
    protected static string $resource = WordSentenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
