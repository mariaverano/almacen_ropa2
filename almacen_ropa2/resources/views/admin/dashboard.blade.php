@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Panel de Administración</h2>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card p-3 card-stats">
                    <div class="card-body">
                        <h6>Productos</h6>
                        <h3>{{ $stats['productos'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 card-stats">
                    <div class="card-body">
                        <h6>Categorías</h6>
                        <h3>{{ $stats['categorias'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 card-stats">
                    <div class="card-body">
                        <h6>Pedidos</h6>
                        <h3>{{ $stats['pedidos'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 card-stats">
                    <div class="card-body">
                        <h6>Usuarios</h6>
                        <h3>{{ $stats['usuarios'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 card-stats">
                    <div class="card-body">
                        <h6>Ventas (total)</h6>
                        <h3>${{ number_format($stats['ventas_total'] ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Productos recientes</div>
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Categoría</th></tr>
                    </thead>
                    <tbody>
                    @forelse($recentProductos as $p)
                        <tr>
                            <td>{{ $p->id_producto }}</td>
                            <td>{{ $p->nombre_producto }}</td>
                            <td>${{ number_format($p->precio,2) }}</td>
                            <td>{{ $p->categoria->nombre_categoria ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No hay productos recientes.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
