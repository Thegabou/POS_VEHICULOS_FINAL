<div class="container">
    <h1>Lista de Usuarios</h1>
    <button class="btn btn-primary mb-3" onclick="loadContent('{{ route('usuarios.create') }}')">Crear Usuario</button>
    <table class="table">
        <thead>
            <tr>
                <th>Correo</th>
                <th>Empleado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="usuarios-tbody">
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->correo }}</td>
                    <td>{{ $usuario->empleado->nombre }} {{ $usuario->empleado->apellido }}</td>
                    <td>
                        <a href="#" onclick="loadContent('{{ route('usuarios.edit', $usuario->id) }}')" class="btn btn-warning">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;" onsubmit="return deleteUsuario(event, this);">
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
