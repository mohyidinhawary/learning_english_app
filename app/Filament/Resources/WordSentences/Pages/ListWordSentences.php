<?php

namespace App\Filament\Resources\WordSentences\Pages;

use App\Filament\Resources\WordSentences\WordSentenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWordSentences extends ListRecords
{
    protected static string $resource = WordSentenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
