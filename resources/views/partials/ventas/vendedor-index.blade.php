<div class="container mt-5">
    <h1>Punto de Facturación</h1>

    <!-- Selección de Cliente -->
    <form id="form-buscar-cliente">
        @csrf
        <div class="mb-3">
            <label for="cedula" class="form-label">Cédula del Cliente:</label>
            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingrese Cédula del Cliente" oninput="buscarCliente()">
        </div>
        <div class="mb-3">
            <label for="id_cliente" class="form-label" hidden>ID</label>
            <input type="number" class="form-contorl" id="id_cliente" name="id_cliente" disabled hidden>
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
    </form>

    <!-- Selección de Vendedor -->
    <div class="mb-3">
        <label for="dropdownVendedor" class="form-label">Vendedor:</label>
        <input class="form-control" value="{{$empleado->nombre}} {{$empleado->apellido}}" disabled> 
    </div>
    

    <!-- Selección de Vehículo -->
    <div class="mb-3">
        <label for="vehiculo" class="form-label">Vehículo:</label>
        <input type="text" class="form-control" id="vehiculo" name="vehiculo" placeholder="Buscar Vehículo por Placa" list="vehiculosList">
        <datalist id="vehiculosList">
            @foreach ($vehiculos as $vehiculo)
            @if($vehiculo->estado === 'Disponible' || $vehiculo->estado === 'Reservado')
                <option value="{{ $vehiculo->placa }}" data-id="{{ $vehiculo->id }}" data-marca="{{ $vehiculo->marca->marca_vehiculo }}" data-modelo="{{ $vehiculo->modelo->modelo_vehiculo }}" data-año="{{ $vehiculo->año_modelo }}" data-tipo="{{ $vehiculo->tipo_vehiculo }}" data-kilometraje="{{ $vehiculo->kilometraje }}" data-precio="{{ $vehiculo->precio_venta }}" data-chasis="{{ $vehiculo->numero_chasis }}" data-motor="{{ $vehiculo->numero_motor }}" data-foto="{{ $vehiculo->foto_url }}">
                    {{$vehiculo->placa}} - {{ $vehiculo->marca->marca_vehiculo }} {{ $vehiculo->modelo->modelo_vehiculo }} - {{ $vehiculo->año_modelo }} - {{ $vehiculo->tipo_vehiculo }} - {{ $vehiculo->kilometraje }} - ${{ $vehiculo->precio_venta }}
                </option>
            @endif
            @endforeach
        </datalist>
    </div>
    <button class="btn btn-primary" onclick="addVehiculo()">Agregar Vehículo</button>

    <!-- Carrito de Vehículos -->
    <h2>Carrito</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Tipo</th>
                <th>Kilometraje</th>
                <th>Numero Chasis</th>
                <th>Numero Motor</th>
                <th>Foto</th>
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
                <td colspan="9"></td>
                <td>Sub-total:</td>
                <td>$<span id="sub_total">0.00</span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="9"></td>
                <td>IVA (15%):</td>
                <td>$<span id="iva">0.00</span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="9"></td>
                <td>Total a Pagar:</td>
                <td>$<span id="total">0.00</span></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Opciones de Pago -->
    <div class="mb-3">
        <label for="metodo_pago" class="form-label">Método de Pago:</label>
        <select class="form-control" id="metodo_pago" name="metodo_pago" onchange="mostrarOpcionesPago()">
            <option value="efectivo">Efectivo</option>
            <option value="transferencia">Transferencia Bancaria</option>
            <option value="credito">Financiamiento</option>
        </select>
    </div>
    <div id="opciones_pago"></div>
    <button class="btn btn-success" onclick="finalizarCompra()">Finalizar Compra</button>
</div>

<script src="{{asset('js/utilis.js')}}"></script>
