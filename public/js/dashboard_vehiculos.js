//
function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
        })
        .catch(error => console.warn(error));
}
//Funcion para filtrar los vehiculos
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', filterVehiculos);
    }
    attachSearchHandler();
});
//Funcion para adjuntar el manejador de busqueda
function attachSearchHandler() {
    const searchValue = document.getElementById('search');
    if (searchValue) {
        searchValue.addEventListener('input', filterVehiculos);
    }
}
//Funcion para crear un vehiculo
document.addEventListener('DOMContentLoaded', function () {
    const formCrearVehiculo = document.getElementById('form-crear-vehiculo');
    if (formCrearVehiculo) {
        console.log('formCrearVehiculo:', formCrearVehiculo);
        formCrearVehiculo.addEventListener('submit', function(event) {
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
                        title: 'Vehículo Creado',
                        text: 'El vehículo se ha creado con éxito.',
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
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al crear el vehículo. Por favor, inténtelo nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});

//Funcion para editar un vehiculo
document.addEventListener('DOMContentLoaded', function () {
    const formEditVehiculo = document.getElementById('form-edit-vehiculo');
    if (formEditVehiculo) {
        formEditVehiculo.addEventListener('submit', function(event) {
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
        });
    }
});


//Funcion para filtrar los vehiculos
function filterVehiculos() {
    const searchValue = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('#vehiculos-tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchValue));
        row.style.display = match ? '' : 'none';
    });
}

//Funcion para eliminar un vehiculo
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
                        loadContent('/dashboard/vehiculos');
                    });
                } else {
                    throw new Error(data.error || 'Error desconocido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al eliminar el vehículo. Por favor, inténtelo nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}