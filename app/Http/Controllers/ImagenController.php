<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagenController extends Controller
{
    // View File To Upload Image
    public function index()
    {
        return view('image-form');
    }

    // Store Image
    public function storeImage(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $imageName = time().'.'.$request->imagen->extension();

        // Public Folder
        $request->imagen->move(public_path('images'), $imageName);

        // Guardar nombre de imagen en la base de datos, si es necesario
        // DB::table('your_table')->insert([
        //     'image_name' => $imageName,
        //     // otros campos ...
        // ]);

        return response()->json(['success' => 'Imagen subida exitosamente!', 'image' => $imageName]);
    }
}
