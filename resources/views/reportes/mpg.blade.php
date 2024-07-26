<!DOCTYPE html>
<html>
<head>
    <title>Monto Promedio Gastado</title>
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
    <h1>Monto Promedio Gastado</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Promedio Gastado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporte as $promedio)
                <tr>
                    <td>{{ $promedio->nombre }}</td>
                    <td>{{ $promedio->apellido }}</td>
                    <td>{{ $promedio->cedula }}</td>
                    <td>{{ $promedio->promedio_gastado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
