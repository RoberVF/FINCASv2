<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use App\Models\Crop; 

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('crop_id')
                    ->label('Filtrar por Cultivo')
                    ->options(Crop::pluck('name', 'id'))
                    ->placeholder('Global (Todos los cultivos)')
                    ->native(false)
                    ->selectablePlaceholder(true),
            ])
            ->columns(3);
    }
}