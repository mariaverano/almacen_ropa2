<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Tienda') - Mi Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#f8f9fb; }
        .site-header{ background:#fff; border-bottom:1px solid #eee; }
        .logo { font-weight:700; color:#2b2f36; }
        .product-card img{ width:100%; height:180px; object-fit:cover; }
    </style>
</head>
<body>
<header class="site-header py-2">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="logo text-decoration-none" href="{{ route('shop.index') }}">Mi Tienda</a>
        <div class="d-flex align-items-center">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary me-2">Carrito ({{ count(session('cart',[])) }})</a>
            @if(session('usuario_id'))
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="accountMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ session('usuario_nombre') ?? 'Mi cuenta' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountMenu">
                        <li><a class="dropdown-item" href="{{ route('shop.myorders') }}">Mis pedidos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button class="dropdown-item" type="submit">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-link">Ingresar</a>
            @endif
        </div>
    </div>
</header>

<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="py-4 text-center text-muted">
    <small>Mi Tienda • Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
