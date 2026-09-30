<?php

namespace App\Filament\Pages;

use App\Models\Crop; // Cambia esto por tu modelo de cultivos/fincas si se llama distinto
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Barryvdh\DomPDF\Facade\Pdf;

class Informs extends Page
{
    // protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected string $view = 'filament.pages.informs';
    protected static string|\UnitEnum|null $navigationGroup = 'Otros';
    protected static ?string $title = 'Informes';
    protected static ?int $navigationSort = 60;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generar')
                ->label('Descargar Informe')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Configurar Informe PDF')
                ->modalSubmitActionLabel('Generar y Descargar')
                ->form([
                    Select::make('tipo')
                        ->label('Tipo de Informe')
                        ->options([
                            'general' => 'General (Producción y Agua)',
                            'produccion' => 'Solo Producción',
                            'agua' => 'Solo Consumo de Agua',
                        ])
                        ->required()
                        ->default('general'),

                    Select::make('finca_id')
                        ->label('Finca Específica')
                        ->options(\App\Models\Finca::pluck('name', 'id'))
                        ->nullable()
                        ->placeholder('Todas las fincas (Global)'),

                    DatePicker::make('fecha_inicio')
                        ->label('Desde fecha'),

                    DatePicker::make('fecha_fin')
                        ->label('Hasta fecha'),

                    Toggle::make('incluir_costes')
                        ->label('Incluir datos económicos (Costes e Ingresos)')
                        ->default(true),
                ])
                ->action(function (array $data) {
                    $riegos = collect();
                    $producciones = collect();

                    if (in_array($data['tipo'], ['general', 'agua'])) {
                        $queryRiegos = \App\Models\Irrigation::query()->with('tank');

                        if (!empty($data['fecha_inicio'])) {
                            $queryRiegos->whereDate('date', '>=', $data['fecha_inicio']);
                        }
                        if (!empty($data['fecha_fin'])) {
                            $queryRiegos->whereDate('date', '<=', $data['fecha_fin']);
                        }

                        $riegos = $queryRiegos->orderBy('date', 'desc')->get();
                    }

                    if (in_array($data['tipo'], ['general', 'produccion'])) {
                        $queryProd = \App\Models\Harvest::query()->with('finca');

                        if (!empty($data['fecha_inicio'])) {
                            $queryProd->whereDate('date', '>=', $data['fecha_inicio']);
                        }
                        if (!empty($data['fecha_fin'])) {
                            $queryProd->whereDate('date', '<=', $data['fecha_fin']);
                        }
                        if (!empty($data['finca_id'])) {
                            $queryProd->where('finca_id', $data['finca_id']);
                        }

                        $producciones = $queryProd->orderBy('date', 'desc')->get();
                    }

                    $pdf = Pdf::loadView('pdf.informe', [
                        'data' => $data,
                        'riegos' => $riegos,
                        'producciones' => $producciones,
                    ]);

                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        'informe-fincas-' . date('Y-m-d-H-i') . '.pdf'
                    );
                })
        ];
    }
}
