<div class="container mt-5">
    <h1>Punto de Facturación</h1>
    
    <!-- Selección de Cliente -->
    <div class="mb-3">
        <label for="cedula" class="form-label">Cédula del Cliente:</label>
        <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingrese Cédula del Cliente" oninput="buscarCliente()">
    </div>
    <div class="mb-3">
        <label for="nombre_apellido" class="form-label">Nombre y Apellido:</label>
        <input type="text" class="form-control" id="nombre_apellido" name="nombre_apellido" disabled>
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" class="form-control" id="telefono" name="telefono" disabled>
    </div>
    <div class="mb-3">
        <label for="correo" class="form-label">Correo Electrónico:</label>
        <input type="text" class="form-control" id="correo" name="correo" disabled>
    </div>
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
    </div>

    <!-- Selección de Vendedor -->
    <div class="mb-3">
        <label for="vendedor" class="form-label">Vendedor:</label>
        <select class="form-control" id="vendedor" name="vendedor">
            <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
            @foreach($empleados as $empleado)
                @if(in_array($empleado->cargo, ['vendedor', 'gerente']))
                    <option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->apellido }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <!-- Selección de Vehículo -->
    <div class="mb-3">
        <label for="vehiculo" class="form-label">Vehículo:</label>
        <input type="text" class="form-control" id="vehiculo" name="vehiculo" placeholder="Buscar Vehículo por Código o Nombre" list="vehiculosList">
        <datalist id="vehiculosList">
            @foreach($vehiculos as $vehiculo)
                <option value="{{ $vehiculo->id }}">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} - ${{ $vehiculo->precio_venta }}</option>
            @endforeach
        </datalist>
    </div>
    <button class="btn btn-primary" onclick="addVehiculo()">Agregar Vehículo</button>

    <!-- Carrito de Vehículos -->
    <h2>Carrito</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Vehículo</th>
                <th>Precio Unit</th>
                <th>Precio Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="carrito-tbody">
            <!-- Vehículos agregados aparecerán aquí -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>Sub-total:</td>
                <td>$<span id="sub_total">0.00</span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>IVA (15%):</td>
                <td>$<span id="iva">0.00</span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>Total a Pagar:</td>
                <td>$<span id="total">0.00</span></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Opciones de Pago -->
    <div class="mb-3">
        <label for="metodo_pago" class="form-label">Método de Pago:</label>
        <select class="form-control" id="metodo_pago" name="metodo_pago">
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta">Tarjeta</option>
            <option value="transferencia">Transferencia Bancaria</option>
            <option value="credito">Crédito</option>
        </select>
    </div>
    <button class="btn btn-success" onclick="finalizarCompra()">Finalizar Compra</button>
</div>