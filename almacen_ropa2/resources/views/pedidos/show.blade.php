@extends('layouts.admin')

@section('title', 'Pedido #' . $pedido->id_pedido)

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h2>Pedido #{{ $pedido->id_pedido }}
                @if($pedido->estado)
                    <span class="badge bg-info text-dark ms-2">{{ $pedido->estado }}</span>
                @endif
            </h2>

            <p class="mb-1">Fecha: {{ $pedido->fecha_pedido ? $pedido->fecha_pedido->format('Y-m-d H:i') : '-' }}</p>
            <p class="mb-1">Canal: {{ $pedido->canal ?? '-' }}</p>
            <p class="mb-1">Cliente: {{ $pedido->usuario?->nombre ?? 'Cliente no registrado' }} @if($pedido->usuario)<small class="text-muted">({{ $pedido->usuario->correo }})</small>@endif</p>
        </div>

        <div class="text-end">
            <p class="mb-1">Total pedido: <strong>${{ number_format($pedido->total ?? 0,2) }}</strong></p>
            @php $pagos_total = $pedido->pagos->sum('monto'); @endphp
            <p class="mb-1">Pagos recibidos: <strong>${{ number_format($pagos_total,2) }}</strong></p>
            <p class="mb-1">Saldo: <strong>${{ number_format(max(0, ($pedido->total ?? 0) - $pagos_total),2) }}</strong></p>
            <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">Imprimir</button>
        </div>
    </div>

    <h4>Detalles</h4>
    <table class="table table-sm">
        <thead>
            <tr><th>Producto</th><th>Cant.</th><th>Precio unit.</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach($pedido->detalles as $d)
                <tr>
                    <td>{{ $d->producto?->nombre_producto ?? '—' }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>${{ number_format($d->precio_unitario,2) }}</td>
                    <td>${{ number_format($d->precio_unitario * $d->cantidad,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Pagos</h4>
    <table class="table table-sm">
        <thead><tr><th>Metodo</th><th>Monto</th><th>Fecha</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($pedido->pagos as $p)
                <tr>
                    <td>{{ $p->metodo }}</td>
                    <td>${{ number_format($p->monto,2) }}</td>
                    <td>{{ $p->fecha_pago }}</td>
                    <td>
                        <form action="{{ route('pagos.destroy', $p->id_pago) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar pago?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Registrar pago</h5>
    <form action="{{ route('pagos.store') }}" method="POST" class="row g-2 mb-3">
        @csrf
        <input type="hidden" name="id_pedido" value="{{ $pedido->id_pedido }}">
        <div class="col-auto">
            <input type="text" name="metodo" placeholder="Método (ej: efectivo)" class="form-control" required>
        </div>
        <div class="col-auto">
            <input type="number" step="0.01" name="monto" placeholder="Monto" class="form-control" required>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Registrar pago</button>
        </div>
    </form>

    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
@endsection
