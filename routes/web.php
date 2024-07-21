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
use App\Http\Controllers\InventarioController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::resource('compra_vehiculos', CompraVehiculoController::class);
Route::resource('venta_vehiculos', VentaVehiculoController::class);



Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('vehiculo/marcas', [VehiculoController::class, 'getMarcas'])->name('marcas');
    Route::get('/modelos', [VehiculoController::class, 'getModelos'])->name('modelos');
    Route::get('compra/buscar-proveedor/{ruc}', [ProveedorController::class, 'getByRuc'])->name('buscar-proveedor');
    Route::get('dashboard/compras', [CompraController::class, 'index'])->name('dashboard.compras');
    Route::post('/dashboard/compras', [CompraController::class, 'store'])->name('compras.store');
});    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('compra',[CompraController::class, 'index'])->name('compras');

Route::get('/', [VehiculoController::class, 'welcome'])->name('welcome');
Route::resource('inventarios', InventarioController::class)->middleware('auth');
Route::resource('ventas', VentaVehiculoController::class)->middleware('auth');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');




require __DIR__.'/auth.php';
