@extends('layouts.shop')

@section('title','Carrito')

@section('content')
    <h3>Carrito</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($cart))
        <div class="alert alert-info">El carrito está vacío.</div>
    @else
        <table class="table">
            <thead>
                <tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>${{ number_format($item['precio'],2) }}</td>
                        <td>${{ number_format($subtotal,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><th colspan="3">Total</th><th>${{ number_format($total,2) }}</th></tr>
            </tfoot>
        </table>

        <h4>Checkout</h4>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label>Nombre</label>
                <input name="nombre" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Dirección</label>
                <input name="direccion" class="form-control" required>
            </div>
            <button class="btn btn-success">Realizar pedido</button>
        </form>
    @endif

@endsection
