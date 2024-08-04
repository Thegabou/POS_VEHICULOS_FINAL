<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Empleado;
use App\Models\Factura;
use App\Models\VentaVehiculo;
use App\Models\GlobalVariable;

class VendedorController extends Controller
{
    public function punto_Ventas()
    {
        $empleado = auth()->user()->empleado;
        $vehiculos = Vehiculo::with(['marca', 'modelo'])->get();
        $clientes = Cliente::all();
        $iva = GlobalVariable::get('IVA','12');
        //variable1 a int
        $iva = intval($iva);

        return view('partials.ventas.vendedor-index', compact('empleado', 'vehiculos', 'clientes', 'iva'));
    }

    public function buscarCliente($cedula)
    {
        $cliente = Cliente::where('cedula', $cedula)->first();
        return response()->json($cliente);
    }

    public function registrarVenta(Request $request)
    {
        $validatedData = $request->validate([
            'clienteId' => 'required|exists:clientes,cedula',
            'metodoPago' => 'required|string',
            'vehiculos' => 'required|array',
            'vehiculos.*' => 'exists:vehiculos,id',
        ]);

        // Crear la factura
        $factura = Factura::create([
            'cliente_id' => Cliente::where('cedula', $request->clienteId)->first()->id,
            'metodo_pago' => $request->metodoPago,
            'datos_pago' => $request->datosPago,
            'total' => 0 // Este se actualizará más tarde
        ]);

        $total = 0;

        // Procesar cada vehículo
        foreach ($request->vehiculos as $vehiculoId) {
            $vehiculo = Vehiculo::findOrFail($vehiculoId);
            $vehiculo->estado = 'Vendido';
            $vehiculo->save();

            // Agregar al detalle de la venta
            VentaVehiculo::create([
                'factura_id' => $factura->id,
                'vehiculo_id' => $vehiculo->id,
            ]);

            // Calcular el total de la venta
            $total += $vehiculo->precio_venta;
        }

        // Actualizar el total de la factura
        $factura->total = $total;
        $factura->save();

        return response()->json(['success' => true, 'message' => 'Venta registrada exitosamente']);
    }
}
