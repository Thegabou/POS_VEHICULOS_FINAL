<?php

namespace App\Http\Controllers;

use App\Models\CompraVehiculo;
use Illuminate\Http\Request;

class CompraVehiculoController extends Controller
{
    public function index()
    {
        $compraVehiculos = CompraVehiculo::with('compra', 'vehiculo')->get();
        return view('compra_vehiculo.index', compact('compraVehiculos'));
    }

    public function create()
    {
        return view('compra_vehiculo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_compra' => 'required|exists:compras,id',
            'id_vehiculo' => 'required|exists:vehiculos,id',
        ]);

        CompraVehiculo::create($request->all());

        return response()->json(['success' => true, 'message' => 'Compra de vehículo registrada exitosamente']);
    }

    public function destroy($id)
    {
        $compraVehiculo = CompraVehiculo::findOrFail($id);
        $compraVehiculo->delete();

        return response()->json(['success' => 'Compra de vehículo eliminada con éxito']);
    }
}
