function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
        })
        .catch(error => console.warn(error));
}

document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('submit', function (e) {
        if (e.target.matches('#form-create-empleado') || e.target.matches('#form-edit-empleado')) {
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
                            loadContent('/empleados');
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
            fetch(form.action, {
                method: 'DELETE',
                body: new FormData(form)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Eliminado',
                            data.success,
                            'success'
                        ).then(() => {
                            loadContent('/empleados');
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
}
