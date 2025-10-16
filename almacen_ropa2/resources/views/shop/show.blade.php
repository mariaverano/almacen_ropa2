@extends('layouts.shop')

@section('title', $producto->nombre_producto)

@section('content')
    <div class="row">
        <div class="col-md-6">
            @if($producto->imagenUrl())
                <img src="{{ $producto->imagenUrl() }}" class="img-fluid" alt="{{ $producto->nombre_producto }}">
            @else
                <img src="https://via.placeholder.com/800x600?text=No+image" class="img-fluid" alt="sin imagen">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $producto->nombre_producto }}</h2>
            <p class="text-muted">Categoria: {{ $producto->id_categoria }}</p>
            <h4>${{ number_format($producto->precio,2) }}</h4>
            <p>{{ $producto->descripcion }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="id" value="{{ $producto->id_producto }}">
                <div class="mb-2">
                    <label>Cantidad</label>
                    <input type="number" name="cantidad" value="1" min="1" max="{{ max(1,$producto->stock) }}" class="form-control" style="width:120px">
                </div>
                <button class="btn btn-primary">Añadir al carrito</button>
            </form>
        </div>
    </div>

@endsection
