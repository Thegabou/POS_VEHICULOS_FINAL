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
                    }
                })
                .catch(error => console.error('Error:', error));
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
                        Swal.fire(
                            'Eliminado',
                            data.success,
                            'success'
                        ).then(() => {
                            loadContent('/dashboard/empleados');
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
}

function deleteUsuario(event, form) {
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
                        Swal.fire(
                            'Eliminado',
                            data.success,
                            'success'
                        ).then(() => {
                            loadContent('/dashboard/usuarios');
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
}

function attachSearchHandler() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const searchValue = searchInput.value;
            fetch(`/dashboard/usuarios?search=${searchValue}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTableBody = doc.querySelector('#usuarios-tbody');
                    document.querySelector('#usuarios-tbody').innerHTML = newTableBody.innerHTML;
                })
                .catch(error => console.warn(error));
        });
    }
}

function searchEmpleado() {
    const cedula = document.getElementById('cedula').value;
    fetch(`/usuarios/search-empleado?cedula=${cedula}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    title: 'Error',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                const empleadoSelect = document.getElementById('id_empleado');
                empleadoSelect.innerHTML = `<option value="${data.id}">${data.nombre} ${data.apellido} - ${data.cedula}</option>`;
                empleadoSelect.value = data.id;
            }
        })
        .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    const cedulaInput = document.getElementById('cedula');
    const empleadoSelect = document.getElementById('id_empleado');

    cedulaInput.addEventListener('input', function () {
        const cedula = cedulaInput.value;

        if (cedula.length >= 3) {
            fetch(`/usuarios/search-empleado?cedula=${cedula}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        empleadoSelect.innerHTML = '<option value="">Empleado no encontrado</option>';
                    } else {
                        empleadoSelect.innerHTML = `<option value="${data.id}">${data.nombre} ${data.apellido} - ${data.cedula}</option>`;
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            empleadoSelect.innerHTML = '<option value="">Seleccione un empleado</option>';
        }
    });
});