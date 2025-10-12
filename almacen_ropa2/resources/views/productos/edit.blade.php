<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <h2 class="mb-4 text-center">✏️ Editar Producto</h2>

    <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre_producto" class="form-control" value="{{ $producto->nombre_producto }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" class="form-control" step="0.01" value="{{ $producto->precio }}" required>
        </div>

        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" value="{{ $producto->stock }}" required>
        </div>

        <div class="mb-3">
            <label>Categoría:</label>
            <select name="id_categoria" class="form-select" required>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}" {{ $producto->id_categoria == $cat->id_categoria ? 'selected' : '' }}>
                        {{ $cat->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Imagen:</label>
            <input type="text" name="imagen" class="form-control" value="{{ $producto->imagen }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
