<div class="container">
    <h1>Editar Vehículo</h1>
    <form id="form-edit-vehiculo" action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{ $vehiculo->marca }}" required>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $vehiculo->modelo }}" required>
        </div>
        <div class="form-group">
            <label for="año_modelo">Año:</label>
            <input type="number" class="form-control" id="año_modelo" name="año_modelo" value="{{ $vehiculo->año_modelo }}" required>
        </div>
        <div class="form-group">
            <label for="tipo_vehiculo">Tipo:</label>
            <input type="text" class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" value="{{ $vehiculo->tipo_vehiculo }}" required>
        </div>
        <div class="form-group">
            <label for="precio_compra">Precio Compra:</label>
            <input type="number" class="form-control" id="precio_compra" name="precio_compra" value="{{ $vehiculo->precio_compra }}" required>
        </div>
        <div class="form-group">
            <label for="kilometraje">Kilometraje:</label>
            <input type="number" class="form-control" id="kilometraje" name="kilometraje" value="{{ $vehiculo->kilometraje }}" required>
        </div>
        <div class="form-group">
            <label for="precio_venta">Precio Venta:</label>
            <input type="number" class="form-control" id="precio_venta" name="precio_venta" value="{{ $vehiculo->precio_venta }}" required>
        </div>
        <div class="form-group">
            <label for="foto_url">Foto URL:</label>
            <input type="text" class="form-control" id="foto_url" name="foto_url" value="{{ $vehiculo->foto_url }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar Vehículo</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('vehiculos.index') }}')">Volver</button>
    </form>
</div>


