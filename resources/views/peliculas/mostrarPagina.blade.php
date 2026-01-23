@extends('layouts.base')
@section('content')

<div class="container py-4">
    <!-- Migas de pan -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio') }}" class="text-danger text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inicio', ['genero_id' => $pelicula->genero_id]) }}" class="text-danger text-decoration-none">{{ $pelicula->genero->nombre }}</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">{{ $pelicula->titulo }}</li>
        </ol>
    </nav>

    <!-- Detalle de la Película -->
    <div class="row g-4 mb-5">
        <!-- Póster -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                @if($pelicula->getFirstMediaUrl('poster'))
                    <img src="{{ $pelicula->getFirstMediaUrl('poster') }}" class="card-img-top" alt="{{ $pelicula->titulo }}">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 500px;">
                        <i class="bi bi-image text-muted display-1"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h1 class="text-white fw-bold mb-2">{{ $pelicula->titulo }}</h1>
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="bi bi-tags"></i> {{ $pelicula->genero->nombre }}
                    </span>
                </div>
                @auth
                    @if(auth()->user()->admin)
                        <a href="{{ route('peliculas.edit', $pelicula->id) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Estadísticas -->
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <div class="bg-dark border border-secondary rounded p-3 text-center">
                        <i class="bi bi-clock text-danger fs-4 d-block mb-1"></i>
                        <span class="text-white fw-bold">{{ $pelicula->duracion }}</span>
                        <small class="text-secondary d-block">minutos</small>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="bg-dark border border-secondary rounded p-3 text-center">
                        <i class="bi bi-star-fill text-warning fs-4 d-block mb-1"></i>
                        <span class="text-white fw-bold">8.5</span>
                        <small class="text-secondary d-block">puntuación</small>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="bg-danger rounded p-3 text-center">
                        <i class="bi bi-ticket-perforated text-white fs-4 d-block mb-1"></i>
                        <span class="text-white fw-bold">{{ number_format($pelicula->precio_entrada, 2) }}€</span>
                        <small class="text-white-50 d-block">entrada</small>
                    </div>
                </div>
            </div>

            <!-- Sinopsis -->
            <div class="mb-4">
                <h4 class="text-white border-start border-danger border-4 ps-3 mb-3">Sinopsis</h4>
                <p class="text-secondary lead">{{ $pelicula->sipnosis }}</p>
            </div>

            <!-- Acciones -->
            <div class="d-flex gap-3">
                <button class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#modalConstruccion">
                    <i class="bi bi-ticket-perforated"></i> Comprar Entrada
                </button>
                <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalConstruccion">
                    <i class="bi bi-heart"></i> Añadir a Favoritos
                </button>
                <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalConstruccion">
                    <i class="bi bi-share"></i> Compartir
                </button>
            </div>
        </div>
    </div>

    <!-- Modal En Construcción -->
    <div class="modal fade" id="modalConstruccion" tabindex="-1" aria-labelledby="modalConstruccionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-warning" id="modalConstruccionLabel">
                        <i class="bi bi-cone-striped"></i> En Construcción
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-gear-wide-connected text-warning display-1 mb-3 d-block"></i>
                    <p class="text-white fs-5 mb-2">Esta funcionalidad está en desarrollo</p>
                    <p class="text-secondary">Estamos trabajando para ofrecerte esta característica muy pronto. ¡Gracias por tu paciencia!</p>
                </div>
                <div class="modal-footer border-secondary justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-check-lg"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row g-4 mb-5">
        <div class="col-md-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-dark border-secondary">
                    <h5 class="mb-0 text-white"><i class="bi bi-info-circle text-danger"></i> Información Adicional</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-2">
                                <span class="text-secondary">Género:</span>
                                <span class="text-white">{{ $pelicula->genero->nombre }}</span>
                            </p>
                            <p class="mb-2">
                                <span class="text-secondary">Duración:</span>
                                <span class="text-white">{{ $pelicula->duracion }} minutos</span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-2">
                                <span class="text-secondary">Precio entrada:</span>
                                <span class="text-white">{{ number_format($pelicula->precio_entrada, 2) }}€</span>
                            </p>
                            <p class="mb-2">
                                <span class="text-secondary">Clasificación:</span>
                                <span class="text-white">Todos los públicos</span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-2">
                                <span class="text-secondary">Añadida:</span>
                                <span class="text-white">{{ $pelicula->created_at->format('d/m/Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón Volver -->
    <a href="{{ route('inicio') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left"></i> Volver al catálogo
    </a>
</div>

@endsection
