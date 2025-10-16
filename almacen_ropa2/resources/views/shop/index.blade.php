@extends('layouts.shop')

@section('title','Tienda')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Productos</h3>
        <form method="GET" class="d-flex" style="gap:.5rem">
            <input type="text" name="q" class="form-control" placeholder="Buscar..." value="{{ request('q') }}">
            <button class="btn btn-primary">Buscar</button>
        </form>
    </div>

    <div class="row g-3">
        @foreach($productos as $p)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card product-card">
                    @if($p->imagenUrl())
                        <img src="{{ $p->imagenUrl() }}" alt="{{ $p->nombre_producto }}">
                    @else
                        <img src="https://via.placeholder.com/400x300?text=No+image" alt="sin imagen">
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $p->nombre_producto }}</h6>
                        <p class="mb-1">${{ number_format($p->precio,2) }}</p>
                        <p class="mb-2 text-muted small">Categoria: {{ $p->id_categoria }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('shop.show', $p->id_producto) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $p->id_producto }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button class="btn btn-sm btn-primary">Añadir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">{{ $productos->withQueryString()->links() }}</div>

@endsection
