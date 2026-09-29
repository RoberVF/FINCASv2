<?php

namespace App\Filament\Resources\Tanks\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\WaterMovementType;
use Filament\Schemas\Components\Utilities\Get;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';
    protected static ?string $title = 'Movimientos de Agua';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),
                
                Select::make('type')
                    ->label('Tipo de Movimiento')
                    ->required()
                    ->options([
                        WaterMovementType::COMPRA->value => WaterMovementType::COMPRA->getLabel(),
                        WaterMovementType::LLUVIA->value => WaterMovementType::LLUVIA->getLabel(),
                        WaterMovementType::OTROS->value => WaterMovementType::OTROS->getLabel(),
                        WaterMovementType::MERMA->value => WaterMovementType::MERMA->getLabel(),
                        // Omitimos RIEGO intencionadamente
                    ])
                    ->live(), // Hace que el formulario reaccione al cambio

                TextInput::make('quantity')
                    ->label('Cantidad (Pipas)')
                    ->numeric()
                    ->required()
                    ->helperText('Introduce el valor en positivo siempre. El sistema sabe si sumar o restar.'),

                // Solo se muestran si el tipo es COMPRA
                TextInput::make('price_per_pipa')
                    ->label('Precio por Pipa (€)')
                    ->numeric()
                    ->visible(fn (Get $get) => $get('type') === WaterMovementType::COMPRA->value),
                    
                TextInput::make('total_cost')
                    ->label('Coste Total (€)')
                    ->numeric()
                    ->visible(fn (Get $get) => $get('type') === WaterMovementType::COMPRA->value)
                    ->helperText('Puedes rellenar solo el precio unitario o solo el total, el sistema calcula el otro.'),

                Textarea::make('description')
                    ->label('Descripción / Notas')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('quantity')
            ->columns([
                TextColumn::make('date')->label('Fecha')->date()->sortable(),
                TextColumn::make('type')->label('Tipo')->badge(),
                TextColumn::make('quantity')->label('Pipas')->numeric(),
                TextColumn::make('total_cost')->label('Coste Total')->money('EUR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Registrar Movimiento'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }
}