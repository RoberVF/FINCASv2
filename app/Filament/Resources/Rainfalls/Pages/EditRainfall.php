<?php

namespace App\Filament\Resources\Rainfalls\Pages;

use App\Filament\Resources\Rainfalls\RainfallResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRainfall extends EditRecord
{
    protected static string $resource = RainfallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
