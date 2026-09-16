<?php

namespace App\Filament\Resources\Varieties\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class VarietyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('crop_id')
                    ->relationship('crop', 'name')
                    ->label('Cultivo al que pertenece')
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre de la Variedad')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->label('Descripción')
                    ->maxLength(255),
            ]);
    }
}
