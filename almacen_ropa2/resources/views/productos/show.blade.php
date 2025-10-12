<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $producto->nombre_producto }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image { max-width: 100%; height: auto; border-radius: 6px; }
        .product-card { box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="bg-light p-4">
<div class="container">
    <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">← Volver a productos</a>

    <div class="card product-card p-3">
        <div class="row g-3">
            <div class="col-md-5">
                @if($producto->imagen)
                    <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre_producto }}" class="product-image">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:300px; border-radius:6px;">
                        Sin imagen
                    </div>
                @endif
            </div>
            <div class="col-md-7">
                <h2>{{ $producto->nombre_producto }}</h2>
                <p class="text-muted">Categoría: {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}</p>
                <h3 class="text-primary">${{ number_format($producto->precio, 2) }}</h3>
                <p><strong>Stock:</strong> {{ $producto->stock }}</p>
                <hr>
                <p>{{ $producto->descripcion ?? 'Sin descripción disponible.' }}</p>

                <div class="mt-3">
                    <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-warning">Editar producto</a>
                    <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
