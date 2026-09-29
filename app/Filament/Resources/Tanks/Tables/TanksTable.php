<?php

namespace App\Filament\Resources\Tanks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TanksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre')->searchable(),
                TextColumn::make('current_volume')
                    ->label('Cantidad Actual (Pipas)')
                    ->badge()
                    ->color(fn($state): string => $state < 0 ? 'danger' : 'success')
                    ->sortable(),
                TextColumn::make('current_average_price')
                    ->label('PMP (€/Pipa)')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('capacity')->label('Capacidad')->numeric(),
                IconColumn::make('is_roofed')->label('Techado')->boolean(),
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
