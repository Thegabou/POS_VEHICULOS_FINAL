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
        } else {
            return view('view-users.dashboard_index');
        }
    }
}
