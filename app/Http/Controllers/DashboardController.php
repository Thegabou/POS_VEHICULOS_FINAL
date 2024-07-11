<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $empleado = Auth::user()->empleado;

        if ($empleado->cargo == 'gerente') {
            return view('view-users.dashboard_gerente');
        } elseif ($empleado->cargo == 'ventas') {
            return view('view-users.dashboard_ventas');
        } else if ($empleado->cargo == 'Admin') {
            return view('view-users.dashboard_index');
        }
    }
    public function creacionUsuarios()
    {
        return view('partials.creacion-usuarios')->render();
    }

    public function inventario()
    {
        return view('partials.inventario')->render();
    }

    public function creacionEmpleados()
    {
        return view('partials.creacion-empleados')->render();
    }

    public function Empleados()
    {
        return view('partials.empleados-index')->render();
    }

}
