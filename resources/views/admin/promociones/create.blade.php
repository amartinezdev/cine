@extends('layouts.base')
@section('title', 'Crear promoción - Pordede')
@section('content')

    <div class="container py-4">
        <h1 class="text-white fw-bold mb-4 border-start border-danger border-4 ps-3">
            <i class="bi bi-gift"></i> Crear Promoción
        </h1>

        <div class="card bg-dark border-secondary">
            <div class="card-body">
                <form action="{{ route('promociones.crear') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la Promoción</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje" name="mensaje" rows="4" required>{{ old('mensaje') }}</textarea>
                        @error('mensaje')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha y Hora Inicio</label>
                                <input type="datetime-local" class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Fecha y Hora Fin</label>
                                <input type="datetime-local" class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-plus-lg"></i> Crear Promoción</button>
                        <a href="{{ route('promociones.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
