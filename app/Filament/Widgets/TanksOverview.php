<?php

namespace App\Filament\Widgets;

use App\Models\Tank;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TanksOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $totalVolume = Tank::sum('current_volume');
        $totalCapacity = Tank::sum('capacity');

        $porcentajeTotal = $totalCapacity > 0 ? ($totalVolume / $totalCapacity) * 100 : 0;

        return [
            Stat::make('Agua Total Disponible', number_format($totalVolume, 2) . ' Pipas')
                ->description('De un máximo de ' . number_format($totalCapacity, 2) . ' Pipas')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('info'),

            Stat::make('Nivel de Reservas Global', number_format($porcentajeTotal, 2) . '%')
                ->description($porcentajeTotal >= 50 ? 'Buenas reservas' : 'Niveles bajos')
                ->descriptionIcon($porcentajeTotal >= 50 ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle')
                ->color($porcentajeTotal >= 50 ? 'success' : 'warning'),
        ];
    }
}
