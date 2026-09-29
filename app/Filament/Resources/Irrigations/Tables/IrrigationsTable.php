<?php

namespace App\Filament\Resources\Irrigations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class IrrigationsTable
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
                TextColumn::make('quantity')->label('Cantidad')->numeric()
                    ->suffix(' Litros'),
                TextColumn::make('cost')->label('Coste')->money('EUR'),
            ])
            ->defaultSort('date', 'desc')
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
