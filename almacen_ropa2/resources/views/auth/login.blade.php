<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión - Mi Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjz4l9gENBO0LRn5q+8nb" crossorigin="anonymous">
    <style>
        body { background: #f8f9fb; }
        .login-card { max-width:420px; margin:8vh auto; }
        .card { border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
        .login-footer { font-size:.85rem; color:#6c757d; }
    </style>
</head>
<body>
    <div class="login-card">
            <div class="card p-4">
            <h4 class="mb-3">🔐 Iniciar Sesión</h4>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>

            <div class="mt-3 text-center login-footer">
                <small>Si no tienes credenciales, ejecuta el seeder de admin o contacta al administrador.</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjz4l9gENBO0LRn5q+8nb" crossorigin="anonymous"></script>
</body>
</html>
