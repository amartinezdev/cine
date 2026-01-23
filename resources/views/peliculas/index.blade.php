@extends('layouts.base')
@section('content')

<div class="container py-4">
    <!-- Search Section -->
    <h1 class="text-white fw-bold mb-4 border-start border-danger border-4 ps-3">Catálogo de Películas</h1>

    <form method="GET" action="{{ route('inicio') }}" class="row g-3 mb-5">
        <div class="col-lg-5">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-danger">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control bg-dark border-secondary text-white" name="titulo" placeholder="Buscar película..." value="{{ request('titulo') }}">
            </div>
        </div>
        <div class="col-lg-4">
            <select class="form-select bg-dark border-secondary text-white" name="genero_id">
                <option value="">Todos los géneros</option>
                @foreach($generos as $genero)
                    <option value="{{ $genero->id }}" @selected(request('genero_id') == $genero->id)>
                        {{ $genero->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 d-flex gap-2">
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
            <a href="{{ route('inicio') }}" class="btn btn-outline-light w-100">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>

    <!-- Movies Grid -->
    @if($peliculas->count() > 0)
        @php
            $peliculasPorGenero = $peliculas->groupBy('genero.nombre')->sortKeys();
        @endphp

        @foreach($peliculasPorGenero as $generoNombre => $peliculasPorGeneroActual)
            <section class="mb-5">
                <h2 class="text-white fw-bold mb-4 border-start border-warning border-4 ps-3">{{ $generoNombre }}</h2>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @foreach($peliculasPorGeneroActual as $pelicula)
                        <div class="col">
                            <div class="card bg-dark border-secondary h-100">
                                <!-- Póster (clickable) -->
                                <a href="{{ route('pelicula.mostrarPagina', $pelicula->id) }}">
                                    @if($pelicula->getFirstMediaUrl('poster'))
                                        <img src="{{ $pelicula->getFirstMediaUrl('poster') }}" class="card-img-top object-fit-cover" alt="{{ $pelicula->titulo }}" height="350">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 350px;">
                                            <i class="bi bi-image text-muted display-1"></i>
                                        </div>
                                    @endif
                                </a>

                                <!-- Cuerpo de la tarjeta -->
                                <div class="card-body d-flex flex-column">
                                    <a href="{{ route('pelicula.mostrarPagina', $pelicula->id) }}" class="text-decoration-none">
                                        <h5 class="card-title text-white fw-bold">{{ $pelicula->titulo }}</h5>
                                    </a>

                                    <p class="card-text text-secondary small mb-2">
                                        <i class="bi bi-clock"></i> {{ $pelicula->duracion }} min
                                        <span class="ms-2"><i class="bi bi-star-fill text-warning"></i> 8.5</span>
                                    </p>

                                    <p class="card-text text-secondary small flex-grow-1">
                                        {{ Str::limit($pelicula->sipnosis, 80) }}
                                    </p>

                                    <div class="d-flex gap-2 mb-2">
                                        <a href="{{ route('pelicula.mostrarPagina', $pelicula->id) }}" class="btn btn-outline-light btn-sm flex-grow-1">
                                            <i class="bi bi-eye"></i> Ver más
                                        </a>
                                    </div>

                                    <div class="d-flex gap-2 align-items-center mt-auto">
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            {{ number_format($pelicula->precio_entrada, 2) }}€
                                        </span>
                                        <button class="btn btn-danger btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#modalConstruccion">
                                            <i class="bi bi-ticket-perforated"></i> Comprar
                                        </button>
                                    </div>

                                    @auth
                                        @if(auth()->user()->admin)
                                            <div class="d-flex gap-2 mt-2">
                                                <a href="{{ route('peliculas.edit', $pelicula->id) }}" class="btn btn-outline-warning btn-sm flex-grow-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('peliculas.delete', $pelicula->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('¿Eliminar esta película?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="bi bi-search display-1 text-secondary"></i>
            <h4 class="text-white mt-3">No hay películas disponibles</h4>
            <p class="text-secondary">Intenta con otros términos de búsqueda o filtra por género diferente.</p>
            <a href="{{ route('inicio') }}" class="btn btn-danger mt-3">
                <i class="bi bi-arrow-counterclockwise"></i> Limpiar filtros
            </a>
        </div>
    @endif
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

@endsection
