<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraVehiculo;
use App\Models\Proveedor;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\MarcaVehiculo;
use App\Http\Controllers\VehiculoController;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->get();
        $proveedores = Proveedor::all();
        $vehiculos = Vehiculo::all();
        $marcas= MarcaVehiculo::all();
        return view('partials.compra-index', compact('compras', 'proveedores', 'vehiculos', 'marcas'));
    }

    public function store(Request $request)
    {
        // verificar que el numero de factura no exista
        $numeroFactura = $request->input('numero_factura');
        $compraExistente = Compra::where('numero_factura', $numeroFactura)->first();
        if ($compraExistente) {
            return response()->json(['error' => 'El número de factura ya existe'], 400);
        }
            
        try {
            $compraData = json_decode($request->input('compra'), true);
            $vehiculosData = json_decode($request->input('vehiculos'), true);
            // Crear la compra
            $compra = Compra::create([
                'id_proveedor' => $compraData[0]['id_proveedor'],
                'numero_factura' => $compraData[0]['numero_factura'],
                'fecha_compra' => $compraData[0]['fecha'],
                'monto_final' => 0, // Este se actualizará más tarde
            ]);
            Log::info('Compra creada: ', $compra->toArray());
            $total = 0;

            // Procesar cada vehículo
            foreach ($vehiculosData as $vehiculoData) {
                // Verificar si la marca y modelo existen
                
                // Crear el vehículo
                $vehiculo = Vehiculo::create([
                    'id_marca' => $vehiculoData['id_marca'],
                    'id_modelo' => $vehiculoData['id_modelo'],
                    'precio_compra' => $vehiculoData['precio_compra'],
                    'estado' => $vehiculoData['estado'],
                    'año_modelo' => $vehiculoData['año_modelo'],
                    'tipo_vehiculo' => $vehiculoData['tipo'],
                    'kilometraje' => $vehiculoData['kilometraje'],
                    'numero_chasis' => $vehiculoData['numero_chasis'],
                    'numero_motor' => $vehiculoData['numero_motor'],
                    'precio_venta' => $vehiculoData['precio_venta'],
                    'placa'=> $vehiculoData['placa'],
                    'descripcion'=> $vehiculoData['descripcion'],
                    'foto_url' => $vehiculoData['foto_url'], // Si tienes este campo
                ]);
                Log::info('Vehiculo creado: ', $vehiculo->toArray());
                // Agregar al detalle de la compra
                CompraVehiculo::create([
                    'id_compra' => $compra->id,
                    'id_vehiculo' => $vehiculo->id,
                ]);
                Log::info('CompraVehiculo creado: ', ['id_compra' => $compra->id, 'id_vehiculo' => $vehiculo->id]);

                // Calcular el total de la compra
                $total += $vehiculo->precio_compra;
            }

            // Actualizar el total de la compra
            $compra->monto_final = $total;
            $compra->save();
            Log::info('Compra actualizada con total: ', $compra->toArray());
            return response()->json(['success' => true, 'message' => 'Compra registrada exitosamente']);
        }
        catch (Exception $e) {
            Log::error('Error al registrar la compra: ' . $e->getMessage());
            return response()->json(['error' => 'Error al registrar la compra'.$e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        CompraVehiculo::where('compra_id', $compra->id)->delete();
        $compra->delete();

        return response()->json(['success' => 'Compra eliminada con éxito']);
    }

    public function getByRuc($ruc)
    {
        $proveedor = Proveedor::where('ruc', $ruc)->first();
        if ($proveedor) {
            return response()->json($proveedor);
        } else {
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
    }
}
