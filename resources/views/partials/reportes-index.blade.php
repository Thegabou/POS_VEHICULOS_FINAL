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
        <div class="row">
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
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard_reportes.js') }}"></script>
