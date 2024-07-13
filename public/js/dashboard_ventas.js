function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
            
        })
        .catch(error => console.warn(error));
}

let carrito = [];
let total = 0;

function buscarCliente() {
    const cedula = document.getElementById('cedula').value;
    console.log(cedula);
    if (cedula.length > 0) {
        axios.get('/clientes/buscar/' + cedula)
            .then(response => {
                if (response.data) {
                    document.getElementById('nombre_apellido').value = response.data.nombre + ' ' + response.data.apellido;
                    document.getElementById('telefono').value = response.data.numero_telefono;
                    document.getElementById('correo').value = response.data.correo;
                    document.getElementById('nombre_apellido').disabled = true;
                    document.getElementById('telefono').disabled = true;
                    document.getElementById('correo').disabled = true;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cliente no encontrado',
                        text: 'No se encontró ningún cliente con esa cédula',
                    });
                }
            });
    } else {
        document.getElementById('nombre_apellido').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('correo').value = '';
        document.getElementById('nombre_apellido').disabled = false;
        document.getElementById('telefono').disabled = false;
        document.getElementById('correo').disabled = false;
    }
}

function addVehicle() {
    const vehiculoInput = document.getElementById('vehiculo');
    const vehiculoId = vehiculoInput.value;
    const vehiculoOption = document.querySelector(`#vehiculosList option[value="${vehiculoId}"]`);
    if (vehiculoOption) {
        const vehiculoData = vehiculoOption.innerText.split(' - ');
        const vehiculoNombre = vehiculoData[0];
        const vehiculoPrecio = parseFloat(vehiculoData[1].substring(1));

        const vehiculo = {
            id: vehiculoId,
            nombre: vehiculoNombre,
            precio: vehiculoPrecio,
            cantidad: 1,
            subtotal: vehiculoPrecio
        };

        carrito.push(vehiculo);
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
    carrito.forEach(vehiculo => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>${vehiculo.nombre}</td>
            <td>${vehiculo.cantidad}</td>
            <td>$${vehiculo.precio.toFixed(2)}</td>
            <td>$${vehiculo.subtotal.toFixed(2)}</td>
            <td><button class="btn btn-danger" onclick="removeVehicle('${vehiculo.id}')">Eliminar</button></td>
        `;

        tbody.appendChild(tr);
        total += vehiculo.subtotal;
    });

    document.getElementById('total').innerText = total.toFixed(2);
}

function removeVehicle(id) {
    carrito = carrito.filter(vehiculo => vehiculo.id !== id);
    updateCarrito();
}

function finalizarCompra() {
    const clienteId = document.getElementById('cliente').value;
    const metodoPago = document.getElementById('metodo_pago').value;

    if (clienteId && carrito.length > 0) {
        // Simulate a call to backend to finalize the purchase
        Swal.fire({
            title: 'Compra Finalizada',
            text: 'La compra se ha realizado con éxito',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            // Clear the form and carrito
            document.getElementById('cliente').value = '';
            document.getElementById('vehiculo').value = '';
            carrito = [];
            updateCarrito();
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