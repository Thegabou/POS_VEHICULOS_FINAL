// public/js/marcas_modelos.js

document.getElementById('buscarMarca').addEventListener('input', function() {
    const query = this.value;

    if (query.length >= 2) {
        fetch(`/marcas/buscar?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const suggestions = document.getElementById('marcaSuggestions');
                suggestions.innerHTML = '';
                data.forEach(marca => {
                    const suggestion = document.createElement('div');
                    suggestion.classList.add('list-group-item', 'list-group-item-action');
                    suggestion.textContent = marca.nombre;
                    suggestion.dataset.id = marca.id;
                    suggestion.addEventListener('click', function() {
                        document.getElementById('buscarMarca').value = this.textContent;
                        document.getElementById('marcaId').value = this.dataset.id;
                        suggestions.innerHTML = '';
                    });
                    suggestions.appendChild(suggestion);
                });
            });
    }
});

function deleteModelo(event, form) {
    event.preventDefault();
    if (confirm('¿Estás seguro de que deseas eliminar este modelo?')) {
        form.submit();
    }
}
