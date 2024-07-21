<div class="container">
    <h1>Lista de Empleados</h1>
    <button class="btn btn-primary mb-3" onclick="loadContent('{{ route('empleados.create') }}')">Crear Empleado</button>
    <div class="d-flex justify-content-end mb-3">
        <input type="text" id="search-empleados" class="form-control form-control-sm me-2" placeholder="Buscar por nombre, apellido, correo, cédula o cargo">
        <button class="btn btn-secondary" onclick="filterEmpleados()">Buscar</button>
    </div>
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
        <tbody id="empleados-tbody">
            @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->apellido }}</td>
                    <td>{{ $empleado->correo }}</td>
                    <td>{{ $empleado->cedula }}</td>
                    <td>{{ $empleado->cargo }}</td>
                    <td>
                        <a href="#" onclick="loadContent('{{ route('empleados.edit', $empleado->id) }}')" class="btn btn-warning"><i class="fa-solid fa-pencil"></i> Editar</a>
                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;" onsubmit="return deleteEmpleado(event, this);">
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
