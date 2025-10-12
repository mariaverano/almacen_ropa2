@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🛍️ Productos</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo Producto</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Productos recientes</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>id_producto</th>
                            <th>nombre_producto</th>
                            <th>precio</th>
                            <th>id_categoria</th>
                            <th>stock</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $p)
                            <tr>
                                <td>{{ $p->id_producto }}</td>
                                <td><a href="{{ route('productos.show', $p->id_producto) }}">{{ $p->nombre_producto }}</a></td>
                                <td>${{ number_format($p->precio, 2) }}</td>
                                <td>{{ $p->id_categoria ?? '-' }}</td>
                                <td>{{ $p->stock }}</td>
                                <td>
                                    <a href="{{ route('productos.edit', $p->id_producto) }}" class="btn btn-sm btn-outline-warning me-1">✏️</a>
                                    <form action="{{ route('productos.destroy', $p->id_producto) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este producto?')">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
