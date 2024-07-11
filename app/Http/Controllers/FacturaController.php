<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::all();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        return view('facturas.create');
    }

    public function store(Request $request)
    {
        $factura = Factura::create($request->all());
        return redirect()->route('facturas.index');
    }

    public function show($id)
    {
        $factura = Factura::findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    public function edit($id)
    {
        $factura = Factura::findOrFail($id);
        return view('facturas.edit', compact('factura'));
    }

    public function update(Request $request, $id)
    {
        $factura = Factura::findOrFail($id);
        $factura->update($request->all());
        return redirect()->route('facturas.index');
    }

    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return redirect()->route('facturas.index');
    }
}
