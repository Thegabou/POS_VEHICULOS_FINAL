<!DOCTYPE html>
<html>
<head>
    <title>Historial de Compras</title>
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
    <h1>Historial de Compras</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Factura ID</th>
                <th>Fecha de Compra</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año Modelo</th>
                <th>Tipo de Vehículo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historial as $compra)
                <tr>
                    <td>{{ $compra->nombre }}</td>
                    <td>{{ $compra->apellido }}</td>
                    <td>{{ $compra->cedula }}</td>
                    <td>{{ $compra->factura_id }}</td>
                    <td>{{ $compra->fecha_compra }}</td>
                    <td>{{ $compra->marca }}</td>
                    <td>{{ $compra->modelo }}</td>
                    <td>{{ $compra->año_modelo }}</td>
                    <td>{{ $compra->tipo_vehiculo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
