@extends('layouts.shop')

@section('title', 'Pedido #' . $pedido->id_pedido)

@section('content')
    <div class="card p-4">
        <h3>Gracias por tu compra</h3>
        <p>Pedido #{{ $pedido->id_pedido }}</p>
        <p>Fecha: {{ $pedido->fecha_pedido }}</p>
        <p>Estado: <strong>{{ $pedido->estado }}</strong></p>

        <h5>Detalles</h5>
        <table class="table">
            <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio unit.</th><th>Subtotal</th></tr></thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($pedido->detalles as $d)
                    @php $subtotal = $d->precio_unitario * $d->cantidad; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $d->producto?->nombre_producto ?? '—' }}</td>
                        <td>{{ $d->cantidad }}</td>
                        <td>${{ number_format($d->precio_unitario,2) }}</td>
                        <td>${{ number_format($subtotal,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot><tr><th colspan="3">Total</th><th>${{ number_format($total,2) }}</th></tr></tfoot>
        </table>

        <h5>Pagos</h5>
        <ul>
            @foreach($pedido->pagos as $p)
                <li>{{ $p->metodo }} - ${{ number_format($p->monto,2) }} ({{ $p->fecha_pago }})</li>
            @endforeach
            @if($pedido->pagos->isEmpty())
                <li>No hay pagos registrados.</li>
            @endif
        </ul>

        @php $userId = session('usuario_id'); @endphp
        @if($userId && $pedido->id_usuario == $userId)
            <hr>
            <h5>Registrar pago</h5>
            <form action="{{ route('pagos.public.store') }}" method="POST" class="row g-2">
                @csrf
                <input type="hidden" name="id_pedido" value="{{ $pedido->id_pedido }}">
                <div class="col-md-4">
                    <label class="form-label">Método</label>
                    <input name="metodo" class="form-control" required placeholder="Ej: Transferencia">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Monto</label>
                    <input name="monto" type="number" step="0.01" min="0.01" class="form-control" required>
                </div>
                <div class="col-md-2 align-self-end">
                    <button class="btn btn-success">Registrar pago</button>
                </div>
            </form>
        @else
            <p class="text-muted">Si este es tu pedido, inicia sesión para registrar un pago.</p>
        @endif

        <a href="/shop" class="btn btn-link">Seguir comprando</a>
    </div>

@endsection
