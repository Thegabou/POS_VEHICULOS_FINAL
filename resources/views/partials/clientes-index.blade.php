<div class="container">
    <h1>Lista de Clientes</h1>
    <button class="btn btn-primary mb-3" onclick="loadContent('{{ route('clientes.create') }}')">Crear Cliente</button>
    <div class="d-flex justify-content-end mb-3">
        <input type="text" id="search" class="form-control form-control-sm me-2" placeholder="Buscar por nombre, apellido, correo, cédula o número de teléfono">
        <button class="btn btn-secondary" onclick="filterClientes()">Buscar</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Número de Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="clientes-tbody">
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->apellido }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>{{ $cliente->numero_telefono }}</td>
                    <td>
                        <a href="#" onclick="loadContent('{{ route('clientes.edit', $cliente->id) }}')" class="btn btn-warning"><i class="fa-solid fa-pencil"></i> Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;" onsubmit="return deleteCliente(event, this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                        </form>
                        <a href="{{ route('clientes.historialCompras', $cliente->id) }}" class="btn btn-primary">Historial De Compras</a>
                        <a href="{{ route('clientes.generarReportes', $cliente->id) }}" class="btn btn-primary">Reporte</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="{{asset('js/dashboard_clientes.js')}}"></script>