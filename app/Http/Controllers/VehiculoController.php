<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Inventario;
use Illuminate\Http\Request;

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

        // Create an entry in the inventory with default stock 0
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

    public function showAvailableVehicles()
    {
        $vehiculos = Vehiculo::with('inventario')->get();

        return view('partials.index.contenedor-vehiculos', compact('vehiculos'));
    }

    public function welcome()
    {
        $vehiculos = Vehiculo::with('inventario')->get();
        return view('welcome', compact('vehiculos'));
    }
}
