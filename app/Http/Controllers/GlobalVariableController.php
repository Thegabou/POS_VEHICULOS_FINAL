<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalVariable;
use Illuminate\Support\Facades\Auth;

class GlobalVariableController extends Controller
{
    public function checkAdmin(){   
        $empleado = Auth::user()->empleado;
        if ($empleado->cargo != 'Administrador') {
            return redirect()->route('welcome');
        }

    }

    public function index()
    {   //verificar si el usuario tiene cargo administrador
        
        $variables = GlobalVariable::all();
        
        return view('partials.admin.index', compact('variables'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
        ]);

        GlobalVariable::set($request->key, $request->value);
        return redirect()->route('global_variables.index')->with('success', 'Variable creada/actualizada');
    }

    public function destroy($key)
    {
        $this->checkAdmin();
        GlobalVariable::delete($key);
        return redirect()->route('global_variables.index')->with('success', 'Variable eliminada');
    }
}
