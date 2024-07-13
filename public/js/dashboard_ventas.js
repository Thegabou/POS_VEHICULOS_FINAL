// Función para cargar contenido dinámicamente
function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
        })
        .catch(error => console.warn(error));
}

document.addEventListener('DOMContentLoaded', function () {
    const cedulaInput = document.getElementById('cedula');
    cedulaInput.addEventListener('input', buscarCliente);
});

// Variables globales para el carrito
let carrito = [];
let total = 0;

// function attachSearchHandler() {
//     const cedulaInput = document.getElementById('cedula');
//     if (cedulaInput) {
//         cedulaInput.addEventListener('input', buscarCliente);
//     }
// }
// Función para buscar cliente por cédula
function buscarCliente() {
    const cedula = document.getElementById('cedula').value;
    console.log(cedula);
    if (cedula.length > 0) {
        const form = document.getElementById('form-buscar-cliente');
        const url = "/vendedor/buscar-cliente/" + cedula;
        const formData = new FormData(form);
        console.log(url);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('nombre_apellido').value = data.nombre + ' ' + data.apellido;
                    document.getElementById('telefono').value = data.numero_telefono;
                    document.getElementById('correo').value = data.correo;
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
        document.getElementById('nombre_apellido').disabled = false;
        document.getElementById('telefono').disabled = false;
        document.getElementById('correo').disabled = false;
    }
}

// Función para agregar un vehículo al carrito
function addVehiculo() {
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

// Función para actualizar el carrito
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
            <td>
                <button class="btn btn-danger" onclick="removeVehiculo('${vehiculo.id}')">Eliminar</button>
                <button class="btn btn-warning" onclick="editVehiculo('${vehiculo.id}')">Editar</button>
            </td>
        `;

        tbody.appendChild(tr);
        total += vehiculo.subtotal;
    });

    document.getElementById('sub_total').innerText = total.toFixed(2);
    const iva = total * 0.15;
    document.getElementById('iva').innerText = iva.toFixed(2);
    document.getElementById('total').innerText = (total + iva).toFixed(2);
}

// Función para eliminar un vehículo del carrito
function removeVehiculo(id) {
    carrito = carrito.filter(vehiculo => vehiculo.id !== id);
    updateCarrito();
}

// Función para editar un vehículo del carrito
function editVehiculo(id) {
    const vehiculo = carrito.find(vehiculo => vehiculo.id === id);
    if (vehiculo) {
        // Implementa la lógica para editar el vehículo
        // Por ejemplo, podrías mostrar un modal con un formulario para editar la cantidad y el precio
    }
}

// Función para finalizar la compra
function finalizarCompra() {
    const clienteId = document.getElementById('cedula').value;
    const metodoPago = document.getElementById('metodo_pago').value;

    if (clienteId && carrito.length > 0) {
        // Simula una llamada al backend para finalizar la compra
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
        Swal.fire({
            title: 'Error',
            text: 'Seleccione un cliente y agregue al menos un vehículo al carrito',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}
