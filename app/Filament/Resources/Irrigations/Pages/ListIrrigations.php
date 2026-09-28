<?php

namespace App\Filament\Resources\Irrigations\Pages;

use App\Filament\Resources\Irrigations\IrrigationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIrrigations extends ListRecords
{
    protected static string $resource = IrrigationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
