<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Muestra todas las categorías.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|max:50',
        ]);

        Categoria::create([
            'nombre_categoria' => $request->nombre_categoria,
        ]);

        return redirect()->route('categorias.index')->with('success', '✅ Categoría creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza la categoría seleccionada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|max:50',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update([
            'nombre_categoria' => $request->nombre_categoria,
        ]);

        return redirect()->route('categorias.index')->with('success', '✏️ Categoría actualizada correctamente.');
    }

    /**
     * Elimina la categoría seleccionada.
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        try {
            DB::transaction(function () use ($categoria) {
                // Eliminar productos asociados y sus detalles para evitar violaciones de FK
                if (method_exists($categoria, 'productos')) {
                    foreach ($categoria->productos as $producto) {
                        if (method_exists($producto, 'detalles')) {
                            $producto->detalles()->delete();
                        }
                        $producto->delete();
                    }
                }

                // Finalmente eliminar la categoría
                $categoria->delete();
            });

            return redirect()->route('categorias.index')->with('success', '🗑️ Categoría eliminada correctamente.');
        } catch (\Exception $e) {
            logger()->error('Error eliminando categoría: '.$e->getMessage());
            return redirect()->route('categorias.index')->with('error', 'No fue posible eliminar la categoría. Asegúrate de que no existan dependencias o revisa los logs.');
    }
    }
}
