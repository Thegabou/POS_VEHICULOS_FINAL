<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Vehiculo;
use App\Models\VentaVehiculo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('cliente', 'vendedor')->get();
        return view('facturas.index', compact('facturas'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Crear la factura
            $factura = Factura::create([
                'id_cliente' => $request->input('id_cliente'),
                'id_vendedor' => $request->input('id_vendedor'),
                'fecha' => $request->input('fecha'),
                'monto_final' => $request->input('monto_final'),
                'metodo_pago' => $request->input('metodo_pago'),
                'datos_pago' => $request->input('datos_pago') ?? null,
            ]);

            $vehiculos = $request->input('vehiculos');
            foreach ($vehiculos as $vehiculoData) {
                // Obtener el vehículo
                $vehiculo = Vehiculo::findOrFail($vehiculoData['id']);

                // Verificar si el vehículo está disponible
                if ($vehiculo->estado === 'Disponible' || $vehiculo->estado === 'Reservado') {
                    // Actualizar el estado del vehículo a 'Vendido'
                    $vehiculo->estado = 'Vendido';
                    $vehiculo->save();

                    // Crear el registro en la tabla venta_vehiculo
                    VentaVehiculo::create([
                        'id_factura' => $factura->id,
                        'id_vehiculo' => $vehiculo->id,
                    ]);
                } else {
                    // Si algún vehículo no está disponible, se revierte la transacción
                    DB::rollBack();
                    return response()->json(['error' => 'El vehículo ' . $vehiculo->id . ' no está disponible'], 400);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Factura registrada exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar la factura: ' . $e->getMessage());
            return response()->json(['error' => 'Error al registrar la factura'], 500);
        }
    }

    public function show($id)
    {
        $factura = Factura::with('cliente', 'vendedor', 'ventaVehiculos.vehiculo')->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $factura = Factura::findOrFail($id);

            // Obtener todos los registros de venta_vehiculo asociados a esta factura
            $ventaVehiculos = VentaVehiculo::where('id_factura', $factura->id)->get();

            // Revertir el estado de los vehículos a 'Disponible'
            foreach ($ventaVehiculos as $ventaVehiculo) {
                $vehiculo = Vehiculo::findOrFail($ventaVehiculo->id_vehiculo);
                $vehiculo->estado = 'Disponible';
                $vehiculo->save();

                // Eliminar el registro de venta_vehiculo
                $ventaVehiculo->delete();
            }

            // Eliminar la factura
            $factura->delete();

            DB::commit();
            return response()->json(['success' => 'Factura eliminada con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar la factura: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar la factura'], 500);
        }
    }
}
