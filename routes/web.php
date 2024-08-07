<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CompraVehiculoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaVehiculoController;
use App\Http\Controllers\VendedorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompraPaginaWeb;
use App\Http\Controllers\CompraPaginaWebController;
use App\Http\Controllers\ReporteVehiculosController;
use App\Http\Controllers\ReporteClientesController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\GlobalVariableController;
use App\Http\Controllers\VentasReportesController;
use App\Http\Controllers\MarcasModelosController;


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('clientes', ClienteController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('vehiculos', VehiculoController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('compras', CompraController::class);
Route::resource('facturas', FacturaController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('venta_vehiculos', VentaVehiculoController::class);
Route::resource('vendedores', VendedorController::class);
Route::resource('compra_vehiculos', CompraVehiculoController::class);
Route::resource('reportes-index', ReporteVehiculosController::class);




Route::get('/', [VehiculoController::class, 'welcome'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/creacion-usuarios', [DashboardController::class, 'creacionUsuarios'])->name('creacion-usuarios');
    Route::get('dashboard/empleados', [DashboardController::class, 'Empleados'])->name('empleados');
    Route::get('dashboard/usuarios', [DashboardController::class, 'Usuarios'])->name('usuarios');
    Route::get('usuarios/search-empleado', [UsuarioController::class, 'searchEmpleado'])->name('usuarios.search-empleado');
    Route::get('vendedor/punto_venta', [VendedorController::class, 'punto_Ventas'])->name('punto_venta');
    Route::get('vendedor/buscar-cliente/{cedula}', [ClienteController::class, 'buscarCliente'])->name('buscar-cliente');
    Route::get('dashboard/clientes', [DashboardController::class, 'Clientes'])->name('clientes');
    Route::get('dashboard/vehiculos', [DashboardController::class, 'Vehiculos'])->name('vehiculos');
    Route::get('dashboard/proveedores', [DashboardController::class, 'Proveedores'])->name('proveedores');
    Route::get('vehiculo/marcas', [VehiculoController::class, 'getMarcas'])->name('vehiculo.marcas');
    Route::get('vehiculo/modelos/{idMarca}', [VehiculoController::class, 'getModelosByMarca'])->name('vehiculo.modelos');
    Route::get('compra/buscar-proveedor/{ruc}', [ProveedorController::class, 'getByRuc'])->name('buscar-proveedor');
    Route::get('dashboard/compras', [CompraController::class, 'index'])->name('dashboard.compras');
    Route::post('dashboard/compras', [CompraController::class, 'store'])->name('compras.store');
    ///dashboard/ventas
    Route::get('dashboard/ventas', [FacturaController::class, 'index'])->name('dashboard.ventas');
    Route::post('dashboard/ventas', [FacturaController::class, 'store'])->name('venta.store');
    Route::get('/reportes/entradas', [ReporteVehiculosController::class, 'entradas'])->name('reportes.entradas');
    Route::get('/reportes/salidas', [ReporteVehiculosController::class, 'salidas'])->name('reportes.salidas');
    Route::get('/reportes/mas-vendidos', [ReporteVehiculosController::class, 'masVendidos'])->name('reportes.masVendidos');
    Route::get('/reportes/menos-vendidos', [ReporteVehiculosController::class, 'menosVendidos'])->name('reportes.menosVendidos');
    Route::get('dashboard/reportes-index', [ReporteVehiculosController::class, 'index'])->name('reportes');
    Route::get('/clientes/{clienteId}/historial-compras', [ReporteClientesController::class, 'historialCompras'])->name('clientes.historialCompras');
    Route::get('/clientes/{clienteId}/generar-reportes', [ReporteClientesController::class, 'generarReportes'])->name('clientes.generarReportes');
    Route::get('/reportes/ventas-diarias/{date}', [VentasReportesController::class, 'ventasDiarias'])->name('ventasDiarias');
    Route::get('/reportes/ventas-semanales', [VentasReportesController::class, 'ventasSemanales'])->name('reportes.ventasSemanales');
    Route::get('/reportes/ventas-mensuales', [VentasReportesController::class, 'ventasMensuales'])->name('reportes.ventasMensuales');
    Route::get('/marcas_modelos', [MarcasModelosController::class, 'index'])->name('marcasModelos.index');
    Route::post('/marcas', [MarcasModelosController::class, 'storeMarca'])->name('marcas.store');
    Route::post('/modelos', [MarcasModelosController::class, 'storeModelo'])->name('modelos.store');
    //ruta para editar modelos
    Route::get('/modelos/{id}/edit', [MarcasModelosController::class, 'editModelo'])->name('modelos.edit');
    //ruta para eliminar modelos
    Route::delete('/modelos/{id}', [MarcasModelosController::class, 'destroyModelo'])->name('modelos.destroy');
    Route::get('/marcas/buscar', [MarcasModelosController::class, 'searchMarcas'])->name('marcas.search');

    //obtener modelos por marca
    Route::get('vehiculo/modelos/{idMarca}', [VehiculoController::class, 'getModelosByMarca'])->name('vehiculo.modelos');
    Route::controller(ImagenController::class)->group(function(){
        Route::get('/image-upload', 'index')->name('image.form');
        Route::post('/upload-image', 'storeImage')->name('image.store');
    });
    Route::get('/dashboard/reportes-ventas', [VentasReportesController::class, 'index'])->name('reportes.ventas');


    
});    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [VehiculoController::class, 'welcome'])->name('welcome');
Route::resource('ventas', VentaVehiculoController::class)->middleware('auth');
//ruta para compra de vehiculo con parametro id-vehiculo
Route::get('/compra-vehiculo/{id}', [CompraPaginaWebController::class, 'index'])->name('compra-vehiculo.index');
Route::post('/compra-vehiculo/store', [CompraPaginaWebController::class, 'store'])->name('compra-vehiculo.store');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.emails');
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

Route::get('/submint-new-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/submint-new-password', [PasswordResetController::class, 'reset'])->name('password.updates');

Route::get('/global-variables', [GlobalVariableController::class, 'index'])->name('global_variables.index');
Route::post('/global-variables', [GlobalVariableController::class, 'store'])->name('global_variables.store');
Route::delete('/global-variables/{key}', [GlobalVariableController::class, 'destroy'])->name('global_variables.destroy');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');




require __DIR__.'/auth.php';
