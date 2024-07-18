console.log('dashboard_index.js loaded');
document.addEventListener('DOMContentLoaded', function () {
    attachSearchHandler();
});

function attachSearchHandler() {
    const searchEmpleado = document.getElementById('search-empleados');
    console.log('searchEmpleadosearchEmpleado1:', searchEmpleado);
    if (searchEmpleado) {
        searchEmpleado.addEventListener('input', filterEmpleados);
        console.log('searchEmpleadosearchEmpleado2:', searchEmpleado);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('submit', function (e) {
        if (e.target.matches('#form-create-empleado') || e.target.matches('#form-edit-empleado') || e.target.matches('#form-create-usuario') || e.target.matches('#form-edit-usuario')) {
            e.preventDefault();
            const form = e.target;
            const url = form.action;
            const formData = new FormData(form);

            fetch(url, {
                method: form.method,
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: data.success,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (form.matches('#form-create-empleado') || form.matches('#form-edit-empleado')) {
                                loadContent('/dashboard/empleados');
                            } else if (form.matches('#form-create-usuario') || form.matches('#form-edit-usuario')) {
                                loadContent('/dashboard/usuarios');
                            }
                        });
                    } else {
                        throw new Error(data.error || 'Error desconocido');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema. Por favor, inténtelo nuevamente.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }
    });
});

function deleteEmpleado(event, form) {
    event.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo'
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
                            loadContent('/dashboard/empleados');
                        });
                    } else {
                        throw new Error(data.error || 'Error desconocido');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al eliminar el empleado. Por favor, inténtelo nuevamente.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }
    });
}

function filterEmpleados() {
    const searchEmpleados = document.getElementById('search-empleados');
    const searchValue = searchEmpleados.value.toLowerCase();
    const tbody = document.getElementById('empleados-tbody');
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        const nombre = cells[0].textContent.toLowerCase();
        const apellido = cells[1].textContent.toLowerCase();
        const correo = cells[2].textContent.toLowerCase();
        const cedula = cells[3].textContent.toLowerCase();
        const cargo = cells[4].textContent.toLowerCase();

        if (nombre.includes(searchValue) || apellido.includes(searchValue) || correo.includes(searchValue) || cedula.includes(searchValue) || cargo.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}
