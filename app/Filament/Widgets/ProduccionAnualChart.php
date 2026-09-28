<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Harvest;
use App\Models\Finca;
use Carbon\Carbon;

class ProduccionAnualChart extends ChartWidget
{
    protected ?string $heading = 'Producción Total por Año (Kg)';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $fincasIds = Finca::pluck('id');
        
        $cosechas = Harvest::whereIn('finca_id', $fincasIds)->get();

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
                    'label' => 'Total Kilos',
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