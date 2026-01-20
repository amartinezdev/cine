@extends('layouts.base')
@section('content')

    <div class="container mt-5">
        <h1 class="mb-4">Editar Género</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('generos.actualizar', $genero->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Género</label>
                        <input type="text" class="form-control is-invalid" id="nombre" name="nombre" value="{{ $genero->nombre }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">El nombre ya está en uso.</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Actualizar Género</button>
                        <a href="{{ route('generos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
