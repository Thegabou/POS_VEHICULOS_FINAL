document.addEventListener('DOMContentLoaded', function () {
    var masVendidosCardBody = document.getElementById('masVendidosCardBody');
    var menosVendidosCardBody = document.getElementById('menosVendidosCardBody');
    var entradasCardBody = document.getElementById('entradasCardBody');
    var salidasCardBody = document.getElementById('salidasCardBody');

    var vehiculosMasVendidos = JSON.parse(document.getElementById('vehiculosMasVendidosData').textContent);
    var vehiculosMenosVendidos = JSON.parse(document.getElementById('vehiculosMenosVendidosData').textContent);

    var labelsMasVendidos = vehiculosMasVendidos.map(function (vehiculo) {
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

    // Insertar datos en los card-body
    masVendidosCardBody.innerHTML = labelsMasVendidos.map(function(label, index) {
        return `<p>${label}: ${dataMasVendidos[index]} vendidos</p>`;
    }).join('');

    menosVendidosCardBody.innerHTML = labelsMenosVendidos.map(function(label, index) {
        return `<p>${label}: ${dataMenosVendidos[index]} vendidos</p>`;
    }).join('');

    // Gráficos
    var ctxMasVendidos = document.getElementById('myAreaChart').getContext('2d');
    var ctxMenosVendidos = document.getElementById('myBarChart').getContext('2d');

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
});
