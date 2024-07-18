<?php

namespace App\Http\Controllers;

use App\Models\VentaVehiculo;
use App\Models\Vehiculo;
use App\Models\Inventario;
use App\Models\Factura;
use Illuminate\Http\Request;

class VentaVehiculoController extends Controller
{
    public function index()
    {
        $ventas = VentaVehiculo::with('vehiculo', 'factura')->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::all();
        return view('ventas.create', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'cantidad' => 'required|integer|min:1',
            'id_factura' => 'required|exists:facturas,id',
        ]);

        $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
        $inventario = Inventario::where('id_vehiculo', $vehiculo->id)->first();

        if ($inventario->stock < $request->cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        $inventario->stock -= $request->cantidad;
        $inventario->save();

        VentaVehiculo::create([
            'id_vehiculo' => $vehiculo->id,
            'cantidad' => $request->cantidad,
            'id_factura' => $request->id_factura,
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta realizada exitosamente.');
    }

    public function edit($id)
    {
        $venta = VentaVehiculo::findOrFail($id);
        $vehiculos = Vehiculo::all();
        return view('ventas.edit', compact('venta', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id',
            'cantidad' => 'required|integer|min:1',
            'id_factura' => 'required|exists:facturas,id',
        ]);

        $venta = VentaVehiculo::findOrFail($id);
        $inventario = Inventario::where('id_vehiculo', $venta->id_vehiculo)->first();

        if ($inventario->stock + $venta->cantidad < $request->cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        // Revert the stock changes of the old sale
        $inventario->stock += $venta->cantidad;

        // Apply the new stock changes
        $inventario->stock -= $request->cantidad;
        $inventario->save();

        $venta->update($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $venta = VentaVehiculo::findOrFail($id);
        $inventario = Inventario::where('id_vehiculo', $venta->id_vehiculo)->first();

        // Revert the stock changes of the sale
        $inventario->stock += $venta->cantidad;
        $inventario->save();

        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }
}
