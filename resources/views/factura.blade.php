<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
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
            margin-top: 50px;
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
            padding: 10px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        .details {
            width: 100%;
            margin-bottom: 20px;
        }
        .details td {
            padding: 5px;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="content">
        <table class="details">
            <tr>
                <td><strong>Ha sido atendido por:</strong></td>
                <td>{{$empleadonombre}}</td>
                <td><strong>NIT/Cédula:</strong></td>
                <td>{{ $cliente->cedula }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>{{ $cliente->numero_telefono }}</td>
                <td><strong>Cuenta Cliente:</strong></td>
                <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $cliente->correo }}</td>
                <td><strong>Fecha:</strong></td>
                <td>{{ date('Y-m-d') }}</td>
            </tr>
        </table>

        <h2 class="text-center">FACTURA Nº {{ $factura->id }} emitida el {{ date('Y-m-d') }}</h2>

        <table class="table">
            <tr>
                <th>Cod. Modelo</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Año Modelo</th>
                <th>Placa</th>
                <th>Chasis</th>
                <th>Motor</th>
                <th>Kilometraje</th>
                <th class="text-right">Precio de Venta</th>
            </tr>
            <tr>
                <td>{{ $vehiculo->modelo->modelo_vehiculo }}</td>
                <td>{{ $vehiculo->marca->marca_vehiculo }}</td>
                <td>{{ $vehiculo->tipo_vehiculo }}</td>
                <td>{{ $vehiculo->año_modelo }}</td>
                <td>{{ $vehiculo->placa }}</td>
                <td>{{ $vehiculo->numero_chasis }}</td>
                <td>{{ $vehiculo->numero_motor }}</td>
                <td>{{ $vehiculo->kilometraje }}</td>
                <td class="text-right">${{ number_format($vehiculo->precio_venta, 2) }}</td>
            </tr>
        </table>

    

        <h3>Conceptos:</h3>
        <table class="table">
            <tr>
                <td class="bold">Total Venta</td>
                <td class="text-right bold">${{ number_format($factura->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} GROUNDHOGDRIVER. Todos los derechos reservados.</p>
    </div>
</body>
</html>
