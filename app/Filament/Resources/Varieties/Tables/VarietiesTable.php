<?php

namespace App\Filament\Resources\Varieties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class VarietiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('crop.name')
                    ->label('Cultivo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Variedad')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                
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
