<?php
namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $vehiculos = Vehiculo::when($search, function ($query, $search) {
            $query->where('marca', 'like', "%$search%")
                ->orWhere('modelo', 'like', "%$search%")
                ->orWhere('tipo_vehiculo', 'like', "%$search%")
                ->orWhere('año_modelo', 'like', "%$search%");
        })->get();

        return view('partials.vehiculos-index', compact('vehiculos'));
    }

    public function create()
    {
        return view('partials.compra-index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año_modelo' => 'required|integer',
            'tipo_vehiculo' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'kilometraje' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'foto_url' => 'required|url',
        ]);

        Vehiculo::create($request->all());
        return response()->json(['success' => 'Vehículo creado exitosamente.']);
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('partials.vehiculos-edit', compact('vehiculo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año_modelo' => 'required|integer',
            'tipo_vehiculo' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'kilometraje' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'foto_url' => 'required|url',
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
        $vehiculos = Vehiculo::all();
        return view('welcome', compact('vehiculos'));
    }

    public function getMarcas()
    {
        $marcas = Vehiculo::distinct()->pluck('marca');
        return response()->json($marcas);
    }

    public function getModelos()
    {
        $modelos = Vehiculo::distinct()->pluck('modelo');
        return response()->json($modelos);
    }
}
