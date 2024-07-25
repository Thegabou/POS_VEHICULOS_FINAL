<!DOCTYPE html>
<html>
<head>
    <title>Entradas de Vehículos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Entradas de Vehículos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año Modelo</th>
                <th>Tipo de Vehículo</th>
                <th>Fecha de Entrada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->id }}</td>
                    <td>{{ $entrada->marca }}</td>
                    <td>{{ $entrada->modelo }}</td>
                    <td>{{ $entrada->año_modelo }}</td>
                    <td>{{ $entrada->tipo_vehiculo }}</td>
                    <td>{{ $entrada->fecha_entrada }}</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td colspan="6" class="text-right">Total de Vehículos: {{ $total_entradas }}</td>
        </tr>
    </table>
    <div class="footer">
        <p>&copy; {{ date('Y') }} GROUNDHOGDRIVER. Todos los derechos reservados.</p>
    </div>
</body>
</html>
