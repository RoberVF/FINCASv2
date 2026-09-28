<?php

namespace App\Filament\Resources\Treatments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TreatmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fincas.name')
                    ->label('Fincas')
                    ->badge()
                    ->separator(','),
                TextColumn::make('date')->label('Fecha')->date()->sortable(),
                TextColumn::make('product')->label('Producto'),
                TextColumn::make('dose')->label('Dosis'),
                TextColumn::make('cost')->label('Coste')->money('EUR'),
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
