<div class="container">
    <h1>Lista de Empleados</h1>
    <button class="btn btn-primary mb-3" onclick="loadContent('{{ route('empleados.create') }}')">Crear Empleado</button>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Cédula</th>
                <th>Cargo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->apellido }}</td>
                    <td>{{ $empleado->correo }}</td>
                    <td>{{ $empleado->cedula }}</td>
                    <td>{{ $empleado->cargo }}</td>
                    <td>
                        <a href="#" onclick="loadContent('{{ route('empleados.edit', $empleado->id) }}')" class="btn btn-warning">Editar</a>
                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;" onsubmit="return deleteEmpleado(event, this);">
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
