document.addEventListener('DOMContentLoaded', function() {
    attachSearchHandler();

    // Manejar la creación de un proveedor
    document.body.addEventListener('submit', function(event) {
        if (event.target.matches('#form-crear-proveedor')) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
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
                        loadContent('/proveedores');
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

    // Manejar la edición de un proveedor
    document.body.addEventListener('submit', function(event) {
        if (event.target.matches('#form-edit-proveedor')) {
            event.preventDefault();
            const form = event.target;
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
                        loadContent('/proveedores');
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
        }
    });

    // Filtrar proveedores
    document.getElementById('search').addEventListener('input', function() {
        filterProveedores();
    });
});

// Función para cargar contenido
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
    const searchValue = document.getElementById('search');
    if (searchValue) {
        searchValue.addEventListener('input', filterProveedores);
    }
}

// Función para filtrar los proveedores
function filterProveedores() {
    const searchValue = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('#proveedores-tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchValue));
        row.style.display = match ? '' : 'none';
    });
}

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
