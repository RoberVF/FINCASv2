<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Irrigation;
use Carbon\Carbon;

class TotalIrrigationChart extends ChartWidget
{
    protected ?string $heading = 'Consumo Total de Riego por Año (Pipas)';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $riegos = Irrigation::all();
        $riegoPorAno = [];

        foreach ($riegos as $riego) {
            $ano = Carbon::parse($riego->date)->year;
            
            if (!isset($riegoPorAno[$ano])) {
                $riegoPorAno[$ano] = 0;
            }
            
            $riegoPorAno[$ano] += $riego->quantity;
        }

        ksort($riegoPorAno);

        return [
            'datasets' => [
                [
                    'label' => 'Total Pipas',
                    'data' => array_values($riegoPorAno),
                    'backgroundColor' => '#0ea5e9',
                ],
            ],
            'labels' => array_keys($riegoPorAno),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}