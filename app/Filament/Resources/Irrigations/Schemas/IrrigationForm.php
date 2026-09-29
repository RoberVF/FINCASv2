<?php

namespace App\Filament\Resources\Irrigations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Utilities\Get;

class IrrigationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Fecha')
                    ->required()
                    ->default(now()),
                Select::make('fincas')
                    ->label('Fincas afectadas')
                    ->relationship(
                        'fincas',
                        'name',
                        fn(Builder $query) =>
                        auth()->user()->is_admin ? $query : $query->where('user_id', auth()->id())
                    )
                    ->multiple()
                    ->preload()
                    ->required(),
                Select::make('tank_id')
                    ->label('Tanque Origen')
                    ->relationship('tank', 'name')
                    ->nullable()
                    ->live()
                    ->helperText('Déjalo en blanco si es agua externa (Cuba).'),
                TextInput::make('cost')
                    ->label('Coste del Riego (€)')
                    ->numeric()
                    ->disabled(fn(Get $get) => filled($get('tank_id')))
                    ->dehydrated()
                    ->helperText(fn(Get $get) => filled($get('tank_id'))
                        ? 'El coste se calculará automáticamente usando el Precio Medio del tanque.'
                        : 'Introduce el coste de la cuba manual.'),
                TextInput::make('quantity')
                    ->label('Cantidad (Pipas)')
                    ->numeric(),
                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }
}
