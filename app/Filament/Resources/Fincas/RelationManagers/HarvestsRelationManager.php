<?php

namespace App\Filament\Resources\Fincas\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => 
                        $set('sale_price', (float) $state * (float) $get('price_per_kg'))
                    ),

                TextInput::make('price_per_kg')
                    ->label('Precio por Kilo (€/kg)')
                    ->numeric()
                    ->dehydrated(false) // No intenta guardarse en la tabla de la base de datos
                    ->live(onBlur: true)
                    ->afterStateHydrated(fn (TextInput $component, $record) => 
                        // Calcula el precio por kilo hacia atrás cuando editas un registro antiguo
                        $record && $record->quantity_kg > 0 
                            ? $component->state(round($record->sale_price / $record->quantity_kg, 2)) 
                            : null
                    )
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => 
                        $set('sale_price', (float) $get('quantity_kg') * (float) $state)
                    ),

                TextInput::make('sale_price')
                    ->label('Precio de Venta (Total €)')
                    ->numeric()
                    ->readOnly(), // Se rellena automáticamente con la multiplicación
                
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
                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('quantity_kg')
                    ->label('Kilos')
                    ->numeric()
                    ->suffix(' kg'),
                TextColumn::make('price_per_kg')
                    ->label('Precio/Kg')
                    ->money('EUR')
                    // Calcula el precio por kilo dinámicamente para mostrarlo en la tabla
                    ->state(fn ($record) => $record->quantity_kg > 0 ? $record->sale_price / $record->quantity_kg : 0),
                TextColumn::make('sale_price')
                    ->label('Total Venta')
                    ->money('EUR'),
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