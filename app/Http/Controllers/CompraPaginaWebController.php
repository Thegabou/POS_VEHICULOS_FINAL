<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\VentaVehiculo;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use DateTime;

class CompraPaginaWebController extends Controller
{
    public function index($id)
    {
        $vehiculo = Vehiculo::find($id);
        $error = null;

        if (!$vehiculo) {
            $error = 'El vehículo no existe';
        } elseif ($vehiculo->estado != 'Disponible') {
            $error = 'El vehículo no está disponible';
        }

        return view('compra-vehiculo', compact('vehiculo', 'error'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $vehiculoData = $request->input('vehiculo');
            $vehiculo = Vehiculo::findOrFail($vehiculoData['id']);

            // Verificar si el vehículo está disponible
            if ($vehiculo->estado !== 'Disponible' && $vehiculo->estado !== 'Reservado') {
                return response()->json(['error' => 'El vehículo ' . $vehiculo->id . ' no está disponible'], 400);
            }

            // Obtener los datos del pago y los vehiculos
            $datosPago = $request->input('datos_pago');

            // Verificar si la cédula ya existe
            $cliente = Cliente::where('cedula', $request->input('cedula'))->first();
            if (is_null($cliente)) {
                $cliente = Cliente::create([
                    'nombre' => $request->input('nombre'),
                    'apellido' => $request->input('apellido'),
                    'correo' => $request->input('correo'),
                    'numero_telefono' => $request->input('telefono'),
                    'cedula' => $request->input('cedula'),
                ]);
            }

            // Formatear la fecha
            $fecha = $request->input('fecha');
            $fechaFormateada = (new DateTime($fecha))->format('Y-m-d H:i:s');

            // Crear la factura
            $factura = Factura::create([
                'fecha' => $fechaFormateada,                
                'id_empleado' => null,  
                'id_cliente' => $cliente->id,                  
                'tipo_pago' => $request->input('tipo_pago'),                   
                'datos_pago' => json_encode($datosPago),        
                'sub_total' => $request->input('sub_total'),
                'total' => $request->input('total'),
            ]);

            // Actualizar el estado del vehículo a 'Vendido'
            $vehiculo->estado = 'Vendido';
            $vehiculo->save();

            // Crear el registro en la tabla venta_vehiculo
            VentaVehiculo::create([
                'id_factura' => $factura->id,
                'id_vehiculo' => $vehiculo->id,
            ]);

            DB::commit();
            $empleadonombre='Pagina Web';
            // Generar PDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);

            // Pasar todos los datos relevantes del vehículo
            $view = view('factura', compact('factura', 'empleadonombre','vehiculo', 'cliente'))->render();
            $dompdf->loadHtml($view);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $output = $dompdf->output();
            file_put_contents(public_path('facturas/factura_' . $factura->id . '.pdf'), $output);

            $retJson = [
                'success' => true,
                'message' => 'Factura registrada exitosamente',
                'factura' => $factura,
                'vehiculo' => $vehiculo,
                'cliente' => $cliente,
            ];

            return response()->json($retJson);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar la factura: ' . $e->getMessage());
            return response()->json(['error' => 'Error al registrar la factura: ' . $e->getMessage()], 500);
        }
    }

    public function buscarCliente($cedula)
    {
        $cliente = Cliente::where('cedula', $cedula)->first();

        if ($cliente) {
            return response()->json($cliente);
        } else {
            return response()->json(null, 404);
        }
    }
}
