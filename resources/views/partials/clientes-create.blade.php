<div class="container mt-5">
    <h1>Crear Cliente</h1>
    <form id="form-crear-cliente" action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="numero_telefono" class="form-label">Número de Teléfono:</label>
            <input type="number" class="form-control" id="numero_telefono" name="numero_telefono" required>
        </div>
        <div class="mb-3">
            <label for="cedula" class="form-label">Cédula:</label>
            <input type="number" class="form-control" id="cedula" name="cedula" required>
        </div>
        <button type="submit" class="btn btn-success">Crear Cliente</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('clientes.index') }}')">Volver</button>
    </form>
</div>
