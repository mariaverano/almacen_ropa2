@extends('layouts.admin')

@section('title', 'Crear Pedido')

@section('content')
    <h2>Nuevo Pedido</h2>

    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Dirección de envío (opcional)</label>
            <input type="text" name="direccion_envio" class="form-control" value="{{ old('direccion_envio') }}">
        </div>

        <h5>Productos</h5>
        <div id="productos-list">
            @foreach($productos as $producto)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="productos[{{ $loop->index }}][id_producto]" value="{{ $producto->id_producto }}" id="prod{{ $producto->id_producto }}">
                    <label class="form-check-label" for="prod{{ $producto->id_producto }}">{{ $producto->nombre_producto }} (stock: {{ $producto->stock }}) - ${{ number_format($producto->precio,2) }}</label>
                    <input type="number" name="productos[{{ $loop->index }}][cantidad]" min="1" value="1" class="form-control w-25 d-inline-block ms-2" />
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary mt-3">Crear Pedido</button>
    </form>

    <a href="{{ route('pedidos.index') }}" class="btn btn-link mt-3">Volver</a>
@endsection
