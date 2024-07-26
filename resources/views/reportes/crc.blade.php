<!DOCTYPE html>
<html>
<head>
    <title>Clientes con Compras Recurrentes</title>
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
    <h1>Clientes con Compras Recurrentes</h1>
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
            @foreach ($reporte as $recurrente)
                <tr>
                    <td>{{ $recurrente->nombre }}</td>
                    <td>{{ $recurrente->apellido }}</td>
                    <td>{{ $recurrente->cedula }}</td>
                    <td>{{ $recurrente->total_compras }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
