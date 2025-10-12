<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // 📋 Mostrar todos los productos
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('productos.index', compact('productos'));
    }

    // ➕ Mostrar formulario para crear un nuevo producto
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    // 💾 Guardar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:MV_categorias,id_categoria',
            'imagen' => 'nullable|string|max:255',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // ✏️ Mostrar formulario de edición
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    // � Mostrar detalle de producto
    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    // �🔁 Actualizar producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:MV_categorias,id_categoria',
            'imagen' => 'nullable|string|max:255',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // 🗑️ Eliminar producto (elimina detalles relacionados primero)
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        try {
            \DB::transaction(function () use ($producto) {
                // Eliminar detalles asociados (si existen)
                if (method_exists($producto, 'detalles')) {
                    $producto->detalles()->delete();
                }

                // Finalmente eliminar el producto
                $producto->delete();
            });

            return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            // Registro del error y mensaje amigable
            logger()->error('Error eliminando producto: '.$e->getMessage());
            return redirect()->route('productos.index')->with('error', 'No fue posible eliminar el producto. Asegúrate de que no existan dependencias.');
        }
    }
}
