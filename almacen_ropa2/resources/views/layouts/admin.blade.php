<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fb; }
        /* Sidebar base (fixed) */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 220px;
            padding: 1rem;
            background: #2b2f36;
            color: #fff;
            transition: width .18s ease;
            z-index: 1000;
        }
        .sidebar a { color: rgba(255,255,255,0.95); text-decoration: none; }
        .sidebar .brand { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; display:flex; align-items:center; }
        .sidebar .brand .logo { width:38px; height:38px; border-radius:6px; background:#fff; color:#2b2f36; display:inline-flex; align-items:center; justify-content:center; font-weight:700; margin-right:8px; }
        .sidebar .brand .text { display:block; }
        .sidebar .brand small { display:block; font-size: .78rem; font-weight:400; color: rgba(255,255,255,0.85); }

        /* Collapsed sidebar */
        body.sidebar-collapsed .sidebar { width: 72px !important; }
        body.sidebar-collapsed .sidebar .brand .text { display: none; }
        body.sidebar-collapsed .sidebar .brand { justify-content:center; }
        body.sidebar-collapsed .sidebar .brand .logo { margin-right:0; }
        .nav-link { display:flex; align-items:center; gap:.5rem; color: rgba(255,255,255,0.95); padding:.45rem .6rem; }
        body.sidebar-collapsed .sidebar .nav-link { justify-content:center; padding: .55rem .25rem; }
        .nav-link .icon { font-size:1.25rem; line-height:1; }
        .nav-link .label { display:inline-block; }
        body.sidebar-collapsed .nav-link .label { display:none; }

        /* Main adjusts when sidebar collapsed or expanded */
        main.content { margin-left: 220px; transition: margin-left .18s ease; min-height:100vh; }
        body.sidebar-collapsed main.content { margin-left: 72px; }

        .card-stats { border-left: 6px solid #6c757d; }
        .card { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .table thead { background: #343a40; color: #fff; }
        .table tbody tr td { vertical-align: middle; }

        /* Toggle button */
        #sidebarToggle { background: transparent; border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.9); }

        /* Connected user block */
        .connected { position: absolute; bottom: 1rem; left: 1rem; right: 1rem; color: rgba(255,255,255,0.9); }
        .connected .name { font-weight:700; font-size:1rem; }
        body.sidebar-collapsed .connected { display: none; }

        /* Small fixes for page layout */
        .container-fluid { padding-left:0; padding-right:0; }
        .row { margin:0; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="sidebar p-3">
            <div class="brand mb-3">
                <div class="logo">MT</div>
                <div class="text">
                    <div>Mi Tienda</div>
                    <small>Panel</small>
                </div>
                <button id="sidebarToggle" class="btn btn-sm ms-auto" style="margin-left:auto;">☰</button>
            </div>
            <hr class="text-white-50">
            <ul class="nav flex-column mt-2">
                <li class="nav-item mb-2"><a href="{{ route('admin.dashboard') }}" class="nav-link"><span class="icon">🏠</span> <span class="label">Dashboard</span></a></li>
                <li class="nav-item mb-2"><a href="{{ route('productos.index') }}" class="nav-link"><span class="icon">🛒</span> <span class="label">Productos</span></a></li>
                <li class="nav-item mb-2"><a href="{{ route('categorias.index') }}" class="nav-link"><span class="icon">📂</span> <span class="label">Categorías</span></a></li>
                <li class="nav-item mb-2"><a href="{{ route('pedidos.index') }}" class="nav-link"><span class="icon">📦</span> <span class="label">Pedidos</span></a></li>
                <li class="nav-item mb-2"><a href="{{ route('pagos.index') }}" class="nav-link"><span class="icon">💳</span> <span class="label">Pagos</span></a></li>
            </ul>
            <div class="connected">
                @if(session('usuario_nombre'))
                    <small>Conectado como</small>
                    <div class="name">{{ session('usuario_nombre') }}</div>
                @endif
            </div>
        </nav>

        <main class="content p-4 position-relative">
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('¿Cerrar sesión?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Cerrar sesión</button>
                </form>
            </div>

            @yield('content')
        </main>
    </div>
</div>

<!-- Aplicar estado del sidebar lo antes posible para evitar parpadeo -->
<script>
    (function(){
        try{
            if(localStorage.getItem('sidebarCollapsed') === '1'){
                document.documentElement.classList.add('sidebar-collapsed');
                document.body.classList.add('sidebar-collapsed');
            }
        }catch(e){ /* ignore */ }
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function(){
        const toggle = document.getElementById('sidebarToggle');
        const body = document.body;
        toggle?.addEventListener('click', function(e){
            e.preventDefault();
            // Aplicar la clase tanto a documentElement como a body para mayor compatibilidad
            document.documentElement.classList.toggle('sidebar-collapsed');
            body.classList.toggle('sidebar-collapsed');
            const collapsed = body.classList.contains('sidebar-collapsed') ? '1' : '0';
            try{ localStorage.setItem('sidebarCollapsed', collapsed); }catch(e){}
        });
    })();
</script>
</body>
</html>
