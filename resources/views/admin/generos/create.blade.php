@extends('layouts.base')
@section('title', 'Crear género - Pordede')
@section('content')

    <div class="container py-4">
        <h1 class="text-white fw-bold mb-4 border-start border-warning border-4 ps-3">
            <i class="bi bi-tags"></i> Crear Género
        </h1>

        <div class="card bg-dark border-secondary">
            <div class="card-body">
                <form action="{{ route('generos.crear') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Género</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">El nombre ya está en uso.</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-plus-lg"></i> Crear Género</button>
                        <a href="{{ route('generos.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
