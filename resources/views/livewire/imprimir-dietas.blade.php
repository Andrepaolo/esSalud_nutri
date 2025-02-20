<!DOCTYPE html>
<html>
<head>
    <title>Dietas - {{ ucfirst($horario) }} - {{ now()->format('d-m-Y') }}</title>
    <style>
        body {
            font-family: monospace; /* Fuente monoespaciada para mejor alineación en texto plano */
            font-size: 12px; /* Ajusta el tamaño de fuente si es necesario */
            margin: 0; /* Sin márgenes para aprovechar el ancho del papel */
            padding: 5mm; /* Pequeño padding interno para separación del borde */
            word-wrap: break-word; /* Romper palabras largas para evitar desbordamiento */
        }
        .area-header {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        .meal-header {
            font-size: 13px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .record-item {
            margin-bottom: 3px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

    @php
        $currentAreaName = null;
    @endphp

    @foreach($registrosDiarios as $registro)  {{--  INICIO del bucle @foreach - IMPORTANTE: TODO DENTRO DEBE ESTAR AQUÍ --}}
        @if($currentAreaName !== $registro->bed->area->nombre)
            @if($currentAreaName !== null)
                <hr style="border-top: 1px dashed #000; margin-top: 10px; margin-bottom: 10px;">
            @endif
            <div class="area-header">{{ $registro->bed->area->nombre }}</div>
            @php
                $currentAreaName = $registro->bed->area->nombre;
            @endphp
        @endif

        @if($loop->first || ($registrosDiarios[$loop->index-1]->bed->area->nombre !== $registro->bed->area->nombre))
            <div class="meal-header">{{ ucfirst($horario) }}</div>
        @endif


        <div class="record-item">
            <span class="label">Paciente:</span> {{ optional($registro->patient)->nombreCompleto() ?? '---' }}
        </div>
        <div class="record-item">
            <span class="label">Cama:</span> {{ $registro->bed->codigo }}
        </div>
        <div class="record-item">
            <span class="label">Dieta ({{ $nombreDietaHorario }}):</span>
            @php
                $dietaText = 'No Registrada';
                // --- MODIFICACIÓN IMPORTANTE: Obtener la dieta directamente de $registro ---
                switch($horario) {
                    case 'desayuno':
                        $dietaText = $registro->desayuno ?: 'No Registrada';
                        break;
                    case 'am10':
                        $dietaText = $registro->am10 ?: 'No Registrada';
                        break;
                    case 'almuerzo':
                        $dietaText = $registro->almuerzo ?: 'No Registrada';
                        break;
                    case 'cena':
                        $dietaText = $registro->cena ?: 'No Registrada';
                        break;
                    case 'pm4': // Asegúrate de que 'pm4' coincida con tu código
                        $dietaText = $registro->pm4 ?: 'No Registrada';
                        break;
                    default:
                        $dietaText = 'No Registrada';
                        break;
                }
                // -----------------------------------------------------------------------
            @endphp
            {{ $dietaText }}
        </div>
        <div class="record-item">
            <span class="label">Fecha:</span> {{ $registro->fecha_registro->format('d-m-Y') }}
        </div>
        <hr style="border-bottom: 1px dotted #ccc; margin-top: 5px; margin-bottom: 5px;">

    @endforeach {{--  FIN del bucle @foreach - IMPORTANTE: TODO DENTRO DEBE ESTAR AQUÍ --}}

    @if(count($registrosDiarios) == 0)
        <p style="text-align: center;">No hay dietas registradas para este horario y área.</p>
    @endif

</body>
</html>