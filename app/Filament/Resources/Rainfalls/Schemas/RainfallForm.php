<?php

namespace App\Filament\Resources\Rainfalls\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;

class RainfallForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('zone')
                    ->label('Zona')
                    ->required(),
                DatePicker::make('date')
                    ->label('Fecha')
                    ->required()
                    ->default(now()),
                TextInput::make('quantity_mm')
                    ->label('Cantidad (L/m²)')
                    ->numeric()
                    ->required(),
                Select::make('fincas')
                    ->label('Fincas afectadas (Opcional)')
                    ->relationship(
                        'fincas',
                        'name',
                        fn(Builder $query) =>
                        auth()->user()->is_admin ? $query : $query->where('user_id', auth()->id())
                    )
                    ->multiple()
                    ->preload(),
                Textarea::make('observations')
                    ->label('Observaciones')
                    ->columnSpanFull(),
            ]);
    }
}
