<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Listar Clientes con funcionalidad de búsqueda
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('apellido', 'LIKE', "%{$search}%")
                ->orWhere('correo', 'LIKE', "%{$search}%")
                ->orWhere('numero_telefono', 'LIKE', "%{$search}%")
                ->orWhere('cedula', 'LIKE', "%{$search}%");
        }

        $clientes = $query->get();

        return view('partials.clientes-index', compact('clientes'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('partials.clientes-create');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:clientes,correo',
            'numero_telefono' => 'required|numeric',
            'cedula' => 'required|string|max:20|unique:clientes,cedula',
        ]);

        Cliente::create($request->all());

        return response()->json(['success' => 'Cliente creado con éxito']);
    }

    // Mostrar un cliente específico
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('partials.clientes-edit', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:clientes,correo,' . $id,
            'numero_telefono' => 'required|numeric',
            'cedula' => 'required|string|max:20|unique:clientes,cedula,' . $id,
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return response()->json(['success' => 'Cliente actualizado con éxito']);
    }

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return response()->json(['success' => 'Cliente eliminado con éxito']);
    }

    // Buscar cliente por cédula
    public function buscarCliente($cedula)
    {
        $cliente = Cliente::where('cedula', $cedula)->first();
        if ($cliente) {
            return response()->json($cliente);
        } else {
            return response()->json(null, 404);
        }
    }
}
