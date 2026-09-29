<?php

namespace App\Filament\Widgets;

use App\Models\Finca;
use App\Models\Harvest;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\View\View;

class ProduccionAnualChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Producción Total por Año (Kg)';
    protected static ?int $sort = 3;

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
        
        $produccionPorAno = Harvest::whereIn('finca_id', $fincasIds)
            ->selectRaw('EXTRACT(YEAR FROM date) as ano, SUM(quantity_kg) as total')
            ->groupByRaw('EXTRACT(YEAR FROM date)')
            ->orderBy('ano')
            ->pluck('total', 'ano')
            ->toArray();

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