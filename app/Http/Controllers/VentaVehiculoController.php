<?php

namespace App\Http\Controllers;

use App\Models\VentaVehiculo;
use Illuminate\Http\Request;

class VentaVehiculoController extends Controller
{
    public function index()
    {
        $ventaVehiculos = VentaVehiculo::all();
        return view('venta_vehiculos.index', compact('ventaVehiculos'));
    }

    public function create()
    {
        return view('venta_vehiculos.create');
    }

    public function store(Request $request)
    {
        $ventaVehiculo = VentaVehiculo::create($request->all());
        return redirect()->route('venta_vehiculos.index');
    }

    public function show($id)
    {
        $ventaVehiculo = VentaVehiculo::findOrFail($id);
        return view('venta_vehiculos.show', compact('ventaVehiculo'));
    }

    public function edit($id)
    {
        $ventaVehiculo = VentaVehiculo::findOrFail($id);
        return view('venta_vehiculos.edit', compact('ventaVehiculo'));
    }

    public function update(Request $request, $id)
    {
        $ventaVehiculo = VentaVehiculo::findOrFail($id);
        $ventaVehiculo->update($request->all());
        return redirect()->route('venta_vehiculos.index');
    }

    public function destroy($id)
    {
        $ventaVehiculo = VentaVehiculo::findOrFail($id);
        $ventaVehiculo->delete();
        return redirect()->route('venta_vehiculos.index');
    }
}
