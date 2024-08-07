<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard-Ventas</title>
    <link rel="shortcut icon" href="{{asset('imagenes/logo_barra.png')}}" type="image/png">
    <link rel="apple-touch-icon" href="{{asset('imagenes/logo_barra.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('css/styles_system.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="{{ route('dashboard') }}">Groundhog</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="#" onclick="loadContent('{{ route('punto_venta') }}')">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                            Punta de Venta
                        </a>
                        <a class="nav-link" href="#" onclick="loadContent('{{ route('dashboard.compras') }}')">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-file-invoice"></i></div>
                            Ingresar Facturas
                        </a>
                        <a class="nav-link" href="#" onclick="loadContent('{{ route('clientes') }}')">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link" href="#" onclick="loadContent('{{ route('vehiculos') }}')">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                            Vehiculos
                        </a>
                        <a class="nav-link" href="#" onclick="loadContent('{{ route('proveedores') }}')">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-parachute-box"></i></div>
                            Proveedores
                        </a>
                        <!-- Otros elementos del menú -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Iniciaste Sesion en:</div>
                    Groundhog
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4" id="main-content">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; GROUNDHOGDRIVER 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/scripts_system.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="{{asset('js/utilis.js')}}"></script> 
    <script src="{{asset('js/dashboard_proveedor.js')}}"></script>
    <script src="{{asset('js/dashboard_compra.js')}}"></script>
    <script src="{{asset('js/dashboard_clientes.js')}}"></script>
    <script src="{{ asset('js/dashboard_ventas.js') }}"></script>
    <script src="{{asset('js/dashboard_vehiculos.js')}}"></script>
    <script src="{{asset('js/utilis.js')}}"></script>
    <--!cargar la vista de punto_venta por defecto-->
   <script>
    function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
            try {
                attachFormHandlerVentas();
                attachFormHandlerClientes();
                
            } catch (error) {
                console.warn('No se encontró la función attachFormHandler');
            }

        })
        .catch(error => console.warn(error));
}
   </script>
   <script>
        loadContent('{{ route('punto_venta') }}');  
    </script>
    
</body>
</html>
