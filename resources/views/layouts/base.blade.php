<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pordede - Plataforma de Cine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-black">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-danger">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="{{ route('inicio') }}">
                <i class="bi bi-film"></i> PORDEDE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inicio') }}">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->admin)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear"></i> Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="{{ route('peliculas.index') }}"><i class="bi bi-film"></i> Películas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('generos.index') }}"><i class="bi bi-tags"></i> Géneros</a></li>
                                    <li><a class="dropdown-item" href="{{ route('promociones.index') }}"><i class="bi bi-gift"></i> Promociones</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                                </ul>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item me-3">
                            <span class="text-warning">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-danger p-0">
                                    <i class="bi bi-box-arrow-right"></i> Salir
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Ingresar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Promociones -->
    @if(isset($promocionesActivas) && $promocionesActivas->count() > 0)
        <div class="container mt-4">
            @foreach($promocionesActivas as $promocion)
                <div class="alert alert-danger border-danger d-flex align-items-center" role="alert">
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">
                            <i class="bi bi-star-fill"></i> {{ $promocion->titulo }}
                        </h5>
                        <p class="mb-1">{{ $promocion->mensaje }}</p>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> Válido hasta {{ $promocion->fecha_fin}}
                        </small>
                    </div>
                    <a href="{{ route('inicio') }}" class="btn btn-outline-light btn-sm ms-3">
                        Ver películas <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <!-- main -->
    <main class="pb-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark border-top border-secondary mt-5 py-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <span class="text-danger fw-bold"><i class="bi bi-film"></i> PORDEDE</span>
                    <span class="text-secondary ms-2">| Tu cine en casa</span>
                </div>
                <div class="mb-3 mb-md-0">
                    <a href="#" class="text-secondary me-3 text-decoration-none"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-secondary me-3 text-decoration-none"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-secondary text-decoration-none"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <hr class="border-secondary my-3">
            <p class="text-secondary small text-center mb-0">&copy; 2026 Pordede. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
