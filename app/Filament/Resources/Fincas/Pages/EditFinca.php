<?php

namespace App\Filament\Resources\Fincas\Pages;

use App\Filament\Resources\Fincas\FincaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Livewire\FincaHarvestsChart;

class EditFinca extends EditRecord
{
    protected static string $resource = FincaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FincaHarvestsChart::class,
        ];
    }
}
