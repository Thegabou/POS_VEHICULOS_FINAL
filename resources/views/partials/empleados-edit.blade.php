<div class="container">
    <h1>Editar Empleado</h1>
    <form id="form-edit-empleado" action="{{ route('empleados.update', $empleado->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empleado->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $empleado->apellido }}" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $empleado->correo }}" required>
        </div>
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="number" class="form-control" id="cedula" name="cedula" value="{{ $empleado->cedula }}" required>
        </div>
        <div class="form-group">
            <label for="cargo">Cargo:</label>
            <input type="text" class="form-control" id="cargo" name="cargo" value="{{ $empleado->cargo }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('empleados.index') }}')">Volver</button>
    </form>
</div>
