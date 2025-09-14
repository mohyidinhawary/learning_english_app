<?php

namespace App\Filament\Resources\Lessons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;


class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),


                TextColumn::make('title')
                    ->label('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('position')
                    ->label('position')
                    ->sortable(),

                IconColumn::make('status')
                    ->label('status')
                    ->boolean()
                    ->sortable(),


                     TextColumn::make('difficulty')
                    ->label('difficulty')
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
