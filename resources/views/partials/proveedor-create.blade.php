<div class="container mt-5">
    <h1>Crear Proveedor</h1>
    <form id="form-crear-proveedor" action="{{ route('proveedores.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="ruc" class="form-label">RUC:</label>
            <input type="text" class="form-control" id="ruc" name="ruc" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <button type="submit" class="btn btn-success">Crear Proveedor</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('proveedores.index') }}')">Volver</button>
    </form>
</div>
