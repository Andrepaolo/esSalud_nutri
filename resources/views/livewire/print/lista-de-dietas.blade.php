<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Dietas - {{ $horario }} - {{ $fechaActual }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .area-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 20px;">
        <h1>Lista de Dietas - {{ $horario }}</h1>
        <p>Fecha: {{ $fechaActual }}</p>
    </div>

    @php
        $areasAgrupadas = $records->groupBy('bed.area.nombre');
    @endphp

    @foreach($areasAgrupadas as $nombreArea => $recordsArea)
        <h2 class="area-title">Área: {{ $nombreArea ?: 'Sin Área Asignada' }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Cama</th>
                    <th>Paciente</th>
                    <th>Dieta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recordsArea as $record)
                    <tr>
                        <td>{{ $record->bed->codigo }}</td>
                        <td>{{ optional($record->patient)->nombre }} {{ optional($record->patient)->apellido }}</td>
                        <td>{{ $record->{$horario} ?: 'No Registrada' }}</td> {{-- Acceder a la dieta por el horario --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>