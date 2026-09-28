<?php

namespace App\Filament\Resources\Irrigations\Pages;

use App\Filament\Resources\Irrigations\IrrigationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIrrigation extends EditRecord
{
    protected static string $resource = IrrigationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
