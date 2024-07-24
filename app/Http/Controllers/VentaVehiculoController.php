<?php

namespace App\Http\Controllers;

use App\Models\VentaVehiculo;
use App\Models\Vehiculo;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function registrarVenta(Request $request)
    {
        $validatedData = $request->validate([
            'clienteId' => 'required|exists:clientes,id',
            'metodoPago' => 'required|string',
            'datosPago' => 'nullable|string',
            'vehiculos' => 'required|array',
            'vehiculos.*' => 'exists:vehiculos,id'
        ]);

        DB::beginTransaction();

        try {
            // Obtener los datos del cliente y el método de pago
            $clienteId = $validatedData['clienteId'];
            $metodoPago = $validatedData['metodoPago'];
            $datosPago = $validatedData['datosPago'];

            // Calcular el sub_total y total
            $subTotal = 0;
            foreach ($validatedData['vehiculos'] as $vehiculoId) {
                $vehiculo = Vehiculo::findOrFail($vehiculoId);
                if ($vehiculo->estado === 'Vendido') {
                    return response()->json(['success' => false, 'message' => 'El vehículo ya está vendido.']);
                }
                $subTotal += $vehiculo->precio_venta;
            }
            $iva = $subTotal * 0.15;
            $total = $subTotal + $iva;

            // Crear la factura
            $factura = Factura::create([
                'fecha' => now(),
                'id_empleado' => Auth::id(),
                'id_cliente' => $clienteId,
                'tipo_pago' => $metodoPago,
                'datos_pago' => $datosPago,
                'sub_total' => $subTotal,
                'total' => $total,
            ]);

            // Actualizar el estado de los vehículos y registrar en venta_vehiculo
            foreach ($validatedData['vehiculos'] as $vehiculoId) {
                $vehiculo = Vehiculo::findOrFail($vehiculoId);
                $vehiculo->estado = 'Vendido';
                $vehiculo->save();

                VentaVehiculo::create([
                    'id_vehiculo' => $vehiculoId,
                    'id_factura' => $factura->id,
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Venta registrada exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al registrar la venta']);
        }
    }
}
