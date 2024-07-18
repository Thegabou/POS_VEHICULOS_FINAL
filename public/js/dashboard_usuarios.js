function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler1();
            
        })
        .catch(error => console.warn(error));
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', filterUsuarios);
    attachSearchHandler1();
});


function attachSearchHandler1() {
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

