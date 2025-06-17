<!DOCTYPE html>
<html>
<head>
    <title>Dietas - {{ ucfirst($horario) }} - {{ now()->format('d-m-Y') }}</title>
    <style>
    @page {
        size: 70mm 60mm;
        margin: 0;
    }

    body {
        width: 70mm;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        font-size: 10px;
    }

    .ticket {
        width: 70mm;
        height: 60mm;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
        page-break-after: always; /* una dieta por página si imprimes varias */
        text-align: center;
        padding: 5px;
    }

    img {
        max-width: 60mm;
        height: auto;
    }

    .area-header, .meal-header {
        font-weight: bold;
        margin: 2px 0;
    }

    .record-item {
        margin-bottom: 2px;
    }

    .label {
        font-weight: bold;
    }
    </style>


</head>
<body>
    
    @foreach($registrosPorAreaPaginados as $areaNombre => $registrosPaginados) {{-- BUCLE EXTERNO: ÁREAS --}}
        
        

        @foreach($registrosPaginados as $registro) {{-- BUCLE INTERNO: REGISTROS PAGINADOS DENTRO DE CADA ÁREA --}}
        <div class="ticket">
            @if($loop->first) {{-- Mostrar encabezado de horario solo al inicio de cada ÁREA --}}
                
                <div class="meal-header"><strong>{{ ucfirst($horario) }}</strong></div>
            @endif

            <div style="text-align: center; margin-top: 5px;">
                <img src="{{ asset('images/esSaludlogo.png') }}" alt="EsSalud Logo" style="width: 100px;">
            </div>
            <div class="record-item">
                <span class="label">Cama:</span> {{ $registro->bed->codigo }}-{{ $areaNombre }} {{-- Usar $areaNombre aquí --}}
            </div>
            <div class="record-item">
                <span class="label">Paciente:</span> {{ optional($registro->patient)->nombreCompleto() ?? '---' }}
            </div>
            
            
            <div class="record-item">
                <span class="label">Dieta ({{ $nombreDietaHorario }}):</span>
                @php
                    $dietaText = 'No Registrada';
                    // --- CÓDIGO CORRECTO PARA OBTENER LA DIETA DESDE $registro ---
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
        </div>
        @endforeach {{-- FIN BUCLE INTERNO: REGISTROS PAGINADOS DENTRO DE CADA ÁREA --}}

        @if($registrosPaginados->isEmpty()) {{-- Mensaje "No hay dietas" por ÁREA --}}
            <p style="text-align: center;">No hay dietas registradas para este horario en el área {{ $areaNombre }}.</p>
        @endif

        @if(!$loop->last) {{-- Separador entre ÁREAS --}}
            <hr style="border-top: 1px dashed #000; margin-top: 10px; margin-bottom: 10px;">
        @endif

    @endforeach {{-- FIN BUCLE EXTERNO: ÁREAS --}}

    @if(empty($registrosPorAreaPaginados)) {{-- Mensaje general "No hay dietas" si no hay áreas - Usar empty() en ARRAY --}}
        <p style="text-align: center;">No hay dietas registradas para este horario y área.</p>
    @endif

</body>
</html>