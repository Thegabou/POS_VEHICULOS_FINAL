// Función para cargar contenido dinámicamente
function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachHandlers(); // Attach handlers after loading content
        })
        .catch(error => console.warn(error));
}

// Attach handlers for the form interactions
function attachHandlers() {
    // Poblar marcas y modelos
    fetch('/marcas')
        .then(response => response.json())
        .then(data => {
            const marcasList = document.getElementById('marcasList');
            data.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca;
                marcasList.appendChild(option);
            });
        });

    fetch('/modelos')
        .then(response => response.json())
        .then(data => {
            const modelosList = document.getElementById('modelosList');
            data.forEach(modelo => {
                const option = document.createElement('option');
                option.value = modelo;
                modelosList.appendChild(option);
            });
        });

    // Autocompletar proveedor
    document.getElementById('ruc').addEventListener('blur', function() {
        const ruc = this.value;
        fetch(`/proveedores/${ruc}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Proveedor no encontrado');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('nombre_proveedor').value = data.nombre;
                document.getElementById('correo_proveedor').value = data.correo;
                document.getElementById('telefono_proveedor').value = data.telefono;
                document.getElementById('direccion_proveedor').value = data.direccion;
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Proveedor no encontrado', '', 'error');
            });
    });

    // Agregar vehículo a la tabla
    document.getElementById('agregarVehiculo').addEventListener('click', function() {
        const marca = document.getElementById('marca').value;
        const modelo = document.getElementById('modelo').value;
        const precio = parseFloat(document.getElementById('precio_compra').value);
        const estado = document.getElementById('estado').value;
        const total = precio;

        const tableBody = document.getElementById('detalleVehiculos').querySelector('tbody');
        const row = tableBody.insertRow();
        row.innerHTML = `
            <td>${marca}</td>
            <td>${modelo}</td>
            <td>${precio.toFixed(2)}</td>
            <td>${estado}</td>
            <td>${total.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm eliminarVehiculo">Eliminar</button></td>
        `;

        updateTotal();

        row.querySelector('.eliminarVehiculo').addEventListener('click', function() {
            row.remove();
            updateTotal();
        });

        // Clear inputs
        document.getElementById('marca').value = '';
        document.getElementById('modelo').value = '';
        document.getElementById('precio_compra').value = '';
        document.getElementById('año_modelo').value = '';
        document.getElementById('precio_venta').value = '';
        document.getElementById('kilometraje').value = '';
        document.getElementById('tipo_vehiculo').value = '';
    });

    // Calcular total
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#detalleVehiculos tbody tr').forEach(row => {
            const totalRow = parseFloat(row.cells[4].textContent);
            total += totalRow;
        });
        document.getElementById('monto_final').value = total.toFixed(2);
    }

    // Manejar submit del formulario
    document.getElementById('detalleVehiculoForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData();
        const vehiculos = [];
        document.querySelectorAll('#detalleVehiculos tbody tr').forEach(row => {
            vehiculos.push({
                marca: row.cells[0].textContent,
                modelo: row.cells[1].textContent,
                precio: parseFloat(row.cells[2].textContent),
                estado: row.cells[3].textContent,
                total: parseFloat(row.cells[4].textContent)
            });
        });

        if (vehiculos.length === 0) {
            Swal.fire('No se puede crear la factura porque no hay datos para ingresar', '', 'error');
            return;
        }

        formData.append('num_factura', document.getElementById('num_factura').value);
        formData.append('ruc', document.getElementById('ruc').value);
        formData.append('nombre_proveedor', document.getElementById('nombre_proveedor').value);
        formData.append('correo_proveedor', document.getElementById('correo_proveedor').value);
        formData.append('telefono_proveedor', document.getElementById('telefono_proveedor').value);
        formData.append('direccion_proveedor', document.getElementById('direccion_proveedor').value);
        formData.append('fecha', document.getElementById('fecha').value);
        formData.append('vehiculos', JSON.stringify(vehiculos));

        fetch('/dashboard/compras', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire('Compra registrada exitosamente', '', 'success');
                document.getElementById('detalleVehiculoForm').reset();
                document.querySelector('#detalleVehiculos tbody').innerHTML = '';
                document.getElementById('monto_final').value = '';
            } else {
                Swal.fire('Error al registrar la compra', '', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error al registrar la compra', '', 'error');
        });
    });

    // Manejar cancelación
    document.getElementById('cancelarCompra').addEventListener('click', function() {
        document.getElementById('compraForm').reset();
        document.getElementById('detalleVehiculoForm').reset();
        document.querySelector('#detalleVehiculos tbody').innerHTML = '';
        document.getElementById('monto_final').value = '';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    attachHandlers();
});
