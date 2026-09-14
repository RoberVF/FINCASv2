<?php

namespace App\Filament\Resources\Fincas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class FincaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la Finca')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de la Finca')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('location')
                            ->label('Ubicación (opcional)')
                            ->maxLength(255),

                        TextInput::make('size_sqm')
                            ->label('Tamaño (Metros cuadrados)')
                            ->numeric()
                            ->suffix('m²'),
                    ])->columns(2),

                Section::make('Cultivo Principal')
                    ->schema([
                        Select::make('crop_id')
                            ->label('Tipo de Cultivo')
                            ->relationship('crop', 'name')
                            ->required()
                            ->live(), // Hace que el formulario reaccione al cambiar el valor

                        Select::make('variety_id')
                            ->label('Variedad')
                            ->options(
                                fn(\Filament\Schemas\Components\Utilities\Get $get): \Illuminate\Support\Collection =>
                                \App\Models\Variety::query()
                                    ->where('crop_id', $get('crop_id'))
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->disabled(fn(\Filament\Schemas\Components\Utilities\Get $get): bool => ! filled($get('crop_id'))),
                    ])->columns(2),
            ]);
    }
}
