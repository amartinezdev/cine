@extends('layouts.base')
@section('title', 'Gestionar géneros - Pordede')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white fw-bold border-start border-warning border-4 ps-3">Gestionar Géneros</h1>
        <a href="{{ route('generos.create') }}" class="btn btn-warning">
            <i class="bi bi-plus-lg"></i> Añadir Género
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

    @if($generos->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($generos as $genero)
                <div class="col">
                    <div class="card bg-dark border-warning h-100">
                        <div class="card-body">
                            <h5 class="card-title text-white">
                                <i class="bi bi-tags text-warning"></i> {{ $genero->nombre }}
                            </h5>
                            <p class="card-text text-secondary">
                                <i class="bi bi-film"></i> {{ $genero->peliculas->count() }} películas
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('generos.edit', $genero->id) }}" class="btn btn-outline-warning btn-sm flex-grow-1">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('generos.delete', $genero->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('¿Eliminar este género?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-tags display-1 text-secondary"></i>
            <h4 class="text-white mt-3">No hay géneros</h4>
            <p class="text-secondary">Crea géneros para clasificar tus películas.</p>
            <a href="{{ route('generos.create') }}" class="btn btn-warning mt-3">
                <i class="bi bi-plus-lg"></i> Crear Género
            </a>
        </div>
    @endif
</div>

@endsection
