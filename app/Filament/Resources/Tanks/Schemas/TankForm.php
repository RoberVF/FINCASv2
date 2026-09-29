<?php

namespace App\Filament\Resources\Tanks\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Hidden;

class TankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Tanque')
                    ->schema([
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        TextInput::make('name')
                            ->label('Nombre del Tanque')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('capacity')
                            ->label('Capacidad Máxima (Pipas)')
                            ->numeric()
                            ->required(),
                        TextInput::make('location')
                            ->label('Ubicación')
                            ->maxLength(255),
                        TextInput::make('material')
                            ->label('Material')
                            ->maxLength(255),
                        Toggle::make('is_roofed')
                            ->label('¿Está techado?')
                            ->default(false),
                        Textarea::make('notes')
                            ->label('Notas adicionales')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Estado Actual (Automático)')
                    ->schema([
                        TextInput::make('current_volume')
                            ->label('Volumen Actual (Pipas)')
                            ->numeric()
                            ->disabled() // Bloqueado, el usuario no puede escribir aquí
                            ->formatStateUsing(fn($state) => number_format((float)$state, 2)),
                        TextInput::make('current_average_price')
                            ->label('Precio Medio Ponderado (€/Pipa)')
                            ->numeric()
                            ->disabled()
                            ->formatStateUsing(fn($state) => number_format((float)$state, 4)),
                    ])->columns(2),
            ]);
    }
}
