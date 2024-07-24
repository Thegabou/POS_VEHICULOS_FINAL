<div class="container mt-5">
    <h1>Crear Vehículo</h1>
    <form id="form-crear-vehiculo" action="{{ route('vehiculos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="marca" class="form-label">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo" required>
        </div>
        <div class="mb-3">
            <label for="año_modelo" class="form-label">Año:</label>
            <input type="number" class="form-control" id="año_modelo" name="año_modelo" required>
        </div>
        <div class="mb-3">
            <label for="tipo_vehiculo" class="form-label">Tipo:</label>
            <input type="text" class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" required>
        </div>
        <div class="mb-3">
            <label for="precio_compra" class="form-label">Precio Compra:</label>
            <input type="number" class="form-control" id="precio_compra" name="precio_compra" required>
        </div>
        <div class="mb-3">
            <label for="kilometraje" class="form-label">Kilometraje:</label>
            <input type="number" class="form-control" id="kilometraje" name="kilometraje" required>
        </div>
        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio Venta:</label>
            <input type="number" class="form-control" id="precio_venta" name="precio_venta" required>
        </div>
        <div class="mb-3">
            <label for="foto_url" class="form-label">Foto URL:</label>
            <input type="text" class="form-control" id="foto_url" name="foto_url" required>
        </div>
        
        <button type="submit" class="btn btn-success">Crear Vehículo</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('vehiculos.index') }}')">Volver</button>
    </form>
</div>
<script src="{{ asset('js/dashboard_vehiculos.js') }}"></script>