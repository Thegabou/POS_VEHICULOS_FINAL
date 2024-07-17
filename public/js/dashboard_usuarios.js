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
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', filterUsuarios);
    attachSearchHandler();
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('verificarCorreoBtn').addEventListener('click', verificarCorreo);
});

function attachSearchHandler() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', filterUsuarios);
    }
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


function filterUsuarios() {
    const searchInput = document.getElementById('search');
    const searchValue = searchInput.value.toLowerCase();
    const tbody = document.getElementById('usuarios-tbody');
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const empleadoName = row.cells[1].textContent.toLowerCase();
        if (empleadoName.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Función para verificar correo electrónico
function verificarCorreo() {
    const correo = document.getElementById('correo').value;

    if (!correo) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, ingrese un correo electrónico.'
        });
        return;
    }

    fetch('/email/resend', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: correo })
        
    })
    .then(response => {console.log(response);})
    
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Correo enviado',
            text: 'Se ha enviado un correo de verificación. Por favor, revise su bandeja de entrada.'
        });
    })
    .catch(error => {
        
        console.error('Error al enviar el correo de verificación:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al enviar el correo de verificación. Por favor, inténtelo nuevamente.'
        });
    });
}
