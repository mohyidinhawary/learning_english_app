<?php

namespace App\Filament\Resources\WordSentences;

use App\Filament\Resources\WordSentences\Pages\CreateWordSentence;
use App\Filament\Resources\WordSentences\Pages\EditWordSentence;
use App\Filament\Resources\WordSentences\Pages\ListWordSentences;
use App\Filament\Resources\WordSentences\Schemas\WordSentenceForm;
use App\Filament\Resources\WordSentences\Tables\WordSentencesTable;
use App\Models\WordSentence;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WordSentenceResource extends Resource
{
    protected static ?string $model = WordSentence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'WordSentence';

    public static function form(Schema $schema): Schema
    {
        return WordSentenceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WordSentencesTable::configure($table);
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
            'index' => ListWordSentences::route('/'),
            'create' => CreateWordSentence::route('/create'),
            'edit' => EditWordSentence::route('/{record}/edit'),
        ];
    }
}
