<?php
namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraVehiculo;
use App\Models\Proveedor;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->get();
        $proveedores = Proveedor::all();
        $vehiculos = Vehiculo::all();
        return view('partials.compra-index', compact('compras', 'proveedores', 'vehiculos'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'ruc' => 'required|exists:proveedores,ruc',
            'vehiculos' => 'required|array',
            'vehiculos.*.marca' => 'required',
            'vehiculos.*.modelo' => 'required',
            'vehiculos.*.estado' => 'required|in:Disponible,Reservado,Vendido',
        ]);

        // Crear la compra
        $compra = Compra::create([
            'ruc' => $request->input('ruc'),
            'fecha' => $request->input('fecha'),
            'total' => 0, // Este se actualizará más tarde
        ]);

        $total = 0;

        // Procesar cada vehículo
        foreach ($request->input('vehiculos') as $vehiculoData) {
            // Crear o actualizar el vehículo
            $vehiculo = Vehiculo::updateOrCreate(
                [
                    'marca' => $vehiculoData['marca'],
                    'modelo' => $vehiculoData['modelo'],
                ],
                [
                    'estado' => $vehiculoData['estado'],
                    'precio' => $vehiculoData['precio'],
                ]
            );

            // Agregar al detalle de la compra
            CompraVehiculo::create([
                'compra_id' => $compra->id,
                'vehiculo_id' => $vehiculo->id,
                'estado' => $vehiculoData['estado'],
            ]);

            // Suponiendo que tu lógica de negocio incluye calcular el precio total
            $total += $vehiculo->precio; // Ajusta según cómo quieras manejar el precio
        }

        // Actualizar el total de la compra
        $compra->total = $total;
        $compra->save();

        return response()->json(['success' => true, 'message' => 'Compra registrada exitosamente']);
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
