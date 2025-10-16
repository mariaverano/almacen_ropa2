@extends('layouts.admin')

@section('title', 'Pagos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pagos</h2>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>id_pago</th>
                <th>id_pedido</th>
                <th>metodo</th>
                <th>monto</th>
                <th>fecha_pago</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $p)
                <tr>
                    <td>{{ $p->id_pago }}</td>
                    <td><a href="{{ route('pedidos.show', $p->id_pedido) }}">{{ $p->id_pedido }}</a></td>
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
@endsection
