<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas Diarias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas Diarias - {{ $date }}</h1>
    <table>
        <thead>
            <tr>
                <th>Número de Factura</th>
                <th>Fecha</th>
                <th>Cédula Cliente</th>
                <th>Nombre Cliente</th>
                <th>Apellido Cliente</th>
                <th>Placa Vehículo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio de Venta</th>
                <th>Total Venta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->numero_factura }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->cedula_cliente }}</td>
                <td>{{ $venta->nombre_cliente }}</td>
                <td>{{ $venta->apellido_cliente }}</td>
                <td>{{ $venta->vehiculo_placa }}</td>
                <td>{{ $venta->marca_vehiculo }}</td>
                <td>{{ $venta->modelo_vehiculo }}</td>
                <td>{{ $venta->precio_venta }}</td>
                <td>{{ $venta->total_venta }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
