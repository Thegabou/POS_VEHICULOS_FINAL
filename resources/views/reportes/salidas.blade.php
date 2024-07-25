<!DOCTYPE html>
<html>
<head>
    <title>Salidas de Vehículos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .header {
            top: 0px;
        }
        .footer {
            bottom: 0px;
        }
        .content {
            margin-top: 150px;
            margin-bottom: 50px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
        <h1>Salidas de Vehículos</h1>
 

    <div class="content">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año Modelo</th>
                    <th>Tipo de Vehículo</th>
                    <th>Fecha de Salida</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salidas as $salida)
                    <tr>
                        <td>{{ $salida->id }}</td>
                        <td>{{ $salida->marca }}</td>
                        <td>{{ $salida->modelo }}</td>
                        <td>{{ $salida->año_modelo }}</td>
                        <td>{{ $salida->tipo_vehiculo }}</td>
                        <td>{{ $salida->fecha_salida }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="6" class="text-right">Total de Vehículos: {{ $total_salidas }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} GROUNDHOGDRIVER. Todos los derechos reservados.</p>
    </div>
</body>
</html>
