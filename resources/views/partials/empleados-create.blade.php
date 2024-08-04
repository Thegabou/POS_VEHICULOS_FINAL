<div class="container">
    <h1>Crear Empleado</h1>
    <form id="form-create-empleado" action="{{ route('empleados.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula" required>
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo:</label>
            <select class="form-control" id="cargo" name="cargo" required>
                <option value="Admin">Admin</option>
                <option value="Gerente">Gerente</option>
                <option value="Vendedor">Vendedor</option>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Crear Empleado</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('empleados.index') }}')">Volver</button>
    </form>
</div>
