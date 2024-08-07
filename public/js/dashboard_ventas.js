document.addEventListener('DOMContentLoaded', function () {
    const cedulaInput = document.getElementById('cedula');
    cedulaInput.addEventListener('input', buscarCliente);
});

// Variables globales para el carrito
let carrito = [];
let total = 0;

// Función para buscar cliente por cédula
function buscarCliente() {
    const cedula = document.getElementById('cedula').value;
    if (cedula.length > 0) {
        const form = document.getElementById('form-buscar-cliente');
        const url = "/vendedor/buscar-cliente/" + cedula;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('id_cliente').value = data.id;
                    document.getElementById('nombre_apellido').value = data.nombre + ' ' + data.apellido;
                    document.getElementById('telefono').value = data.numero_telefono;
                    document.getElementById('correo').value = data.correo;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cliente no encontrado',
                        text: 'No se encontró ningún cliente con esa cédula',
                    });
                }
            })
            .catch(error => {
                console.error('Error al buscar el cliente:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al buscar el cliente. Por favor, inténtelo nuevamente.',
                });
            });
    } else {
        document.getElementById('nombre_apellido').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('correo').value = '';
    }
}

function addVehiculo() {
    const vehiculoInput = document.getElementById('vehiculo');
    const vehiculoPlaca = vehiculoInput.value;
    const vehiculoOption = document.querySelector(`#vehiculosList option[value="${vehiculoPlaca}"]`);

    if (vehiculoOption) {
        const vehiculoId = vehiculoOption.getAttribute('data-id');
        const vehiculoMarca = vehiculoOption.getAttribute('data-marca');
        const vehiculoModelo = vehiculoOption.getAttribute('data-modelo');
        const vehiculoAño = vehiculoOption.getAttribute('data-año');
        const vehiculoTipo = vehiculoOption.getAttribute('data-tipo');
        const vehiculoKilometraje = vehiculoOption.getAttribute('data-kilometraje');
        const vehiculoPrecio = parseFloat(vehiculoOption.getAttribute('data-precio'));
        const vehiculoChasis = vehiculoOption.getAttribute('data-chasis');
        const vehiculoMotor = vehiculoOption.getAttribute('data-motor');
        const vehiculoFoto = vehiculoOption.getAttribute('data-foto');

        // Verificar si el vehículo ya está en el carrito
        const vehiculoExistente = carrito.find(vehiculo => vehiculo.placa === vehiculoPlaca);
        if (vehiculoExistente) {
            Swal.fire({
                title: 'Error',
                text: 'El vehículo ya se encuentra en el carrito',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // Agregar el nuevo vehículo al carrito
            const vehiculo = {
                id: vehiculoId,
                placa: vehiculoPlaca,
                marca: vehiculoMarca,
                modelo: vehiculoModelo,
                año: vehiculoAño,
                tipo: vehiculoTipo,
                kilometraje: vehiculoKilometraje,
                chasis: vehiculoChasis,
                motor: vehiculoMotor,
                foto: vehiculoFoto,
                precio: vehiculoPrecio,
                subtotal: vehiculoPrecio
            };
            carrito.push(vehiculo);
        }

        updateCarrito();
        vehiculoInput.value = '';
    } else {
        Swal.fire({
            title: 'Error',
            text: 'Vehículo no encontrado',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

function updateCarrito() {
    const tbody = document.getElementById('carrito-tbody');
    tbody.innerHTML = '';

    total = 0;
    carrito.forEach((vehiculo, index) => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>${vehiculo.placa}</td>
            <td>${vehiculo.marca}</td>
            <td>${vehiculo.modelo}</td>
            <td>${vehiculo.año}</td>
            <td>${vehiculo.tipo}</td>
            <td>${vehiculo.kilometraje}</td>
            <td>${vehiculo.chasis}</td>
            <td>${vehiculo.motor}</td>
            <td><img src="${vehiculo.foto}" alt="Foto del vehículo" width="100" height="100"></td>
            <td>$${vehiculo.precio.toFixed(2)}</td>
            <td>$${vehiculo.subtotal.toFixed(2)}</td>
            <td>
                <button class="btn btn-danger" onclick="removeVehiculo(${index})">Eliminar</button>
            </td>
        `;

        tbody.appendChild(tr);
        total += vehiculo.subtotal;
    });

    document.getElementById('sub_total').innerText = total.toFixed(2);
    VALORIVA=parseInt( document.getElementById('valor_iva').value)/100;
    console.log(VALORIVA);
    const iva = total * VALORIVA;
    document.getElementById('iva').innerText = iva.toFixed(2);
    document.getElementById('total').innerText = (total + iva).toFixed(2);
}

// Función para eliminar un vehículo del carrito
function removeVehiculo(index) {
    carrito.splice(index, 1);
    updateCarrito();
}

// Función para mostrar las opciones de pago
function mostrarOpcionesPago() {
    const metodoPago = document.getElementById('metodo_pago').value;
    const opcionesPagoDiv = document.getElementById('opciones_pago');

    opcionesPagoDiv.innerHTML = '';

    if (metodoPago === 'tarjeta') {
        opcionesPagoDiv.innerHTML = `
            <div class="mb-3">
                <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                <input type="text" class="form-control" id="numero_tarjeta" required>
            </div>
            <div class="mb-3">
                <label for="fecha_expiracion" class="form-label">Fecha de Expiración:</label>
                <input type="text" class="form-control" id="fecha_expiracion" required>
            </div>
            <div class="mb-3">
                <label for="codigo_seguridad" class="form-label">Código de Seguridad:</label>
                <input type="text" class="form-control" id="codigo_seguridad" required>
            </div>
        `;
    } else if (metodoPago === 'transferencia') {
        opcionesPagoDiv.innerHTML = `
            <div class="mb-3">
                <label for="numero_comprobante" class="form-label">Número de Comprobante:</label>
                <input type="text" class="form-control" id="numero_comprobante" required>
            </div>
        `;
    } else if (metodoPago === 'credito') {
        opcionesPagoDiv.innerHTML = `
            <div class="mb-3">
                <label for="entrada" class="form-label">Entrada Inicial:</label>
                <input type="number" class="form-control" id="entrada" oninput="calcularFinanciamiento()" required>
            </div>
            <div class="mb-3">
                <label for="plazo" class="form-label">Plazo (meses):</label>
                <select class="form-control" id="plazo" onchange="calcularFinanciamiento()" required>
                    <option value="6">6</option>
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                    <option value="72">72</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="mb-3" id="plazo_otro_div" style="display: none;">
                <label for="plazo_otro" class="form-label">Otro Plazo (meses):</label>
                <input type="number" class="form-control" id="plazo_otro" oninput="calcularFinanciamiento()">
            </div>
            <div class="mb-3">
                <label for="cuota" class="form-label">Cuota Mensual:</label>
                <input type="text" class="form-control" id="cuota" readonly>
            </div>
        `;

        document.getElementById('plazo').addEventListener('change', function () {
            const plazo = this.value;
            document.getElementById('plazo_otro_div').style.display = plazo === 'otro' ? 'block' : 'none';
        });
    }
}

// Función para calcular el financiamiento
function calcularFinanciamiento() {
    const entrada = parseFloat(document.getElementById('entrada').value) || 0;
    const plazo = document.getElementById('plazo').value === 'otro' ? parseInt(document.getElementById('plazo_otro').value) : parseInt(document.getElementById('plazo').value);
    const total = parseFloat(document.getElementById('total').innerText) - entrada;
    const tasaInteres = 0.17; // 3% anual

    if (plazo && total) {
        const cuotaMensual = (total * (1 + tasaInteres)) / plazo;
        document.getElementById('cuota').value = cuotaMensual.toFixed(2);
    }
}


// Función para finalizar la compra
function finalizarCompra() {
    const vehiculos_json = [];
    const clienteId = document.getElementById('id_cliente').value;
    const metodoPago = document.getElementById('metodo_pago').value;
    const fecha = new Date().toISOString().slice(0, 10);
    const sub_total = parseFloat(document.getElementById('sub_total').innerText);
    total = parseFloat(document.getElementById('total').innerText);
    const opcionesPagoDiv = document.getElementById('opciones_pago');
    let datosPago = '';
    var datos_pago_json = '';
    carrito.forEach((vehiculo) => {
        vehiculos_json.push({ id: vehiculo.id });
    });
    if (metodoPago === 'efectivo') {
        datosPago = 'Efectivo';
        datos_pago_json = {
            'datos_efectivo': 'Efectivo'
        };
    } else if (metodoPago === 'tarjeta') {
        const numeroTarjeta = document.getElementById('numero_tarjeta').value;
        const fechaExpiracion = document.getElementById('fecha_expiracion').value;
        const codigoSeguridad = document.getElementById('codigo_seguridad').value;
        if (!numeroTarjeta || !fechaExpiracion || !codigoSeguridad) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, complete todos los campos de la tarjeta',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        datosPago = 'Tarjeta de Crédito';
        // 4 últimos dígitos de la tarjeta
        var ultimos4 = numeroTarjeta.slice(-4);
        datos_pago_json = {
            'datos_tarjeta': ultimos4,
            'fecha_expiracion': fechaExpiracion,
            'codigo_seguridad': codigoSeguridad
        };
    } else if (metodoPago === 'transferencia') {
        const numeroComprobante = document.getElementById('numero_comprobante').value;
        if (!numeroComprobante) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, ingrese el número de comprobante',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        datosPago = 'Transferencia - ' + numeroComprobante;
        datos_pago_json = {
            'numero_comprobante': numeroComprobante
        };
    } else if (metodoPago === 'credito') {
        const entrada = document.getElementById('entrada').value;
        const plazo = document.getElementById('plazo').value === 'otro' ? document.getElementById('plazo_otro').value : document.getElementById('plazo').value;
        const cuota = document.getElementById('cuota').value;
        if (!entrada || !plazo || !cuota) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, complete todos los campos de financiamiento',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        datosPago = `Financiamiento - Entrada: ${entrada}, Plazo: ${plazo} meses, Cuota: ${cuota}`;
        datos_pago_json = {
            'entrada': entrada,
            'plazo': plazo,
            'cuota': cuota
        };
    }

    datos_pago = JSON.stringify(datos_pago_json);
    var reth_vehiculos = JSON.stringify(vehiculos_json);

    // verificar si hay un cliente seleccionado
    if (!clienteId) {
        Swal.fire({
            title: 'Error',
            text: 'Seleccione un cliente',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }


    if (clienteId && carrito.length > 0) {
        const ventaData = {
            fecha,

            id_cliente: clienteId,
            tipo_pago: metodoPago,
            datos_pago: datos_pago,
            sub_total: sub_total,
            total: total,
            vehiculos: reth_vehiculos
        };

        fetch('/dashboard/ventas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(ventaData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Compra Finalizada',
                        text: 'La compra se ha realizado con éxito',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Limpia el formulario y el carrito
                        document.getElementById('cedula').value = '';
                        document.getElementById('vehiculo').value = '';
                        carrito = [];
                        updateCarrito();
                    });
                } else {
                    Swal.fire('Error al registrar la compra', '', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error al registrar la compra', '', 'error');
            });
    } else {
        Swal.fire({
            title: 'Error',
            text: 'Seleccione un cliente y agregue al menos un vehículo al carrito',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}
