<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Inscripciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Historial de Inscripciones</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>CI</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Paquete</th>
                <th>Fecha de Inscripción</th>
                <th>Expira</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->cliente->nombre_completo }}</td>
                <td>{{ $inscripcion->cliente->ci }}</td>
                <td>{{ $inscripcion->cliente->telefono }}</td>
                <td>{{ $inscripcion->cliente->correo }}</td>
                <td>{{ $inscripcion->paquete->nombre }}</td>
                <td>{{ $inscripcion->created_at->format('d/m/Y') }}</td>
                <td>{{ $inscripcion->fecha_expiracion }}</td>
                <td>{{ ucfirst($inscripcion->estado) }}</td> <!-- Capitaliza la primera letra -->
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>