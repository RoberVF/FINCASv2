<?php

namespace App\Filament\Resources\Varieties\Pages;

use App\Filament\Resources\Varieties\VarietyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVarieties extends ListRecords
{
    protected static string $resource = VarietyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
