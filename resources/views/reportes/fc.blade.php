<!DOCTYPE html>
<html>
<head>
    <title>Frecuencia de Compras</title>
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
    <h1>Frecuencia de Compras</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Total Compras</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporte as $frecuencia)
                <tr>
                    <td>{{ $frecuencia->nombre }}</td>
                    <td>{{ $frecuencia->apellido }}</td>
                    <td>{{ $frecuencia->cedula }}</td>
                    <td>{{ $frecuencia->total_compras }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
