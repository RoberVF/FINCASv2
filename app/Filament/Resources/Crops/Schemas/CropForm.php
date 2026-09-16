<?php

namespace App\Filament\Resources\Crops\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class CropForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del Cultivo')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->label('Descripción')
                    ->maxLength(255),
            ]);
    }
}
