<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModeloVehiculo;

class ModeloVehiculosController extends Controller
{
    //obtener modelos seguin id de la marca
    public function getModelos(Request $request)
    {
        $id_marca = $request->input('id_marca');
        $modelos = ModeloVehiculo::where('id_marca', $id_marca)->get();
        return response()->json($modelos);
    }

}
