<div class="container">
    <h1>Registrar Compra</h1>
    <form id="compraForm">
        @csrf
        <!-- Proveedor -->
        <div class="mb-3">
            <label for="num_factura" class="form-label">Número de Factura:</label>
            <input type="text" class="form-control" id="num_factura" name="num_factura" placeholder="XXX-XXX-XXXXXXX" pattern="\d{3}-\d{3}-\d{7}" required maxlength="15">
        </div>
        <div class="form-group">
            <label for="ruc">RUC del Proveedor:</label>
            <input type="text" class="form-control" id="ruc" name="ruc" required>
        </div>
        <div class="form-group">
            <label for="proveedor" class="form-label">Id</label>
            <input type="number" class="form-control" id="proveedor" name="proveedor"  disabled required>
        </div>
        <div class="form-group">
            <label for="nombre_proveedor">Nombre:</label>
            <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor"  disabled>
        </div>
        <div class="form-group">
            <label for="correo_proveedor">Correo:</label>
            <input type="email" class="form-control" id="correo_proveedor" name="correo_proveedor"  disabled>
        </div>
        <div class="form-group">
            <label for="telefono_proveedor">Teléfono:</label>
            <input type="text" class="form-control" id="telefono_proveedor" name="telefono_proveedor"  disabled>
        </div>
        <div class="form-group">
            <label for="direccion_proveedor">Dirección:</label>
            <input type="text" class="form-control" id="direccion_proveedor" name="direccion_proveedor"  disabled> 
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
        </div>
        <!-- Vehículo -->
        <div class="form-group">
            <label for="id_marca">Marca:</label>
            <select class="form-control" id="id_marca" name="id_marca" required>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->marca_vehiculo }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="id_modelo">Modelo:</label>
            <select class="form-control" id="id_modelo" name="id_modelo" required>
                
            </select>
        </div>
        <div class="mb-3">
            <label for="año_modelo" class="form-label">Año:</label>
            <input type="number" class="form-control" id="año_modelo" name="año_modelo" required>
        </div>
        <div class="mb-3">
            <label for="tipo_vehiculo" class="form-label">Tipo:</label>
            <select class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" required>
                <option value="Manual">Manual</option>
                <option value="Hibrido">Hibrido</option>
                <option value="Electrico">Electrico</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="precio_compra" class="form-label">Precio Compra:</label>
            <input type="number" class="form-control" id="precio_compra" name="precio_compra" required>
        </div>
        <div class="mb-3">
            <label for="kilometraje" class="form-label">Kilometraje:</label>
            <input type="number" class="form-control" id="kilometraje" name="kilometraje"  required>
        </div>
        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio Venta:</label>
            <input type="number" class="form-control" id="precio_venta" name="precio_venta" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Subir Imagen:</label>
            <input type="file" class="form-control" id="imagen" name="imagen" required>
        </div>
        <div class="mb-3" id="imagePreviewContainer" style="display: none;">
            <img id="imagePreview" src="#" alt="Vista previa de la imagen" style="max-width: 100%; height: auto;"/>
            <button type="button" id="removeImage" class="btn btn-danger mt-2">Quitar Imagen</button>
        </div>
        <div class="mb-3">
            <label for="numero_chasis" class="form-label">Numero de Chasis:</label>
            <input type="text" class="form-control" id="numero_chasis" name="numero_chasis" style="text-transform:uppercase" required>
        </div>
        <div class="mb-3">
            <label for="numero_motor" class="form-label">Numero de Motor:</label>
            <input type="text" class="form-control" id="numero_motor" name="numero_motor" style="text-transform:uppercase" required>
        </div>
        <div class="mb-3">
            <label for="placa" class="form-label">Placa:</label>
            <input type="text" class="form-control" id="placa" name="placa" style="text-transform:uppercase" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="Disponible">Disponible</option>
                <option value="Reservado">Reservado</option>
                <option value="Vendido">Vendido</option>
            </select>
        </div>
        <button type="button" id="agregarVehiculo" class="btn btn-primary">Agregar Vehículo</button>
    </form>
    <form id="detalleVehiculoForm">
        <!-- Detalle de Vehículos -->
        <h2>Detalle de Vehículos</h2>
        <table class="table" id="detalleVehiculos">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Año</th>
                    <th>Precio Venta</th>
                    <th>Kilometraje</th>
                    <th>Tipo</th>
                    <th>Numero Chasis</th>
                    <th>Numero Motor</th>
                    <th>Placa</th>
                    <th>Descripcion</th>
                    <th>Foto</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows populated dynamically -->
            </tbody>
        </table>

        <!-- Total y Acciones -->
        <div class="form-group">
            <label for="monto_final">Total:</label>
            <input type="number" step="0.01" class="form-control" id="monto_final" name="monto_final" readonly>
        </div>
        <button type="submit" class="btn btn-success">Crear Compra</button>
        <button type="button" id="cancelarCompra" class="btn btn-danger">Cancelar</button>
    </form>
</div>

<script src="/path/to/dashboard_compra.js"></script>
