<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('partials.clientes-index', compact('clientes'));
    }

    public function create()
    {
        return view('partials.clientes-create');
    }

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

        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito');
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('partials.clientes-edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:clientes,correo,' . $cliente->id,
            'numero_telefono' => 'required|numeric',
            'cedula' => 'required|string|max:20|unique:clientes,cedula,' . $cliente->id,
        ]);
        
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito');
    }

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
