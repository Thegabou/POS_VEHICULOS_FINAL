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

// Función para adjuntar el manejador de búsqueda
function attachSearchHandler() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', filterProveedores);
    }
}

// Función para filtrar los proveedores
function filterProveedores() {
    const searchInput = document.getElementById('search');
    const searchValue = searchInput.value.toLowerCase();
    const tbody = document.getElementById('proveedores-tbody');
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        const nombre = cells[0].textContent.toLowerCase();
        const ruc = cells[1].textContent.toLowerCase();
        const telefono = cells[2].textContent.toLowerCase();
        const correo = cells[3].textContent.toLowerCase();
        const direccion = cells[4].textContent.toLowerCase();

        if (nombre.includes(searchValue) || ruc.includes(searchValue) || telefono.includes(searchValue) || correo.includes(searchValue) || direccion.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Función para crear un proveedor
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('submit', function(event) {
        if (event.target.matches('#form-crear-proveedor')) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Proveedor Creado',
                        text: 'El proveedor se ha creado con éxito.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        loadContent('/dashboard/proveedores');
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al crear el proveedor. Por favor, inténtelo nuevamente.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al crear el proveedor. Por favor, inténtelo nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
});

// Función para editar un proveedor
document.addEventListener('DOMContentLoaded', function () {
    const formEditProveedor = document.getElementById('form-edit-proveedor');
    if (formEditProveedor) {
        formEditProveedor.addEventListener('submit', function(event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const url = form.action;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Proveedor actualizado',
                        text: data.success,
                    }).then(() => {
                        loadContent('/dashborad/proveedores');
                    });
                } else {
                    throw new Error(data.error);
                }
            })
            .catch(error => {
                console.error('Error al actualizar el proveedor:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al actualizar el proveedor. Por favor, inténtelo nuevamente.',
                });
            });
        });
    }
});

// Función para eliminar un proveedor
function deleteProveedor(event, form) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro?',
        text: "No podrá revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = form.action;
            const token = form.querySelector('input[name="_token"]').value;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    '_token': token
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Eliminado',
                        text: data.success,
                        icon: 'success'
                    }).then(() => {
                        loadContent('/proveedores');
                    });
                } else {
                    throw new Error(data.error || 'Error desconocido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al eliminar el proveedor. Por favor, inténtelo nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}