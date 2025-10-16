@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📚 Categorías</h2>
        <a href="{{ route('categorias.create') }}" class="btn btn-success">➕ Nueva Categoría</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Listado de Categorías</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>id_categoria</th>
                            <th>nombre_categoria</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id_categoria }}</td>
                                <td>{{ $categoria->nombre_categoria }}</td>
                                <td>
                                    <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No hay categorías aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
