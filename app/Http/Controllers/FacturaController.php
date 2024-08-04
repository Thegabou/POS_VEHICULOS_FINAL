<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Vehiculo;
use App\Models\VentaVehiculo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime; 
use Exception; 
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('cliente', 'vendedor')->get();
        $empleado = Auth::user()->empleado;
        return view('facturas.index', compact('facturas','empleado'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Formatear la fecha
            $fecha = $request->input('fecha');
            $fechaFormateada = (new DateTime($fecha))->format('Y-m-d H:i:s');

            // Obtener los datos del pago y los vehiculos
            $datosPago = json_decode($request->input('datos_pago'), true);
            $vehiculos = json_decode($request->input('vehiculos'), true);

            // Generar el número de factura
            $ultimoNumeroFactura = Factura::orderBy('created_at', 'desc')->first()->numero_factura ?? '000-000-0000000';
            $nuevoNumeroFactura = $this->generarNumeroFactura($ultimoNumeroFactura);

            // Crear la factura
            $factura = Factura::create([
                'numero_factura' => $nuevoNumeroFactura,
                'fecha' => $fechaFormateada,                
                'id_empleado' => auth()->user()->empleado->id,  
                'id_cliente' => $request->input('id_cliente'),                  
                'tipo_pago' => $request->input('tipo_pago'),                   
                'datos_pago' => json_encode($datosPago),        
                'sub_total' => $request->input('sub_total'),
                'total' => $request->input('total'),
            ]);

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
            return response()->json(['success' => true, 'message' => 'Factura registrada exitosamente ' . json_encode($datosPago)]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar la factura: ' . $e->getMessage());
            return response()->json(['error' => 'Error al registrar la factura: ' . $e->getMessage()], 500);
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
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar la factura: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar la factura'], 500);
        }
    }

    private function generarNumeroFactura($ultimoNumeroFactura)
    {
        list($parte1, $parte2, $parte3) = explode('-', $ultimoNumeroFactura);

        $parte3 = intval($parte3) + 1;
        if ($parte3 > 9999999) {
            $parte3 = 1;
            $parte2 = intval($parte2) + 1;
            if ($parte2 > 999) {
                $parte2 = 1;
                $parte1 = intval($parte1) + 1;
            }
        }

        return sprintf('%03d-%03d-%07d', $parte1, $parte2, $parte3);
    }
}
