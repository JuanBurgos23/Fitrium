<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Inscripciones</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Historial de Inscripciones de {{ $cliente->nombre_completo }}</h2>
    <table>
        <thead>
            <tr>
                <th>Paquete</th>
                <th>Fecha de Inscripción</th>
                <th>Fecha de Expiración</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cliente->inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->paquete->nombre }}</td>
                <td>{{ $inscripcion->fecha_inicio }}</td>
                <td>{{ $inscripcion->fecha_expiracion }}</td>
                <td>{{ $inscripcion->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
