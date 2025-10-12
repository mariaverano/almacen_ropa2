<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::withCount('detalles')->orderBy('id_pedido', 'desc')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['detalles.producto', 'pagos'])->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }

    public function create()
    {
        // Mostrar un formulario simple para crear pedido: seleccionar productos y cantidades
        $productos = Producto::all();
        return view('pedidos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'nullable|integer',
            'direccion_envio' => 'nullable|string|max:255',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|integer|exists:MV_productos,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;

            // Crear el pedido
            $pedido = Pedido::create([
                'id_usuario' => $data['id_usuario'] ?? null,
                'direccion_envio' => $data['direccion_envio'] ?? null,
                'total' => 0,
                'estado' => 'pendiente',
                'fecha_pedido' => now(),
            ]);

            // Crear detalles y descontar stock
            foreach ($data['productos'] as $line) {
                $producto = Producto::findOrFail($line['id_producto']);

                if ($producto->stock < $line['cantidad']) {
                    throw new \Exception('Stock insuficiente para: ' . $producto->nombre_producto);
                }

                $precioUnit = $producto->precio;
                $subtotal = $precioUnit * $line['cantidad'];
                $total += $subtotal;

                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $line['cantidad'],
                    'precio_unitario' => $precioUnit,
                ]);

                // Descontar stock
                $producto->decrement('stock', $line['cantidad']);
            }

            // Actualizar total
            $pedido->update(['total' => $total]);

            DB::commit();
            return redirect()->route('pedidos.show', $pedido->id_pedido)->with('success', 'Pedido creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el pedido: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Restaurar stock
            foreach ($pedido->detalles as $detalle) {
                if ($detalle->producto) {
                    $detalle->producto->increment('stock', $detalle->cantidad);
                }
                $detalle->delete();
            }

            // Eliminar pagos si es necesario
            if (method_exists($pedido, 'pagos')) {
                foreach ($pedido->pagos as $pago) {
                    $pago->delete();
                }
            }

            $pedido->delete();

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado y stock restaurado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pedidos.index')->with('error', 'No fue posible eliminar el pedido: ' . $e->getMessage());
        }
    }
}
