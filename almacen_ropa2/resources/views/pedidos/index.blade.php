@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pedidos</h2>
        <a href="{{ route('pedidos.create') }}" class="btn btn-success">Nuevo Pedido</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>id_pedido</th>
                <th>fecha</th>
                <th>total</th>
                <th>detalles</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $p)
                <tr>
                    <td>{{ $p->id_pedido }}</td>
                    <td>{{ $p->fecha_pedido ?? '-' }}</td>
                    <td>${{ number_format($p->total ?? 0, 2) }}</td>
                    <td>{{ $p->detalles_count }}</td>
                    <td>
                        <a href="{{ route('pedidos.show', $p->id_pedido) }}" class="btn btn-sm btn-primary">Ver</a>
                        <form action="{{ route('pedidos.destroy', $p->id_pedido) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar pedido?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
