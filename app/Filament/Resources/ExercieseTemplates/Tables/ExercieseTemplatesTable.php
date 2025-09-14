<?php

namespace App\Filament\Resources\ExercieseTemplates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;


class ExercieseTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ,

                TextColumn::make('lesson.title')
                    ->label('Lesson')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'primary' => 'mcq',
                        'success' => 'translate',
                        'info'    => 'order',
                        'warning' => 'listen',
                        'danger'  => 'speak',
                        'gray'    => 'match',
                        'secondary' => 'fill_blank',
                    ]),

                BadgeColumn::make('status')
                    ->label('status')
                    ->sortable()
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'active',
                        'danger'  => 'inactive',
                    ]),

                TextColumn::make('created_at')
                    ->label('Created')
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
