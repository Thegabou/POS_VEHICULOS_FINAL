<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('partials.empleados-index', compact('empleados'))->render();
    }

    public function create()
    {
        return view('partials.empleados-create')->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:empleados',
            'cedula' => 'required|string|max:20|unique:empleados',
            'cargo' => 'required|string|max:100',
        ]);

        Empleado::create($request->all());

        return response()->json(['success' => 'Empleado creado exitosamente.']);
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('partials.empleados-edit', compact('empleado'))->render();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:empleados,correo,' . $id,
            'cedula' => 'required|string|max:20|unique:empleados,cedula,' . $id,
            'cargo' => 'required|string|max:100',
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());

        return response()->json(['success' => 'Empleado actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return response()->json(['success' => 'Empleado eliminado exitosamente.']);
    }
}
