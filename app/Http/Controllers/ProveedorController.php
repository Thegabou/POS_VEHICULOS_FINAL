<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Listar Proveedores
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('partials.proveedor-index', compact('proveedores'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('partials.proveedor-create');
    }

    // Guardar nuevo proveedor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|max:20',
            'telefono' => 'required|string|max:10',
            'correo' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente');
    }

    // Mostrar formulario de edición
    public function edit(Proveedor $proveedor)
    {
        return view('partials.proveedor-edit', compact('proveedores'));
    }

    // Actualizar proveedor
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|max:20',
            'telefono' => 'required|string|max:10',
            'correo' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente');
    }

    // Eliminar proveedor
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente');
    }
}
