<?php

namespace App\Filament\Resources\Rainfalls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class RainfallsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('zone')
                    ->label('Zona')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity_mm')
                    ->label('Cantidad')
                    ->numeric()
                    ->suffix(' L/m²'),
                TextColumn::make('fincas.name')
                    ->label('Fincas')
                    ->badge()
                    ->separator(','),
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
