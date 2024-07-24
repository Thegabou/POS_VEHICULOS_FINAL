<?php
namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Listar Proveedores
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('ruc', 'LIKE', "%{$search}%")
                ->orWhere('correo', 'LIKE', "%{$search}%")
                ->orWhere('telefono', 'LIKE', "%{$search}%")
                ->orWhere('direccion', 'LIKE', "%{$search}%");
        }

        $proveedores = $query->get();

        return view('partials.proveedor-index', compact('proveedores'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('partials.proveedor-create')->render();;
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

        return response()->json(['success' => 'Proveedor creado correctamente']);
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('partials.proveedor-edit', compact('proveedor'))->render();
    }

    // Actualizar proveedor
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|max:20',
            'telefono' => 'required|string|max:10',
            'correo' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return response()->json(['success' => 'Proveedor actualizado correctamente'])->render();
    }

    // Eliminar proveedor
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return response()->json(['success' => 'Proveedor eliminado correctamente']);
    }

    // Obtener proveedor por RUC
    public function show($ruc)
    {
        $proveedor = Proveedor::where('ruc', $ruc)->firstOrFail();
        return response()->json($proveedor);
    }
}
