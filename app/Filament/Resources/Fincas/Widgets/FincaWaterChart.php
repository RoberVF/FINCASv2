<?php

namespace App\Filament\Resources\Fincas\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FincaWaterChart extends ChartWidget
{
    protected ?string $heading = 'Aporte de Agua por Año';

    public ?Model $record = null;

    protected function getData(): array
    {
        $anos = [];
        $riegoData = [];
        $lluviaData = [];

        foreach ($this->record->irrigations as $riego) {
            $ano = Carbon::parse($riego->date)->year;
            if (!isset($riegoData[$ano])) $riegoData[$ano] = 0;

            $cantidadFincasRegadas = $riego->fincas()->count();

            $pipasReales = $cantidadFincasRegadas > 0 ? ($riego->quantity / $cantidadFincasRegadas) : $riego->quantity;

            $riegoData[$ano] += round($pipasReales, 2);
            $anos[$ano] = true;
        }

        foreach ($this->record->rainfalls as $lluvia) {
            $ano = Carbon::parse($lluvia->date)->year;
            if (!isset($lluviaData[$ano])) $lluviaData[$ano] = 0;

            $lluviaData[$ano] += $lluvia->quantity_mm;
            $anos[$ano] = true;
        }

        ksort($anos);
        $labels = array_keys($anos);

        $riegoFinal = [];
        $lluviaFinal = [];

        foreach ($labels as $ano) {
            $riegoFinal[] = $riegoData[$ano] ?? 0;
            $lluviaFinal[] = $lluviaData[$ano] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Riego (Pipas estimadas)',
                    'data' => $riegoFinal,
                    'backgroundColor' => '#0ea5e9',
                ],
                [
                    'label' => 'Lluvia (mm o L/m²)',
                    'data' => $lluviaFinal,
                    'backgroundColor' => '#94a3b8',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
