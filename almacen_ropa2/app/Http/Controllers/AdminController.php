<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Pago;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'productos' => Producto::count(),
            'categorias' => Categoria::count(),
            'pedidos' => Pedido::count(),
            'usuarios' => Usuario::count(),
            'ventas_total' => Pago::sum('monto'),
        ];

        $recentProductos = Producto::with('categoria')->orderByDesc('id_producto')->limit(6)->get();

        return view('admin.dashboard', compact('stats', 'recentProductos'));
    }
}
