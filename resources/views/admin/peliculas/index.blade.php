@extends('layouts.base')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white fw-bold border-start border-danger border-4 ps-3">Gestionar Películas</h1>
        <a href="{{ route('peliculas.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-lg"></i> Añadir Película
        </a>
    </div>

    @if(session('info'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($peliculas->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead class="table-dark border-bottom border-danger">
                    <tr>
                        <th class="text-danger"><i class="bi bi-film"></i> Título</th>
                        <th class="text-danger"><i class="bi bi-tags"></i> Género</th>
                        <th class="text-danger"><i class="bi bi-clock"></i> Duración</th>
                        <th class="text-danger"><i class="bi bi-text-left"></i> Sinopsis</th>
                        <th class="text-danger">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peliculas as $pelicula)
                        <tr>
                            <td class="fw-bold">{{ $pelicula->titulo }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $pelicula->genero->nombre }}</span>
                            </td>
                            <td>{{ $pelicula->duracion }} min</td>
                            <td class="text-secondary small">{{ Str::limit($pelicula->sipnosis, 50) }}</td>
                            <td>
                                <a href="{{ route('peliculas.edit', $pelicula->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('peliculas.delete', $pelicula->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta película?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-film display-1 text-secondary"></i>
            <h4 class="text-white mt-3">No hay películas</h4>
            <p class="text-secondary">Agrega películas a tu catálogo de cine.</p>
            <a href="{{ route('peliculas.create') }}" class="btn btn-danger mt-3">
                <i class="bi bi-plus-lg"></i> Crear Película
            </a>
        </div>
    @endif
</div>

@endsection
