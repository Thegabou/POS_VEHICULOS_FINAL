<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Vehiculo;

class DashboardController extends Controller
{
    public function index()
    {
        $empleado = Auth::user()->empleado;

        if ($empleado->cargo == 'gerente') {
            return view('view-users.dashboard_gerente');
        } elseif ($empleado->cargo == 'vendedor') {
            return view('view-users.dashboard_ventas');
        } else if ($empleado->cargo == 'Admin') {
            return view('view-users.dashboard_index');
        }
    }

    public function Empleados()
    {
        $empleados = Empleado::all();
        return view('partials.empleados-index', compact('empleados'))->render();
    }

    public function usuarios()
    {
        $usuarios = Usuario::with('empleado')->get();
        return view('partials.usuarios-index', compact('usuarios'))->render();
    }

    

}
