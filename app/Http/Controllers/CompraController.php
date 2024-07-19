<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraVehiculo;
use App\Models\Inventario;
use App\Models\Proveedor;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function create()
{
    $proveedores = Proveedor::all();
    $vehiculos = Vehiculo::all();

    return view('partials.factura-index', compact('proveedores', 'vehiculos'));
}

    public function store(Request $request)
{
    $request->validate([
        'numero_factura' => 'required',
        'fecha_compra' => 'required|date',
        'id_proveedor' => 'required|exists:proveedores,id',
        'vehiculos.*.id_vehiculo' => 'required|exists:vehiculos,id',
        'vehiculos.*.cantidad' => 'required|integer|min:1',
        'monto_final' => 'required|numeric',
    ]);

    $compra = Compra::create([
        'numero_factura' => $request->numero_factura,
        'fecha_compra' => $request->fecha_compra,
        'id_proveedor' => $request->id_proveedor,
        'monto_final' => $request->monto_final,
    ]);

    foreach ($request->vehiculos as $vehiculo) {
        CompraVehiculo::create([
            'id_compra' => $compra->id,
            'id_vehiculo' => $vehiculo['id_vehiculo'],
            'cantidad' => $vehiculo['cantidad'],
        ]);

        // Actualizar el inventario
        $inventario = Inventario::where('id_vehiculo', $vehiculo['id_vehiculo'])->first();
        if ($inventario) {
            $inventario->stock += $vehiculo['cantidad'];
            $inventario->save();
        } else {
            Inventario::create([
                'id_vehiculo' => $vehiculo['id_vehiculo'],
                'stock' => $vehiculo['cantidad'],
            ]);
        }
    }

    return redirect()->route('compra_create')->with('success', 'Compra creada exitosamente.');
}
}
