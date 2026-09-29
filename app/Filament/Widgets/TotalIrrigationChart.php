<?php

namespace App\Filament\Widgets;

use App\Models\Finca;
use App\Models\Irrigation;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\View\View;

class TotalIrrigationChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Consumo Total de Riego por Año (Pipas)';
    protected static ?int $sort = 4;

    public function render(): View
    {
        if (empty($this->filters['crop_id'])) {
            return view('filament.widgets.hidden');
        }

        return parent::render();
    }

    protected function getData(): array
    {
        $cropId = $this->filters['crop_id'];
        $fincasIds = Finca::where('crop_id', $cropId)->pluck('id');

        $riegoPorAno = Irrigation::whereHas('fincas', function ($query) use ($fincasIds) {
            $query->whereIn('fincas.id', $fincasIds);
        })
        ->selectRaw('EXTRACT(YEAR FROM date) as ano, SUM(quantity) as total')
        ->groupByRaw('EXTRACT(YEAR FROM date)')
        ->orderBy('ano')
        ->pluck('total', 'ano')
        ->toArray();

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