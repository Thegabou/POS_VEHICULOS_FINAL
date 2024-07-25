<!DOCTYPE html>
<html>
<head>
    <title>Vehículos Más Vendidos</title>
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
    <h1>Vehículos Más Vendidos</h1>
    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Total Vendidos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menosVendidos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->marca }}</td>
                    <td>{{ $vehiculo->modelo }}</td>
                    <td>{{ $vehiculo->total_vendidos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>&copy; {{ date('Y') }} GROUNDHOGDRIVER. Todos los derechos reservados.</p>
    </div>
</body>
</html>
