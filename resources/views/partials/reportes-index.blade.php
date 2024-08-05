<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Reportes Generales</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Vehículos Más Vendidos</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('reportes.masVendidos') }}">Descargar PDF!</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Vehículos Menos Vendidos</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('reportes.menosVendidos') }}">Descargar PDF!</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Ingresos de Vehículos</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('reportes.entradas') }}">Descargar PDF!</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Salida de Vehículos</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('reportes.salidas') }}">Descargar PDF!</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- New Container for Report Generation -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-file-alt me-1"></i>
                        Generar Reportes
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Daily Report -->
                            <div class="col-md-4">
                                <h5>Ventas Diarias</h5>
                                <input type="date" id="dailyDate" class="form-control mb-2">
                                <button id="generateDailyReportButton" class="btn btn-primary mb-2">Ver Reporte</button>
                                <button id="printDailyReportButton" class="btn btn-secondary mb-2" href="{{route('reportes.ventasDiarias')}}" onclick="generateDailyReport()">Imprimir PDF</button>
                            </div>
                            <!-- Weekly Report -->
                            <div class="col-md-4">
                                <h5>Ventas Semanales</h5>
                                <input type="date" id="weeklyStartDate" class="form-control mb-2" placeholder="Fecha de inicio">
                                <input type="date" id="weeklyEndDate" class="form-control mb-2" placeholder="Fecha de fin">
                                <button id="generateWeeklyReportButton" class="btn btn-primary mb-2">Ver Reporte</button>
                                <button id="printWeeklyReportButton" class="btn btn-secondary mb-2" hrerf="{{route('reportes.ventasSemanales')}}" onclick="generateWeeklyReport()">Imprimir PDF</button>
                            </div>
                            <!-- Monthly Report -->
                            <div class="col-md-4">
                                <h5>Ventas Mensuales</h5>
                                <select id="monthlySelect" class="form-control mb-2">
                                    <option value="">Seleccione un mes</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <button id="generateMonthlyReportButton" class="btn btn-primary mb-2">Ver Reporte</button>
                                <button id="printMonthlyReportButton" class="btn btn-secondary mb-2" href="{{route('reportes.ventasMensuales')}}" >Imprimir PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Vehículos Más Vendidos
                    </div>
                    <div class="card-body">
                        <canvas id="myAreaChart" width="100%" height="40"></canvas>
                        <script id="vehiculosMasVendidosData" type="application/json">
                            {!! json_encode($masVendidos) !!}
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Vehículos Menos Vendidos
                    </div>
                    <div class="card-body">
                        <canvas id="myBarChart" width="100%" height="40"></canvas>
                        <script id="vehiculosMenosVendidosData" type="application/json">
                            {!! json_encode($menosVendidos) !!}
                        </script>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/reportes_ventas.js') }}"></script>
<script src="{{asset('js/dashboard_reportes.js')}}"></script>
