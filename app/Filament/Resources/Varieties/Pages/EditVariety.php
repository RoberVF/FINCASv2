<?php

namespace App\Filament\Resources\Varieties\Pages;

use App\Filament\Resources\Varieties\VarietyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVariety extends EditRecord
{
    protected static string $resource = VarietyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
