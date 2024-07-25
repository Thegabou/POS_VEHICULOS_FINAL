window.onload = function() {
    var vehiculosMasVendidos = JSON.parse(document.getElementById('vehiculosMasVendidosData').textContent);
    var vehiculosMenosVendidos = JSON.parse(document.getElementById('vehiculosMenosVendidosData').textContent);

    var masVendidosContainer = document.getElementById('masVendidosContainer');
    var menosVendidosContainer = document.getElementById('menosVendidosContainer');

    vehiculosMasVendidos.forEach(function(vehiculo) {
        var card = document.createElement('div');
        card.className = 'card bg-primary text-white mb-4';
        card.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${vehiculo.marca} ${vehiculo.modelo}</h5>
                <p class="card-text">Total vendidos: ${vehiculo.total_vendidos}</p>
            </div>
        `;
        masVendidosContainer.appendChild(card);
    });

    vehiculosMenosVendidos.forEach(function(vehiculo) {
        var card = document.createElement('div');
        card.className = 'card bg-warning text-white mb-4';
        card.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${vehiculo.marca} ${vehiculo.modelo}</h5>
                <p class="card-text">Total vendidos: ${vehiculo.total_vendidos}</p>
            </div>
        `;
        menosVendidosContainer.appendChild(card);
    });

    var labelsMasVendidos = vehiculosMasVendidos.map(function(vehiculo) {
        return vehiculo.marca + ' ' + vehiculo.modelo;
    });
    var dataMasVendidos = vehiculosMasVendidos.map(function (vehiculo) {
        return vehiculo.total_vendidos;
    });

    var labelsMenosVendidos = vehiculosMenosVendidos.map(function (vehiculo) {
        return vehiculo.marca + ' ' + vehiculo.modelo;
    });
    var dataMenosVendidos = vehiculosMenosVendidos.map(function (vehiculo) {
        return vehiculo.total_vendidos;
    });

    var ctxMasVendidos = document.getElementById('myAreaChart').getContext('2d');
    var myAreaChart = new Chart(ctxMasVendidos, {
        type: 'line',
        data: {
            labels: labelsMasVendidos,
            datasets: [{
                label: 'Vehículos más vendidos',
                data: dataMasVendidos,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxMenosVendidos = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctxMenosVendidos, {
        type: 'bar',
        data: {
            labels: labelsMenosVendidos,
            datasets: [{
                label: 'Vehículos menos vendidos',
                data: dataMenosVendidos,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};
