

console.log('cargando dashboard_vehiculos.js');
function filterVehiculos() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById('vehiculos-tbody');
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        let found = false;
        const cols = rows[i].getElementsByTagName('td');
        for (let j = 0; j < cols.length - 1; j++) {  // -1 to skip the action column
            if (cols[j].textContent.toLowerCase().includes(filter)) {
                found = true;
                break;
            }
        }
        if (found) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}


//Funcion para crear un vehiculo
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('submit', function(event) {
        if (event.target.matches('#form-crear-vehiculo')) {
        console.log('formCrearVehiculo:', event.target);
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
                        title: 'Vehículo Creado',
                        text: 'El vehículo se ha creado con éxito.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        loadContent('/dashboard/vehiculos');
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
        }
    });

});

// Función para editar un vehículo
function attachFormHandlerVentas(){
    console.log('attachFormHandler vehiculos' );
    document.body.addEventListener('submit', function(event) {
        if (event.target.matches('#form-editar-vehiculo')) { // Asegúrate de que el ID del formulario sea correcto
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error || 'Hubo un problema al actualizar el vehículo. Por favor, inténtelo nuevamente.',
                    });
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