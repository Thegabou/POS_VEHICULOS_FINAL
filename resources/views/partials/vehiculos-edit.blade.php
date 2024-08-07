<div class="container">
    <h1>Editar Vehículo</h1>
    <form id="form-edit-vehiculo" action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{ $vehiculo->marca }}" required>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $vehiculo->modelo }}" required>
        </div> --}}
        <div class="form-group">
            <label for="año_modelo">Año:</label>
            <input type="number" class="form-control" id="año_modelo" name="año_modelo" value="{{ $vehiculo->año_modelo }}" required>
        </div>
        <div class="mb-3">
            <label for="tipo_vehiculo" class="form-label">Tipo:</label>
            <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" required>
                <option value="Manual">Manual</option>
                <option value="Hibrido">Hibrido</option>
                <option value="Electrico">Electrico</option>
            </select>
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
        {{-- <div class="form-goup">
            <label for="imagen" class="form-label">Subir Imagen:</label>
            <input type="file" class="form-control" id="imagen" name="imagen" required>
        </div>
        <div class="form-goup" id="imagePreviewContainer" style="display: none;">
            <img id="imagePreview" src="#" alt="Vista previa de la imagen" style="max-width: 100%; height: auto;"/>
            <button type="button" id="removeImage" class="btn btn-danger mt-2">Quitar Imagen</button>
        </div> --}}
        <div class="form-group">
            <label for="numero_chasis">Numero Chasis:</label>
            <input type="text" class="form-control" id="numero_chasis" name="numero_chasis" value="{{ $vehiculo->numero_chasis }}" required>
        </div>
        <div class="form-group">
            <label for="numero_motor">Numero Motor:</label>
            <input type="text" class="form-control" id="numero_motor" name="numero_motor" value="{{ $vehiculo->numero_motor }}" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="Disponible" {{ $vehiculo->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Vendido" {{ $vehiculo->estado == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                <option value="Reservado" {{ $vehiculo->estado == 'Reservado' ? 'selected' : '' }}>Reservado</option>
            </select>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar Vehículo</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('vehiculos.index') }}')">Volver</button>
    </form>
</div>
<script src="{{ asset('js/dashboard_vehiculos.js') }}"></script>

