<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Empleado;
use Illuminate\Http\Request;


class UsuarioController extends Controller{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $usuarios = Usuario::when($search, function ($query, $search) {
            $query->whereHas('empleado', function ($query) use ($search) {
                $query->where('nombre', 'like', "%$search%")
                    ->orWhere('apellido', 'like', "%$search%");
            });
        })->get();

        return view('partials.usuarios-index', compact('usuarios'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('partials.usuarios-create', compact('empleados'));
    }

    public function store(Request $request)
{
    $request->validate([
        'correo' => 'required|email|unique:usuarios,correo',
        'contrasena' => 'required',
        'id_empleado' => 'required|exists:empleados,id',
    ]);

    $usuario = Usuario::create([
        'correo' => $request->correo,
        'contrasena' => hash('sha256', $request->contrasena),
        'id_empleado' => $request->id_empleado,
    ]);

    $usuario->sendEmailVerificationNotification();

    return response()->json(['success' => 'Usuario creado exitosamente. Se ha enviado un correo de verificación.']);
}

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $empleados = Empleado::all();
        return view('partials.usuarios-edit', compact('usuario', 'empleados'));
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

    public function searchEmpleado(Request $request)
    {
        $cedula = $request->input('cedula');
        $empleado = Empleado::where('cedula', $cedula)->first();

        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado.'], 404);
        }

        return response()->json($empleado);
    }
}
