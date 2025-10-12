<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <h2 class="mb-4 text-center">➕ Crear Nuevo Producto</h2>

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre_producto" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Categoría:</label>
            <select name="id_categoria" class="form-select" required>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}">{{ $cat->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Imagen (nombre archivo):</label>
            <input type="text" name="imagen" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
