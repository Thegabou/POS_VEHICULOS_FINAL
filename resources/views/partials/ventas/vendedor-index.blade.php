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
            <label for="id_cliente" class="form-label">ID</label>
            <input type="number" class="form-contorl" id="id_cliente" name="id_cliente" disabled>
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
        <div class="dropdown">
            <input type="text" class="form-control dropdown-toggle" id="dropdownVendedor" readonly aria-haspopup="true" aria-expanded="false" placeholder="Seleccionar" onclick="toggleDropdown('dropdownMenuVendedor')">
            <div class="dropdown-menu" id="dropdownMenuVendedor" aria-labelledby="dropdownVendedor">
                <input type="text" class="form-control" placeholder="Buscar..." id="searchInputVendedor" onkeyup="filterFunction('searchInputVendedor', 'dropdownMenuVendedor')">
                <a class="dropdown-item" href="#" onclick="selectOption('dropdownVendedor', 'hiddenVendedor', this)" data-id="{{ auth()->user()->id }}">{{ auth()->user()->name }}</a>
                @foreach ($empleados as $empleado)
                    @if (in_array($empleado->cargo, ['vendedor', 'gerente']))
                        <a class="dropdown-item" href="#" onclick="selectOption('dropdownVendedor', 'hiddenVendedor', this)" data-id="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->apellido }}</a>
                    @endif
                @endforeach
            </div>
        </div>
        <input type="hidden" name="vendedor" id="hiddenVendedor">
    </div>

    <!-- Selección de Vehículo -->
    <div class="mb-3">
        <label for="vehiculo" class="form-label">Vehículo:</label>
        <input type="text" class="form-control" id="vehiculo" name="vehiculo" placeholder="Buscar Vehículo por Código o Nombre" list="vehiculosList">
        <datalist id="vehiculosList">
            @foreach ($vehiculos as $vehiculo)
                <option value="{{ $vehiculo->id }}" data-marca="{{ $vehiculo->marca }}" data-modelo="{{ $vehiculo->modelo }}" data-año="{{ $vehiculo->año_modelo }}" data-tipo="{{ $vehiculo->tipo_vehiculo }}" data-kilometraje="{{ $vehiculo->kilometraje }}" data-precio="{{ $vehiculo->precio_venta }}" data-foto="{{ $vehiculo->foto_url }}">
                    {{ $vehiculo->marca }} {{ $vehiculo->modelo }} - {{ $vehiculo->año_modelo }} - {{ $vehiculo->tipo_vehiculo }} - {{ $vehiculo->kilometraje }} - ${{ $vehiculo->precio_venta }}
                </option>
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
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Tipo</th>
                <th>Kilometraje</th>
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
                <td colspan="7"></td>
                <td>Sub-total:</td>
                <td>$<span id="sub_total">0.00</span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7"></td>
                <td>IVA (15%):</td>
                <td>$<span id="iva">0.00</span></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7"></td>
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
            <option value="tarjeta">Tarjeta</option>
            <option value="transferencia">Transferencia Bancaria</option>
            <option value="credito">Financiamiento</option>
        </select>
    </div>
    <div id="opciones_pago"></div>
    <button class="btn btn-success" onclick="finalizarCompra()">Finalizar Compra</button>
</div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="editPrecio" class="form-label">Precio Unit:</label>
                        <input type="number" step="0.01" class="form-control" id="editPrecio" name="precio" required>
                    </div>
                    <input type="hidden" id="editIndex">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="saveEdit()">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/utilis.js')}}"></script>
