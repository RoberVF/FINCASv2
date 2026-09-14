<?php

namespace App\Filament\Resources\Fincas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class FincasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Finca')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('crop.name')
                    ->label('Cultivo')
                    ->sortable(),

                TextColumn::make('variety.name')
                    ->label('Variedad'),

                TextColumn::make('size_sqm')
                    ->label('Superficie')
                    ->numeric()
                    ->suffix(' m²')
                    ->sortable(),
            ])->filters([
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
