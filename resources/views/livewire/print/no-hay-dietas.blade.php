<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Hay Dietas - {{ $horario }} - {{ $fechaActual }}</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>No Hay Dietas Registradas para {{ $horario }}</h1>
        <p>Fecha: {{ $fechaActual }}</p>
        <p>No se encontraron registros de dietas para el horario y fecha seleccionados.</p>
    </div>
</body>
</html>