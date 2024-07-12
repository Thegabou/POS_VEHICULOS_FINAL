<div class="container">
    <h1>Crear Usuario</h1>
    <form id="form-create-usuario" action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="cedula" class="form-label">Buscar Empleado por Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula">
        </div>
        <div class="mb-3">
            <label for="id_empleado" class="form-label">Empleado:</label>
            <select class="form-control" id="id_empleado" name="id_empleado" required>
                <option value="">Seleccione un empleado</option>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->apellido }} - {{ $empleado->cedula }}</option>
                @endforeach
            </select>
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