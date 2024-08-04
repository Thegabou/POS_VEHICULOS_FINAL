<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalVariable;
use Illuminate\Support\Facades\Auth;

class GlobalVariableController extends Controller
{
    public function checkAdmin()
    {
        $empleado = Auth::user()->empleado;
        if ($empleado->cargo != 'Admin') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAdmin()) {
            return response()->view('partials.admin.index', ['message' => 'No tienes acceso suficiente']);
        }

        $variables = GlobalVariable::all();
        return view('partials.admin.index', compact('variables'));
    }

    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return response()->json(['error' => 'No tienes acceso suficiente'], 403);
        }

        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
        ]);

        GlobalVariable::set($request->key, $request->value);
        return response()->json(['success' => 'Variable creada/actualizada', 'key' => $request->key, 'value' => $request->value]);
    }

    public function destroy($key)
    {
        if (!$this->checkAdmin()) {
            return response()->json(['error' => 'No tienes acceso suficiente'], 403);
        }

        GlobalVariable::delete($key);
        return response()->json(['success' => 'Variable eliminada', 'key' => $key]);
    }
}
