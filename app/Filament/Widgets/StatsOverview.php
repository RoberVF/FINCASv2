<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Finca;
use App\Models\Harvest;
use App\Models\Treatment;
use App\Models\Irrigation;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $fincasIds = Finca::pluck('id');

        $ingresos = Harvest::whereIn('finca_id', $fincasIds)->sum('sale_price') ?? 0;
        $gastosRiego = Irrigation::whereIn('finca_id', $fincasIds)->sum('cost') ?? 0;
        $gastosTratamiento = Treatment::whereIn('finca_id', $fincasIds)->sum('cost') ?? 0;
        
        $gastosTotales = $gastosRiego + $gastosTratamiento;
        $beneficioNeto = $ingresos - $gastosTotales;

        return [
            Stat::make('Ingresos Totales', number_format($ingresos, 2) . ' €')
                ->description('Suma de todas las ventas registradas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Gastos Totales', number_format($gastosTotales, 2) . ' €')
                ->description('Riegos y Fitosanitarios/Abonos')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
                
            Stat::make('Beneficio Neto', number_format($beneficioNeto, 2) . ' €')
                ->description($beneficioNeto >= 0 ? 'Rentabilidad positiva' : 'Pérdidas acumuladas')
                ->descriptionIcon($beneficioNeto >= 0 ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle')
                ->color($beneficioNeto >= 0 ? 'success' : 'danger'),
        ];
    }
}