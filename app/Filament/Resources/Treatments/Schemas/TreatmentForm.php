<?php

namespace App\Filament\Resources\Treatments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class TreatmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                DatePicker::make('date')
                    ->label('Fecha')
                    ->required()
                    ->default(now()),
                TextInput::make('product')
                    ->label('Producto (Fitosanitario/Abono)')
                    ->required(),
                TextInput::make('dose')
                    ->label('Dosis (kg)'),
                TextInput::make('cost')
                    ->label('Coste (€)')
                    ->numeric()
                    ->default(0),
                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }
}
