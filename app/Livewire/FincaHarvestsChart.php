<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use App\Models\Harvest;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FincaHarvestsChart extends ChartWidget
{
    protected ?string $heading = 'Histórico de Producción (Kg)';
    
    public ?Model $record = null;

    protected function getData(): array
    {
        $cosechas = Harvest::where('finca_id', $this->record->id)->get();

        $produccionPorAno = [];

        foreach ($cosechas as $cosecha) {
            $ano = Carbon::parse($cosecha->date)->year;
            
            if (!isset($produccionPorAno[$ano])) {
                $produccionPorAno[$ano] = 0;
            }
            
            $produccionPorAno[$ano] += $cosecha->quantity_kg;
        }

        ksort($produccionPorAno);

        return [
            'datasets' => [
                [
                    'label' => 'Kilos Producidos',
                    'data' => array_values($produccionPorAno),
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => array_keys($produccionPorAno),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}