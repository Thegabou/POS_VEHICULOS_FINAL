<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Empleado;

class VendedorController extends Controller
{
    public function punto_Ventas()
    {
        $empleados = Empleado::whereIn('cargo', ['vendedor', 'gerente'])->get();
        $vehiculos = Vehiculo::all();
        $clientes = Cliente::all();

        return view('partials.ventas.vendedor-index', compact('empleados', 'vehiculos', 'clientes'));
    }

}
