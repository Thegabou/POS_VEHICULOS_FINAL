<div class="container">
    <h1>Lista de Vehículos</h1>
    {{-- <button class="btn btn-primary mb-3" onclick="loadContent('{{ route('vehiculos.create') }}')">Crear Vehículo</button> --}}
    <div class="d-flex justify-content-end mb-3">
        <input type="text" id="search" class="form-control form-control-sm me-2" placeholder="Buscar por marca, modelo, año, tipo o precio">
        <button class="btn btn-secondary" onclick="filterVehiculos()">Buscar</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Tipo</th>
                <th>Precio Compra</th>
                <th>Kilometraje</th>
                <th>Precio Venta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="vehiculos-tbody">
            @foreach($vehiculos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->marca }}</td>
                    <td>{{ $vehiculo->modelo }}</td>
                    <td>{{ $vehiculo->año_modelo }}</td>
                    <td>{{ $vehiculo->tipo_vehiculo }}</td>
                    <td>{{ $vehiculo->precio_compra }}</td>
                    <td>{{ $vehiculo->kilometraje }}</td>
                    <td>{{ $vehiculo->precio_venta }}</td>
                    <td>
                        <a href="#" onclick="loadContent('{{ route('vehiculos.edit', $vehiculo->id) }}')" class="btn btn-warning"><i class="fa-solid fa-pencil"></i> Editar</a>
                        <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" style="display:inline;" onsubmit="return deleteVehiculo(event, this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>