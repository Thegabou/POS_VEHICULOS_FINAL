<div class="container">
    <h1>Lista de Proveedores</h1>
    <button class="btn btn-primary mb-3" onclick="loadContent('{{ route('proveedores.create') }}')">Crear Proveedor</button>
    <div class="d-flex justify-content-end mb-3">
        <input type="text" id="search" class="form-control form-control-sm me-2" placeholder="Buscar por nombre, RUC, teléfono, correo o dirección">
        <button class="btn btn-secondary" onclick="filterProveedores()">Buscar</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>RUC</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="proveedores-tbody">
            @foreach($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->ruc }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->correo }}</td>
                    <td>{{ $proveedor->direccion }}</td>
                    <td>
                        <a href="#" onclick="loadContent('{{ route('proveedores.edit', $proveedor->id) }}')" class="btn btn-warning">Editar</a>
                        <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" style="display:inline;" onsubmit="return deleteProveedor(event, this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
