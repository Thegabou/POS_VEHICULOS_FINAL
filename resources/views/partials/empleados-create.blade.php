<div class="container">
    <h2>Creación de Empleados</h2>
    <form action="{{ route('empleados.store') }}" method="POST">
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
            <input type="number" class="form-control" id="cedula" name="cedula" required>
        </div>
        <div class="form-group">
            <label for="cargo">Cargo:</label>
            <input type="text" class="form-control" id="cargo" name="cargo" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Empleado</button>
    </form>
</div>
