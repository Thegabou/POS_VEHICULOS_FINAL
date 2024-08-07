console.log('reportes_ventas.js');

function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
        })
        .catch(error => console.warn(error));
}


    document.getElementById('printDailyReportButton').addEventListener('click', generateDailyReport);
    document.getElementById('generateWeeklyReportButton').addEventListener('click', generateWeeklyReport);
    document.getElementById('generateMonthlyReportButton').addEventListener('click', generateMonthlyReport);


function generateDailyReport() {
    console.log('click');
    const date = document.getElementById('dailyDate').value;
    if (!date) {
        alert('Por favor seleccione una fecha.');
        return;
    }
    window.open(`/reportes/ventas-diarias/${date}`, '_blank');
}

function generateWeeklyReport() {
    const startDate = document.getElementById('weeklyStartDate').value;
    const endDate = document.getElementById('weeklyEndDate').value;
    if (!startDate || !endDate) {
        alert('Por favor seleccione un rango de fechas.');
        return;
    }
    window.open(`/reportes/ventas-semanales?start_date=${startDate}&end_date=${endDate}`, '_blank');
}

function generateMonthlyReport() {
    const month = document.getElementById('monthlySelect').value;
    if (!month) {
        alert('Por favor seleccione un mes.');
        return;
    }
    window.open(`/reportes/ventas-mensuales?month=${month}`, '_blank');
}
