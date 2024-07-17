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

document.addEventListener('DOMContentLoaded', function () {
    const searchInputEmpleado = document.getElementById('search-empleado');
    searchInputEmpleado.addEventListener('input', filterEmpleados);
    attachSearchHandler();
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




function attachSearchHandler() {
    const searchInputEmpleado = document.getElementById('search');
    if (searchInputEmpleado) {
        searchInputEmpleado.addEventListener('input', filterEmpleados);
    }
}



function filterEmpleados() {
    const searchInput = document.getElementById('search');
    const searchValue = searchInput.value.toLowerCase();
    const tbody = document.getElementById('empleados-tbody');
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const nombre = row.cells[0].textContent.toLowerCase();
        const apellido = row.cells[1].textContent.toLowerCase();
        const correo = row.cells[2].textContent.toLowerCase();
        const cedula = row.cells[3].textContent.toLowerCase();
        const cargo = row.cells[4].textContent.toLowerCase();

        if (nombre.includes(searchValue) || apellido.includes(searchValue) || correo.includes(searchValue) || cedula.includes(searchValue) || cargo.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
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
    const createButton = document.querySelector('button[type="submit"]');

    cedulaInput.addEventListener('input', function () {
        const cedula = cedulaInput.value.trim();
        let found = false;

        for (let i = 0; i < empleadoSelect.options.length; i++) {
            const option = empleadoSelect.options[i];
            if (option.text.includes(cedula)) {
                option.style.display = '';
                found = true;
            } else {
                option.style.display = 'none';
            }
        }

        if (!found) {
            Swal.fire({
                title: 'No encontrado',
                text: 'No se encontró ningún empleado con esa cédula.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            const noResultsOption = document.createElement('option');
            noResultsOption.text = 'Sin resultados';
            noResultsOption.disabled = true;
            noResultsOption.style.color = 'red';
            empleadoSelect.appendChild(noResultsOption);
            empleadoSelect.style.borderColor = 'red';
            createButton.disabled = true;
        } else {
            empleadoSelect.style.borderColor = '';
            createButton.disabled = false;
        }
    });
});




