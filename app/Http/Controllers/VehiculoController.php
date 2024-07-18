<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\VentaVehiculo;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $vehiculos = Vehiculo::when($search, function ($query, $search) {
            $query->where('marca', 'like', "%$search%")
                ->orWhere('modelo', 'like', "%$search%")
                ->orWhere('tipo_vehiculo', 'like', "%$search%")
                ->orWhere('año_modelo', 'like', "%$search%");
        })->get();

        return view('partials.vehiculos-index', compact('vehiculos'));
    }

    public function create()
    {
        return view('partials.vehiculos-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año_modelo' => 'required|integer',
            'tipo_vehiculo' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'kilometraje' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'foto_url' => 'required|url',
        ]);

        $vehiculo = Vehiculo::create($request->all());

        Inventario::create([
            'id_vehiculo' => $vehiculo->id,
            'stock' => 0,
        ]);

        return response()->json(['success' => 'Vehículo creado exitosamente.']);
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('partials.vehiculos-edit', compact('vehiculo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año_modelo' => 'required|integer',
            'tipo_vehiculo' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'kilometraje' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'foto_url' => 'required|url',
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update($request->all());

        return response()->json(['success' => 'Vehículo actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();

        return response()->json(['success' => 'Vehículo eliminado exitosamente.']);
    }

    // VehiculoController.php
    public function welcome()
    {
        $vehiculos = Vehiculo::all();
        return view('welcome', compact('vehiculos'));
    }

    public function venta(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
        $inventario = Inventario::where('id_vehiculo', $vehiculo->id)->first();

        if ($inventario->stock < $request->cantidad) {
            return response()->json(['error' => 'No hay suficiente stock disponible.'], 400);
        }

        $inventario->stock -= $request->cantidad;
        $inventario->save();

        VentaVehiculo::create([
            'id_vehiculo' => $vehiculo->id,
            'cantidad' => $request->cantidad,
            'id_factura' => $request->id_factura, // Este campo debe ser manejado según tu lógica de facturación
        ]);

        return response()->json(['success' => 'Venta realizada exitosamente.']);
    }

}
