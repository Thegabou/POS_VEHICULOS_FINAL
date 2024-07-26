<!DOCTYPE html>
<html>
<head>
    <title>Preferencias de Clientes</title>
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
    <h1>Preferencias de Clientes</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Número de Chasis</th>
                <th>Número de Motor</th>
                <th>Veces Comprado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporte as $preferencia)
                <tr>
                    <td>{{ $preferencia->nombre }}</td>
                    <td>{{ $preferencia->apellido }}</td>
                    <td>{{ $preferencia->cedula }}</td>
                    <td>{{ $preferencia->marca }}</td>
                    <td>{{ $preferencia->modelo }}</td>
                    <td>{{ $preferencia->numero_chasis }}</td>
                    <td>{{ $preferencia->numero_motor }}</td>
                    <td>{{ $preferencia->veces_comprado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
