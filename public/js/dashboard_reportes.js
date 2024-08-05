document.addEventListener('DOMContentLoaded', function () {
    var vehiculosMasVendidosData = JSON.parse(document.getElementById('vehiculosMasVendidosData').textContent);
    var vendedoresMasVentasData = JSON.parse(document.getElementById('vendedoresMasVentasData').textContent);

    // Data processing for Highcharts
    var vehiculosMasVendidosLabels = vehiculosMasVendidosData.map(function (vehiculo) {
        return vehiculo.marca + ' ' + vehiculo.modelo;
    });
    var vehiculosMasVendidosCounts = vehiculosMasVendidosData.map(function (vehiculo) {
        return vehiculo.total_vendidos;
    });

    var vendedoresMasVentasLabels = vendedoresMasVentasData.map(function (vendedor) {
        return vendedor.nombre;
    });
    var vendedoresMasVentasCounts = vendedoresMasVentasData.map(function (vendedor) {
        return vendedor.total_ventas;
    });

    // Vehículos Más Vendidos Chart
    Highcharts.chart('vehiculosMasVendidosChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Vehículos Más Vendidos'
        },
        xAxis: {
            categories: vehiculosMasVendidosLabels,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Vendidos'
            }
        },
        series: [{
            name: 'Vehículos',
            data: vehiculosMasVendidosCounts,
            color: '#7cb5ec'
        }]
    });

    // Vendedores con Más Ventas Chart
    Highcharts.chart('vendedoresMasVentasChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Vendedores con Más Ventas'
        },
        xAxis: {
            categories: vendedoresMasVentasLabels,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Ventas'
            }
        },
        series: [{
            name: 'Vendedores',
            data: vendedoresMasVentasCounts,
            color: '#90ed7d'
        }]
    });

    
});

function generateDailyReport() {
    const date = document.getElementById('dailyReportDate').value;
    if (date) {
        window.location.href = `/reportes/ventas-diarias?date=${date}`;
    } else {
        alert('Por favor, seleccione una fecha.');
    }
}

function generateWeeklyReport() {
    const startDate = document.getElementById('weeklyReportStartDate').value;
    const endDate = document.getElementById('weeklyReportEndDate').value;
    if (startDate && endDate) {
        window.location.href = `/reportes/ventas-semanales?start_date=${startDate}&end_date=${endDate}`;
    } else {
        alert('Por favor, seleccione las fechas de inicio y fin.');
    }
}

function generateMonthlyReport() {
    const month = document.getElementById('monthlyReportMonth').value;
    window.location.href = `/reportes/ventas-mensuales?month=${month}`;
}
