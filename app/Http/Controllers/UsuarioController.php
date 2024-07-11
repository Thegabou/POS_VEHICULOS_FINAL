<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Empleado;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('empleado');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('empleado', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%");
            });
        }

        $usuarios = $query->get();

        return view('partials.usuarios-index', compact('usuarios'))->render();
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('partials.usuarios-create', compact('empleados'))->render();
    }

    public function searchEmpleado(Request $request)
    {
        $cedula = $request->input('cedula');
        $empleado = Empleado::where('cedula', $cedula)->first();

        if ($empleado) {
            return response()->json($empleado);
        } else {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'contrasena' => 'required|string|min:8',
            'id_empleado' => 'required|exists:empleados,id',
        ]);

        Usuario::create([
            'correo' => $request->correo,
            'contrasena' => hash('sha256', $request->contrasena),
            'id_empleado' => $request->id_empleado,
        ]);

        return response()->json(['success' => 'Usuario creado exitosamente.']);
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $empleados = Empleado::all();
        return view('partials.usuarios-edit', compact('usuario', 'empleados'))->render();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'correo' => 'required|string|email|max:255|unique:usuarios,correo,' . $id,
            'contrasena' => 'nullable|string|min:8',
            'id_empleado' => 'required|exists:empleados,id',
        ]);

        $usuario = Usuario::findOrFail($id);
        $data = $request->only('correo', 'id_empleado');
        if ($request->filled('contrasena')) {
            $data['contrasena'] = hash('sha256', $request->contrasena);
        }
        $usuario->update($data);

        return response()->json(['success' => 'Usuario actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(['success' => 'Usuario eliminado exitosamente.']);
    }
}
