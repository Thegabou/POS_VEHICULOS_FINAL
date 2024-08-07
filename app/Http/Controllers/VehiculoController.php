<?php
namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\MarcaVehiculo;
use App\Models\ModeloVehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $vehiculos = Vehiculo::with(['marca', 'modelo'])->when($search, function ($query, $search) {
            $query->whereHas('marca', function ($q) use ($search) {
                $q->where('marca_vehiculo', 'like', "%$search%");
            })->orWhereHas('modelo', function ($q) use ($search) {
                $q->where('modelo_vehiculo', 'like', "%$search%");
            })->orWhere('tipo_vehiculo', 'like', "%$search%")
            ->orWhere('año_modelo', 'like', "%$search%");
        })->get();

        return view('partials.vehiculos-index', compact('vehiculos'));
    }

    public function create()
    {
        $marcas = MarcaVehiculo::all();
        return view('partials.compra-index', compact('marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_marca' => 'required|exists:marca_vehiculos,id',
            'id_modelo' => 'required|exists:modelo_vehiculos,id',
            'año_modelo' => 'required|integer',
            'tipo_vehiculo' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'kilometraje' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'foto_url' => 'required|url',
            'numero_chasis' => 'required|string',
            'numero_motor' => 'required|string',
            'estado' => 'required|in:Disponible,Reservado,Vendido',
        ]);

        Vehiculo::create($request->all());
        return response()->json(['success' => 'Vehículo creado exitosamente.']);
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $marcas = MarcaVehiculo::all();
        return view('partials.vehiculos-edit', compact('vehiculo', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'año_modelo' => 'required|integer',
            'tipo_vehiculo' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'kilometraje' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'numero_chasis' => 'required|string',
            'numero_motor' => 'required|string',
            'estado' => 'required|in:Disponible,Reservado,Vendido',
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update($request->all());

        return response()->json(['success' => 'Vehículo actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();

        return response()->json(['success' => 'Vehículo eliminado exitosamente.']);
    }

    public function showAvailableVehicles()
    {
        $vehiculos = Vehiculo::where('estado', 'Disponible')->get();

        return view('partials.index.contenedor-vehiculos', compact('vehiculos'));
    }

    public function welcome()
    {
        $vehiculos = Vehiculo::with(['marca', 'modelo'])->where('estado', 'Disponible')->get();
        $marcas = MarcaVehiculo::all();
        $modelos = ModeloVehiculo::all();

        return view('welcome', compact('vehiculos', 'marcas', 'modelos'));
    }

    public function getMarcas()
    {
        $marcas = MarcaVehiculo::all();
        return response()->json($marcas);
    }

    public static function getModelosByMarca($idMarca)
    {
        $modelos = ModeloVehiculo::where('id_marca', $idMarca)->get();
        return response()->json($modelos);
    }
}

