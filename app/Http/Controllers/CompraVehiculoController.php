<?php

namespace App\Http\Controllers;

use App\Models\CompraVehiculo;
use Illuminate\Http\Request;

class CompraVehiculoController extends Controller
{
    public function index()
    {
        $compraVehiculos = CompraVehiculo::all();
        return view('compra_vehiculos.index', compact('compraVehiculos'));
    }

    public function create()
    {
        return view('compra_vehiculos.create');
    }

    public function store(Request $request)
    {
        $compraVehiculo = CompraVehiculo::create($request->all());
        return redirect()->route('compra_vehiculos.index');
    }

    public function show($id)
    {
        $compraVehiculo = CompraVehiculo::findOrFail($id);
        return view('compra_vehiculos.show', compact('compraVehiculo'));
    }

    public function edit($id)
    {
        $compraVehiculo = CompraVehiculo::findOrFail($id);
        return view('compra_vehiculos.edit', compact('compraVehiculo'));
    }

    public function update(Request $request, $id)
    {
        $compraVehiculo = CompraVehiculo::findOrFail($id);
        $compraVehiculo->update($request->all());
        return redirect()->route('compra_vehiculos.index');
    }

    public function destroy($id)
    {
        $compraVehiculo = CompraVehiculo::findOrFail($id);
        $compraVehiculo->delete();
        return redirect()->route('compra_vehiculos.index');
    }
}
