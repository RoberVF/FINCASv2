<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Informe Agrícola</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }

        .header {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            color: #4CAF50;
            margin: 0;
            padding: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="text-align: left;">
                    <h1 class="title">Informe Agrícola</h1>
                    <p style="margin-top: 5px; color: #666;">Fecha de generación: {{ date('d/m/Y') }}</p>
                </td>
                <td style="text-align: right;">
                    <img src="{{ public_path('logo.png') }}" style="max-height: 70px; width: auto;" alt="Logo Fincasv2">
                </td>
            </tr>
        </table>
    </div>

    <h2>Configuración seleccionada:</h2>
    <ul>
        <li>Tipo: {{ ucfirst($data['tipo']) }}</li>
        <li>Incluye costes: {{ $data['incluir_costes'] ? 'Sí' : 'No' }}</li>
    </ul>

    <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Filtros aplicados:</strong>
        Tipo: {{ ucfirst($data['tipo']) }} |
        Fechas: {{ $data['fecha_inicio'] ? \Carbon\Carbon::parse($data['fecha_inicio'])->format('d/m/Y') : 'Inicio' }} a
        {{ $data['fecha_fin'] ? \Carbon\Carbon::parse($data['fecha_fin'])->format('d/m/Y') : 'Actualidad' }} |
        Costes: {{ $data['incluir_costes'] ? 'Visibles' : 'Ocultos' }}
    </div>

    @if (in_array($data['tipo'], ['general', 'agua']))
        <h3 style="color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Consumo de Agua (Riegos)</h3>
        <table class="data-table">
            <thead style="background-color: #e9ecef;">
                <tr>
                    <th>Fecha</th>
                    <th>Tanque / Origen</th>
                    <th>Cantidad</th>
                    @if ($data['incluir_costes'])
                        <th>Coste Total</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($riegos as $riego)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($riego->date)->format('d/m/Y') }}</td>
                        <td>{{ $riego->tank ? $riego->tank->name : 'Agua Externa (Cuba)' }}</td>
                        <td>{{ number_format($riego->quantity, 2) }}</td>
                        @if ($data['incluir_costes'])
                            <td>{{ number_format($riego->cost, 2) }} €</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $data['incluir_costes'] ? 4 : 3 }}" style="text-align: center;">No se
                            registraron riegos en las fechas seleccionadas.</td>
                    </tr>
                @endforelse
            </tbody>
            @if ($riegos->count() > 0 && $data['incluir_costes'])
                <tfoot>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="3" style="text-align: right;">Total Gasto en Agua:</td>
                        <td>{{ number_format($riegos->sum('cost'), 2) }} €</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    @endif

    @if(in_array($data['tipo'], ['general', 'produccion']))
        <h3 style="color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-top: 30px;">Registro de Producción (Cosechas)</h3>
        <table class="data-table">
            <thead style="background-color: #e9ecef;">
                <tr>
                    <th>Fecha</th>
                    <th>Finca</th>
                    <th>Cantidad (Kg)</th>
                    @if($data['incluir_costes'])
                        <th>Precio (€/Kg)</th>
                        <th>Ingreso Total</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php $totalIngresos = 0; @endphp
                @forelse($producciones as $cosecha)
                    @php 
                        $ingreso = $cosecha->sale_price ?? 0; 
                        
                        $precioPorKg = $cosecha->quantity_kg > 0 ? ($ingreso / $cosecha->quantity_kg) : 0;
                        
                        $totalIngresos += $ingreso;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($cosecha->date)->format('d/m/Y') }}</td>
                        <td>{{ $cosecha->finca ? $cosecha->finca->name : 'Finca Eliminada' }}</td>
                        <td>{{ number_format($cosecha->quantity_kg, 2) }}</td>
                        @if($data['incluir_costes'])
                            <td>{{ number_format($precioPorKg, 2) }} €</td>
                            <td>{{ number_format($ingreso, 2) }} €</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $data['incluir_costes'] ? 5 : 3 }}" style="text-align: center;">No se registraron cosechas en las fechas seleccionadas.</td>
                    </tr>
                @endforelse
            </tbody>
            
            @if($producciones->count() > 0 && $data['incluir_costes'])
                <tfoot>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="4" style="text-align: right;">Total Ingresos por Producción:</td>
                        <td>{{ number_format($totalIngresos, 2) }} €</td>
                    </tr>
                    
                    <!-- Balance final si es el informe general -->
                    @if($data['tipo'] === 'general')
                        <tr style="background-color: #d1ecf1; font-weight: bold; font-size: 1.1em;">
                            <td colspan="4" style="text-align: right; border-top: 2px solid #ccc;">Balance Neto (Ingresos - Coste Agua):</td>
                            <td style="border-top: 2px solid #ccc; color: {{ ($totalIngresos - $riegos->sum('cost')) >= 0 ? 'green' : 'red' }};">
                                {{ number_format($totalIngresos - $riegos->sum('cost'), 2) }} €
                            </td>
                        </tr>
                    @endif
                </tfoot>
            @endif
        </table>
    @endif
</body>

</html>
</body>

</html>
