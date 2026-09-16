<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Harvest;
use App\Models\Finca;
use Carbon\Carbon;

class IngresosChart extends ChartWidget
{
    protected ?string $heading = 'Ingresos Mensuales (Año actual)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $fincasIds = Finca::pluck('id');
        
        $cosechas = Harvest::whereIn('finca_id', $fincasIds)
            ->whereYear('date', Carbon::now()->year)
            ->get();

        $datosMensuales = array_fill(1, 12, 0);

        foreach ($cosechas as $cosecha) {
            $mes = Carbon::parse($cosecha->date)->month;
            $datosMensuales[$mes] += $cosecha->sale_price;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos (€)',
                    'data' => array_values($datosMensuales),
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}