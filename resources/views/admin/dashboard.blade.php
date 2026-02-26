@extends('layouts.base')
@section('title', 'Panel de administración - Pordede')
@section('content')

<div class="container py-4">
    <h1 class="text-white fw-bold mb-4 border-start border-danger border-4 ps-3">
        <i class="bi bi-speedometer2"></i> Panel de Administración
    </h1>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card bg-dark border-danger border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1"><i class="bi bi-film"></i> Películas</p>
                            <h2 class="text-white mb-0">{{ \App\Models\pelicula::count() }}</h2>
                        </div>
                        <i class="bi bi-film display-4 text-secondary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark border-warning border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1"><i class="bi bi-tags"></i> Géneros</p>
                            <h2 class="text-white mb-0">{{ \App\Models\genero::count() }}</h2>
                        </div>
                        <i class="bi bi-tags display-4 text-secondary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark border-info border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1"><i class="bi bi-people"></i> Usuarios</p>
                            <h2 class="text-white mb-0">{{ \App\Models\User::count() }}</h2>
                        </div>
                        <i class="bi bi-people display-4 text-secondary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark border-success border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small mb-1"><i class="bi bi-gift"></i> Promociones</p>
                            <h2 class="text-white mb-0">{{ \App\Models\Promocion::count() }}</h2>
                        </div>
                        <i class="bi bi-gift display-4 text-secondary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Actions -->
    <h2 class="text-white fw-bold mb-4 border-start border-warning border-4 ps-3">Gestión</h2>

    <div class="row g-4 mb-5">
        <!-- Movies Card -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-film display-3 text-danger mb-3"></i>
                    <h4 class="text-white">Gestionar Películas</h4>
                    <p class="text-secondary flex-grow-1">Crear, editar y eliminar películas de la cartelera</p>
                    <a href="{{ route('peliculas.index') }}" class="btn btn-danger w-100">
                        <i class="bi bi-arrow-right"></i> Ir a Películas
                    </a>
                </div>
            </div>
        </div>

        <!-- Genres Card -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-tags display-3 text-warning mb-3"></i>
                    <h4 class="text-white">Gestionar Géneros</h4>
                    <p class="text-secondary flex-grow-1">Crear, editar y eliminar géneros de películas</p>
                    <a href="{{ route('generos.index') }}" class="btn btn-warning w-100">
                        <i class="bi bi-arrow-right"></i> Ir a Géneros
                    </a>
                </div>
            </div>
        </div>

        <!-- Promotions Card -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <i class="bi bi-gift display-3 text-success mb-3"></i>
                    <h4 class="text-white">Gestionar Promociones</h4>
                    <p class="text-secondary flex-grow-1">Crear y administrar promociones activas</p>
                    <a href="{{ route('promociones.index') }}" class="btn btn-success w-100">
                        <i class="bi bi-arrow-right"></i> Ir a Promociones
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('inicio') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left"></i> Volver al catálogo
    </a>
</div>

@endsection
