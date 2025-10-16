<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('pedido')->orderBy('id_pago', 'desc')->get();
        return view('pagos.index', compact('pagos'));
    }

    // Pago realizado desde el panel/admin
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pedido' => 'required|integer|exists:MV_pedidos,id_pedido',
            'metodo' => 'required|string|max:50',
            'monto' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            $pago = Pago::create([
                'id_pedido' => $data['id_pedido'],
                'metodo' => $data['metodo'],
                'monto' => $data['monto'],
                'fecha_pago' => now(),
            ]);

            // Opcional: actualizar estado del pedido si montos cubren el total
            $pedido = Pedido::find($data['id_pedido']);
            if ($pedido) {
                $sumaPagos = $pedido->pagos()->sum('monto');
                if ($sumaPagos >= $pedido->total) {
                    $pedido->update(['estado' => 'pagado']);
                }
            }

            DB::commit();
            return $this->handleRedirect($pedido, $data['id_pedido']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'No se pudo registrar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Registrar pago desde la vista pública del cliente.
     * Requiere que el usuario haya iniciado sesión y sea dueño del pedido.
     */
    public function storePublic(Request $request)
    {
        $data = $request->validate([
            'id_pedido' => 'required|integer|exists:MV_pedidos,id_pedido',
            'metodo' => 'required|string|max:50',
            'monto' => 'required|numeric|min:0.01',
        ]);

        $pedido = Pedido::find($data['id_pedido']);
        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido no encontrado.');
        }

        // Verificar que el usuario en sesión es el dueño
        if (!session('usuario_id') || session('usuario_id') != $pedido->id_usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión como el cliente dueño del pedido para registrar pagos.');
        }

        DB::beginTransaction();
        try {
            $pago = Pago::create([
                'id_pedido' => $data['id_pedido'],
                'metodo' => $data['metodo'],
                'monto' => $data['monto'],
                'fecha_pago' => now(),
            ]);

            $sumaPagos = $pedido->pagos()->sum('monto');
            if ($sumaPagos >= $pedido->total) {
                $pedido->update(['estado' => 'pagado']);
            }

            DB::commit();
            return redirect()->route('order.show', $data['id_pedido'])->with('success', 'Pago registrado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'No se pudo registrar el pago: ' . $e->getMessage());
        }
    }

    private function handleRedirect($pedido, $id_pedido)
    {
        // Si el pago fue registrado por el cliente dueño del pedido, redirigir a la vista pública
        $pedidoOwnerId = $pedido->id_usuario ?? null;
        if (session('usuario_id') && session('usuario_id') == $pedidoOwnerId) {
            return redirect()->route('order.show', $id_pedido)->with('success', 'Pago registrado correctamente.');
        }

        return redirect()->route('pedidos.show', $id_pedido)->with('success', 'Pago registrado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pedidoId = $pago->id_pedido;
        $pago->delete();
        return redirect()->route('pedidos.show', $pedidoId)->with('success', 'Pago eliminado.');
    }
}
