<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoria = $request->query('categoria');

        $query = Producto::query();
        if ($q) {
            $query->where('nombre_producto', 'like', "%{$q}%");
        }
        if ($categoria) {
            $query->where('id_categoria', $categoria);
        }

        $productos = $query->paginate(12);
        $categorias = Categoria::all();

        return view('shop.index', compact('productos','categorias'));
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('shop.show', compact('producto'));
    }

    public function cart()
    {
        $cart = session('cart', []);
        return view('shop.cart', compact('cart'));
    }

    public function myOrders()
    {
        $userId = session('usuario_id');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus pedidos.');
        }

        $pedidos = Pedido::with('detalles.producto','pagos')
            ->where('id_usuario', $userId)
            ->orderBy('fecha_pedido', 'desc')
            ->get();

        return view('shop.orders', compact('pedidos'));
    }

    public function addToCart(Request $request)
    {
        $id = $request->input('id');
        $qty = max(1, (int)$request->input('cantidad', 1));
        $producto = Producto::findOrFail($id);

        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['cantidad'] += $qty;
        } else {
            $cart[$id] = [
                'id' => $producto->id_producto,
                'nombre' => $producto->nombre_producto,
                'precio' => $producto->precio,
                'cantidad' => $qty,
                'imagen' => $producto->imagen ?? null,
            ];
        }
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Producto añadido al carrito');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío');
        }

        // Validaciones simples
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email',
            'direccion' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $pedido = Pedido::create([
                'id_usuario' => session('usuario_id') ?? null,
                'total' => $total,
                'estado' => 'Pendiente',
                'canal' => 'Online',
                'fecha_pedido' => now(),
            ]);

            foreach ($cart as $item) {
                $producto = Producto::find($item['id']);
                if (!$producto) throw new \Exception('Producto no existe: '.$item['id']);
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception('Stock insuficiente para '.$producto->nombre_producto);
                }
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                // decrementar stock
                $producto->decrement('stock', $item['cantidad']);
            }

            DB::commit();
            // limpiar carrito
            session()->forget('cart');
            // guardar id de pedido reciente en sesión para mostrar confirmación
            session(['last_order_id' => $pedido->id_pedido]);
            return redirect()->route('order.show', $pedido->id_pedido)->with('success', 'Pedido realizado correctamente. ID: '.$pedido->id_pedido);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar pedido: '.$e->getMessage());
        }
    }

    public function orderShow($id)
    {
        $pedido = Pedido::with(['detalles.producto','pagos','usuario'])->findOrFail($id);

        $userId = session('usuario_id');
        $userRole = session('usuario_rol');

        // Si no hay sesión, pedir login
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver este pedido.');
        }

        // Si es admin o es el dueño del pedido, permitir; si no, redirigir a shop con error
        if ($userRole === 'admin' || $userId == $pedido->id_usuario) {
            return view('shop.order', compact('pedido'));
        }

        return redirect()->route('shop.index')->with('error', 'Acceso no autorizado al pedido.');
    }
}
