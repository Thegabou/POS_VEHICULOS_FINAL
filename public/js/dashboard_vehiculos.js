function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
        })
        .catch(error => console.warn(error));
}
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', filterVehiculos);
    attachSearchHandler();
});

function attachSearchHandler() {
    const searchValue = document.getElementById('search');
    if (searchValue) {
        searchValue.addEventListener('input', filterVehiculos);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('form-crear-vehiculo');
    if (createForm) {
        createForm.addEventListener('submit', handleSubmitCreate);
    }

    const editForm = document.getElementById('form-edit-vehiculo');
    if (editForm) {
        editForm.addEventListener('submit', handleSubmitEdit);
    }
});

function handleSubmitCreate(event) {
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
                title: '¡Éxito!',
                text: data.success,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '/vehiculos';
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al crear el vehículo. Por favor, inténtelo nuevamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error al crear el vehículo:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al crear el vehículo. Por favor, inténtelo nuevamente.',
        });
    });
}

function handleSubmitEdit(event) {
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
                title: 'Vehículo actualizado',
                text: data.success,
            }).then(() => {
                loadContent('/dashboard/vehiculos');
            });
        } else {
            throw new Error(data.error);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el vehículo:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar el vehículo. Por favor, inténtelo nuevamente.',
        });
    });
}

function filterVehiculos() {
    const searchValue = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('#vehiculos-tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchValue));
        row.style.display = match ? '' : 'none';
    });
}

function deleteVehiculo(event, form) {
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
            form.submit();
        }
    });
}
