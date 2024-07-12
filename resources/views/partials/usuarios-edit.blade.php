<div class="container">
    <h1>Editar Usuario</h1>
    <form id="form-edit-usuario" action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="cedula">Buscar Empleado por Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula" oninput="searchEmpleado()">
        </div>
        <div class="form-group">
            <label for="id_empleado">Empleado:</label>
            <select class="form-control" id="id_empleado" name="id_empleado" required>
                <option value="">Seleccione un empleado</option>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}" {{ $empleado->id == $usuario->id_empleado ? 'selected' : '' }}>
                        {{ $empleado->nombre }} {{ $empleado->apellido }} - {{ $empleado->cedula }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $usuario->correo }}" required>
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña (dejar en blanco para mantener actual):</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('usuarios.index') }}')">Volver</button>
    </form>
</div>
