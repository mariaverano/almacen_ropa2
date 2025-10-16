<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <h2 class="mb-4 text-center">✏️ Editar Categoría</h2>

    <form action="{{ route('categorias.update', $categoria->id_categoria) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre de la categoría:</label>
            <input type="text" name="nombre_categoria" class="form-control @error('nombre_categoria') is-invalid @enderror" value="{{ old('nombre_categoria', $categoria->nombre_categoria) }}" maxlength="50" required>
            @error('nombre_categoria')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
