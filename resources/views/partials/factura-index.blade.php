@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Crear Factura de Compra</h1>
    <form id="form-crear-compra" action="{{ route('compra.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero_factura" class="form-label">Número de Factura:</label>
            <input type="text" class="form-control" id="numero_factura" name="numero_factura" required>
        </div>
        <div class="mb-3">
            <label for="fecha_compra" class="form-label">Fecha de Compra:</label>
            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required>
        </div>
        <div class="mb-3">
            <label for="id_proveedor" class="form-label">Proveedor:</label>
            <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="vehiculos" class="form-label">Vehículos:</label>
            <table class="table" id="vehiculos-table">
                <thead>
                    <tr>
                        <th>Vehículo</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-control" name="vehiculos[0][id_vehiculo]" required>
                                @foreach($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id }}">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="vehiculos[0][cantidad]" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="addRowButton">Agregar Vehículo</button>
        </div>
        <div class="mb-3">
            <label for="monto_final" class="form-label">Monto Final:</label>
            <input type="number" class="form-control" id="monto_final" name="monto_final" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-success">Crear Compra</button>
    </form>
</div>

<script id="vehiculosData" type="application/json">
    @json($vehiculos->map(function($vehiculo) {
        return [
            'id' => $vehiculo->id,
            'marca' => $vehiculo->marca,
            'modelo' => $vehiculo->modelo
        ];
    }));
</script>
@endsection
