@extends('layouts.base')
@section('title', 'Iniciar sesión - Pordede')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark border-secondary shadow-lg">
                <div class="card-header border-secondary">
                    <h3 class="mb-0 text-white"><i class="bi bi-box-arrow-in-right text-danger"></i> Iniciar Sesión</h3>
                </div>
                <div class="card-body p-4 text-white">
                    <div class="alert alert-info small mb-4">
                        <strong><i class="bi bi-info-circle"></i> Credenciales de prueba</strong>
                        <div class="mt-2">
                            <strong>Admin:</strong> admin@demo.com &nbsp;/&nbsp; CineDemo2026!<br>
                            <strong>Usuario:</strong> user@demo.com &nbsp;/&nbsp; CineDemo2026!
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Recuérdame
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                            <button type="submit" class="btn btn-danger"><i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer border-secondary text-center text-secondary">
                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-decoration-none">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
