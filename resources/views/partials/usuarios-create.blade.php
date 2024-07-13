<div class="container">
    <h1>Crear Usuario</h1>
    <form id="form-create-usuario" action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="dropdownEmpleado" class="form-label">Empleado:</label>
            <div class="dropdown">
                <input type="text" class="form-control dropdown-toggle" id="dropdownEmpleado" readonly aria-haspopup="true" aria-expanded="false" placeholder="Seleccionar" onclick="toggleDropdown('dropdownMenuEmpleado')">
                <div class="dropdown-menu" id="dropdownMenuEmpleado" aria-labelledby="dropdownEmpleado">
                    <input type="text" class="form-control" placeholder="Buscar..." id="searchInputEmpleado" onkeyup="filterFunction('searchInputEmpleado', 'dropdownMenuEmpleado')">
                    @foreach($empleados as $empleado)
                        <a class="dropdown-item" href="#" onclick="selectOption('dropdownEmpleado', 'hiddenEmpleado', this)" data-id="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->apellido }} - {{ $empleado->cedula }}</a>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="id_empleado" id="hiddenEmpleado" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
        <button class="btn btn-secondary" onclick="loadContent('{{ route('usuarios.index') }}')">Volver</button>
    </form>
</div>