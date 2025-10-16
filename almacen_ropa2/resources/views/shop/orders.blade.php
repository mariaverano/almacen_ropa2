@extends('layouts.shop')

@section('title','Mis pedidos')

@section('content')
    <div class="card p-4">
        <h3>Mis pedidos</h3>
        @if($pedidos->isEmpty())
            <p>No has realizado pedidos todavía.</p>
        @else
            <table class="table">
                <thead><tr><th>ID</th><th>Fecha</th><th>Estado</th><th>Total</th><th>Acciones</th></tr></thead>
                <tbody>
                @foreach($pedidos as $p)
                    <tr>
                        <td>#{{ $p->id_pedido }}</td>
                        <td>{{ $p->fecha_pedido }}</td>
                        <td>{{ $p->estado }}</td>
                        <td>${{ number_format($p->total,2) }}</td>
                        <td><a href="{{ route('order.show', $p->id_pedido) }}" class="btn btn-sm btn-primary">Ver</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
