<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas Mensuales</title>
    <style>
        /* Your custom styles for the PDF */
    </style>
</head>
<body>
    <h1>Reporte de Ventas Mensuales - Mes {{ $month }}</h1>
    <table>
        <thead>
            <tr>
                <th>Factura ID</th>
                <th>Fecha</th>
                <th>Cliente ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio de Venta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->id_cliente }}</td>
                <td>{{ $venta->marca }}</td>
                <td>{{ $venta->modelo }}</td>
                <td>{{ $venta->precio_venta }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
