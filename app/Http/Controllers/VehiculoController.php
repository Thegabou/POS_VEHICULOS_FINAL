<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyEmailNotification;
use App\Models\Usuario;
use App\Models\Empleado;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::all();
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empleado' => 'required|exists:empleados,id',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:8',
        ]);

        $usuario = Usuario::create([
            'id_empleado' => $request->id_empleado,
            'correo' => $request->correo,
            'password' => Hash::make($request->contrasena),
        ]);

        // Enviar notificación de verificación de correo
        $usuario->notify(new VerifyEmailNotification());

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado y correo de verificación enviado.');
    }

    public function show($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update($request->all());
        return redirect()->route('vehiculos.index');
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();
        return redirect()->route('vehiculos.index');
    }
}
