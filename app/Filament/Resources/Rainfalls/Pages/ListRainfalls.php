<?php

namespace App\Filament\Resources\Rainfalls\Pages;

use App\Filament\Resources\Rainfalls\RainfallResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRainfalls extends ListRecords
{
    protected static string $resource = RainfallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
