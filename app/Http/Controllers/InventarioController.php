<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('vehiculo')->get();
        return view('inventarios.index', compact('inventarios'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::all();
        return view('inventarios.create', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'stock' => 'required|integer|min:0',
        ]);

        Inventario::create($request->all());

        return redirect()->route('inventarios.index')->with('success', 'Inventario creado exitosamente.');
    }

    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        $vehiculos = Vehiculo::all();
        return view('inventarios.edit', compact('inventario', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'stock' => 'required|integer|min:0',
        ]);

        $inventario = Inventario::findOrFail($id);
        $inventario->update($request->all());

        return redirect()->route('inventarios.index')->with('success', 'Inventario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return redirect()->route('inventarios.index')->with('success', 'Inventario eliminado exitosamente.');
    }
}
