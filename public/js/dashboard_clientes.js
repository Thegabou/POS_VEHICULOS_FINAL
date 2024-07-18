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
    document.getElementById('form-crear-cliente').addEventListener('submit', function(event) {
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
                    title: 'Cliente Creado',
                    text: 'El cliente se ha creado con éxito.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '/clientes';
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al crear el cliente. Por favor, inténtelo nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al crear el cliente. Por favor, inténtelo nuevamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});

document.getElementById('form-edit-cliente').addEventListener('submit', function(event) {
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
                title: 'Cliente actualizado',
                text: data.success,
            }).then(() => {
                loadContent('/dashboard/clientes');
            });
        } else {
            throw new Error(data.error);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el cliente:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar el cliente. Por favor, inténtelo nuevamente.',
        });
    });
});



function attachSearchHandler() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', filterClientes);
    }
}

function deleteCliente(event, form) {
    event.preventDefault();

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

function filterClientes() {
    const search = document.getElementById('search').value.toLowerCase();
    const tbody = document.getElementById('clientes-tbody');
    const rows = tbody.getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const nombre = row.cells[0].textContent.toLowerCase();
        const apellido = row.cells[1].textContent.toLowerCase();
        const correo = row.cells[2].textContent.toLowerCase();
        const cedula = row.cells[3].textContent.toLowerCase();
        const numeroTelefono = row.cells[4].textContent.toLowerCase();

        if (nombre.includes(search) || apellido.includes(search) || correo.includes(search) || cedula.includes(search) || numeroTelefono.includes(search)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


