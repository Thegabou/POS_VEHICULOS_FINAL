<div class="container">
    <h1>Editar Proveedor</h1>
    <form id="form-edit-proveedor" action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $proveedor->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="ruc">RUC:</label>
            <input type="text" class="form-control" id="ruc" name="ruc" value="{{ $proveedor->ruc }}" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $proveedor->telefono }}" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $proveedor->correo }}" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $proveedor->direccion }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('proveedores.index') }}')">Volver</button>
    </form>
</div>
