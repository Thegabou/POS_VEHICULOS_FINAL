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
        //$inventario = Inventario::where('id_vehiculo', $vehiculo->id)->first();

        
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
        

        
        $venta->update($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $venta = VentaVehiculo::findOrFail($id);
        

        // Revert the stock changes of the sale
       
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }
}
