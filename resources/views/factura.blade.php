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
    <div class="header">
        <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" class="logo">
        <h1>AUTOMOTORA, S.A.S</h1>
        <p>
            NIT: xxxxxxx<br>
            CALLE 1<br>
            ENVIADO<br>
            Teléfono: xxxxxxx
        </p>
    </div>

    <div class="content">
        <table class="details">
            <tr>
                <td><strong>Ha sido atendido por:</strong></td>
                <td>Nombre del Vendedor</td>
                <td><strong>NIT/Cédula:</strong></td>
                <td>{{ $cliente->cedula }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>xxxxxxx</td>
                <td><strong>Cuenta Cliente:</strong></td>
                <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>xxxxxxx</td>
                <td><strong>Teléfono:</strong></td>
                <td>{{ $cliente->numero_telefono }}</td>
            </tr>
            <tr>
                <td><strong>Celular:</strong></td>
                <td>xxxxxxx</td>
                <td><strong>Email:</strong></td>
                <td>{{ $cliente->correo }}</td>
            </tr>
            <tr>
                <td><strong>Código:</strong></td>
                <td>xxxxxxx</td>
            </tr>
        </table>

        <h2 class="text-center">COTIZACIÓN Nº {{ $factura->id }} emitida el {{ date('Y-m-d') }}</h2>

        <table class="table">
            <tr>
                <th>Cod. Modelo</th>
                <th>Chasis</th>
                <th>Color</th>
                <th>Año Modelo</th>
                <th class="text-right">Precio de Venta</th>
            </tr>
            <tr>
                <td>{{ $vehiculo->modelo }}</td>
                <td>xxxxxxx</td>
                <td>xxxxxxx</td>
                <td>{{ $vehiculo->año_modelo }}</td>
                <td class="text-right">${{ number_format($vehiculo->precio_venta, 2) }}</td>
            </tr>
        </table>

        <div>
            <img src="{{ $vehiculo->foto_url }}" alt="Foto del Vehículo" style="width: 200px; float: right; margin-left: 20px;">
            <p><strong>* Fotografía de Referencia</strong></p>
        </div>

        <h3>Accesorios:</h3>
        <ul>
            <li>Accesorio 1</li>
            <li>Accesorio 2</li>
            <li>Accesorio 3</li>
        </ul>

        <h3>Conceptos:</h3>
        <table class="table">
            <tr>
                <th>Descripción</th>
                <th class="text-right">Valor</th>
            </tr>
            <tr>
                <td>SOAT 1 Año</td>
                <td class="text-right">295,100.00</td>
            </tr>
            <tr>
                <td>Matriculación</td>
                <td class="text-right">450,000.00</td>
            </tr>
            <tr>
                <td>Impuesto de Matriculación</td>
                <td class="text-right">190,000.00</td>
            </tr>
            <tr>
                <td class="bold">Total Venta</td>
                <td class="text-right bold">${{ number_format($factura->total, 2) }}</td>
            </tr>
        </table>

        <h3>Financiación:</h3>
        <table class="table">
            <tr>
                <th>Entidad</th>
                <th>Plazo</th>
                <th>T. Interés</th>
                <th>Gastos</th>
                <th>Cuota Inicial</th>
                <th>Valor a Financiar</th>
                <th>Cuota Mensual</th>
            </tr>
            <tr>
                <td>Entidad 1</td>
                <td>36 Meses</td>
                <td>1.5%</td>
                <td>100,000.00</td>
                <td>5,000,000.00</td>
                <td>30,000,000.00</td>
                <td>900,000.00</td>
            </tr>
        </table>

        <p class="text-right">Cotización válida hasta {{ date('Y-m-d', strtotime('+30 days')) }}</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} AUTOMOTORA, S.A.S. Todos los derechos reservados.</p>
    </div>
</body>
</html>
