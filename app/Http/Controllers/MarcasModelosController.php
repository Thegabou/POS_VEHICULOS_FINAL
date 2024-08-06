<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarcaVehiculo as Marca;
use App\Models\ModeloVehiculo as Modelo;


class MarcasModelosController extends Controller
{
    public function index()
    {
        $marcas = Marca::with('modelos')->get();
        return view('partials.marcas_modelos', compact('marcas'));
    }

    public function storeMarca(Request $request)
    {
        $request->validate([
            'nombreMarca' => 'required|string|max:255',
        ]);

        $marca = new Marca();
        $marca->nombre = $request->nombreMarca;
        $marca->save();

        return redirect()->route('marcasModelos.index')->with('success', 'Marca creada exitosamente.');
    }

    public function storeModelo(Request $request)
    {
        $request->validate([
            'marcaId' => 'required|exists:marcas,id',
            'nombreModelo' => 'required|string|max:255',
        ]);

        $modelo = new Modelo();
        $modelo->marca_id = $request->marcaId;
        $modelo->nombre = $request->nombreModelo;
        $modelo->save();

        return redirect()->route('marcasModelos.index')->with('success', 'Modelo creado exitosamente.');
    }

    public function searchMarcas(Request $request)
    {
        $query = $request->get('query');
        $marcas = Marca::where('nombre', 'LIKE', "%{$query}%")->get();

        return response()->json($marcas);
    }
}
