document.addEventListener('DOMContentLoaded', function() {
    const vehiculosDataElement = document.getElementById('vehiculosData');
    const vehiculos = JSON.parse(vehiculosDataElement.textContent);
    
    let vehiculoIndex = 1;

    function vehiculosOptions() {
        let options = '';
        vehiculos.forEach(vehiculo => {
            options += `<option value="${vehiculo.id}">${vehiculo.marca} ${vehiculo.modelo}</option>`;
        });
        return options;
    }

    function addRow() {
        const table = document.getElementById('vehiculos-table').getElementsByTagName('tbody')[0];
        const row = table.insertRow();
        row.innerHTML = `
            <td>
                <select class="form-control" name="vehiculos[${vehiculoIndex}][id_vehiculo]" required>
                    ${vehiculosOptions()}
                </select>
            </td>
            <td>
                <input type="number" class="form-control" name="vehiculos[${vehiculoIndex}][cantidad]" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button>
            </td>
        `;
        vehiculoIndex++;
    }

    document.getElementById('addRowButton').addEventListener('click', addRow);

    window.removeRow = function(button) {
        const row = button.closest('tr');
        row.remove();
    };
});
