<?php

namespace App\Filament\Resources\Irrigations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

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
                TextInput::make('quantity')
                    ->label('Cantidad (Pipas)')
                    ->numeric(),
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
