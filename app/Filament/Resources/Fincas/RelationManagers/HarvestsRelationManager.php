<?php

namespace App\Filament\Resources\Fincas\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class HarvestsRelationManager extends RelationManager
{
    protected static string $relationship = 'harvests';

    protected static ?string $title = 'Cosechas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Fecha de Recolección')
                    ->required()
                    ->default(now()),
                TextInput::make('quantity_kg')
                    ->label('Cantidad (Kg)')
                    ->required()
                    ->numeric(),
                TextInput::make('sale_price')
                    ->label('Precio de Venta (Total €)')
                    ->numeric(),
                Textarea::make('observations')
                    ->label('Observaciones (Ej: cajas de 16kg, días de trabajo...)')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')->label('Fecha')->date()->sortable(),
                TextColumn::make('quantity_kg')->label('Kilos')->numeric()->suffix(' kg'),
                TextColumn::make('sale_price')->label('Venta')->money('EUR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
