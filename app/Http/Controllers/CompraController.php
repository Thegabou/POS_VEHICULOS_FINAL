<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::all();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
    {
        $compra = Compra::create($request->all());
        return redirect()->route('compras.index');
    }

    public function show($id)
    {
        $compra = Compra::findOrFail($id);
        return view('compras.show', compact('compra'));
    }

    public function edit($id)
    {
        $compra = Compra::findOrFail($id);
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        $compra->update($request->all());
        return redirect()->route('compras.index');
    }

    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();
        return redirect()->route('compras.index');
    }
}
