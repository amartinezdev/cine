@extends('layouts.base')
@section('title', 'Crear película - Pordede')
@section('content')

    <div class="container py-4">
        <h1 class="text-white fw-bold mb-4 border-start border-danger border-4 ps-3">
            <i class="bi bi-film"></i> Crear Película
        </h1>

        <div class="card bg-dark border-secondary">
            <div class="card-body">
                <form action="{{ route('peliculas.crear') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="genero_id" class="form-label">Género</label>
                            <select id="genero_id" name="genero_id" class="form-select @error('genero_id') is-invalid @enderror" required>
                                <option value="">Selecciona un género</option>
                                @foreach($generos as $genero)
                                    <option value="{{ $genero->id }}" @selected(old('genero_id') == $genero->id)>{{ $genero->nombre }}</option>
                                @endforeach
                            </select>
                            @error('genero_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="duracion" class="form-label">Duración (minutos)</label>
                            <input type="number" id="duracion" name="duracion" class="form-control @error('duracion') is-invalid @enderror" value="{{ old('duracion') }}" required>
                            @error('duracion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="precio_entrada" class="form-label">Precio Entrada (€)</label>
                        <input type="number" step="0.01" id="precio_entrada" name="precio_entrada" class="form-control @error('precio_entrada') is-invalid @enderror" value="{{ old('precio_entrada') }}" required>
                        @error('precio_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="sipnosis" class="form-label">Sinopsis</label>
                        <textarea id="sipnosis" name="sipnosis" class="form-control @error('sipnosis') is-invalid @enderror" rows="5" required>{{ old('sipnosis') }}</textarea>
                        @error('sipnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="poster" class="form-label">Póster (Imagen)</label>
                        <input type="file" id="poster" name="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*">
                        <div class="form-text">JPEG, PNG, JPG o GIF, hasta 1&nbsp;MB.</div>
                        @error('poster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-plus-lg"></i> Crear Película</button>
                        <a href="{{ route('peliculas.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
