<?php

namespace App\Filament\Widgets;

use App\Models\Finca;
use App\Models\Harvest;
use App\Models\Irrigation;
use App\Models\Treatment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $cropId = $this->filters['crop_id'] ?? null;
        $currentYear = now()->year;

        $fincasQuery = Finca::query();
        if ($cropId) {
            $fincasQuery->where('crop_id', $cropId);
        }
        $fincasIds = $fincasQuery->pluck('id');

        $ingresos = Harvest::whereIn('finca_id', $fincasIds)
            ->whereYear('date', $currentYear)
            ->sum('sale_price') ?? 0;

        $gastosRiego = Irrigation::whereHas('fincas', function ($query) use ($fincasIds) {
            $query->whereIn('fincas.id', $fincasIds);
        })
        ->whereYear('date', $currentYear)
        ->sum('cost') ?? 0;

        $gastosTratamiento = Treatment::whereHas('fincas', function ($query) use ($fincasIds) {
            $query->whereIn('fincas.id', $fincasIds);
        })
        ->whereYear('date', $currentYear)
        ->sum('cost') ?? 0;

        $gastosTotales = $gastosRiego + $gastosTratamiento;
        $beneficioNeto = $ingresos - $gastosTotales;

        return [
            Stat::make('Ingresos Totales (' . $currentYear . ')', number_format($ingresos, 2) . ' €')
                ->description('Ventas registradas en el año actual')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Gastos Totales (' . $currentYear . ')', number_format($gastosTotales, 2) . ' €')
                ->description('Riegos y Fitosanitarios del año actual')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Beneficio Neto (' . $currentYear . ')', number_format($beneficioNeto, 2) . ' €')
                ->description($beneficioNeto >= 0 ? 'Rentabilidad anual positiva' : 'Pérdidas acumuladas en el año')
                ->descriptionIcon($beneficioNeto >= 0 ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle')
                ->color($beneficioNeto >= 0 ? 'success' : 'danger'),
        ];
    }
}