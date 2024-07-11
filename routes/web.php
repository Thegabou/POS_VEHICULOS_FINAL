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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;

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
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');




require __DIR__.'/auth.php';
