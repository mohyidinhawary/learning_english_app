<?php

namespace App\Filament\Resources\Chapters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;


class ChaptersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),


                     TextColumn::make('level_id')
                    ->label('level_id')
                    ->sortable(),


                TextColumn::make('title')
                    ->label('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('position')
                    ->label('position')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()


            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
