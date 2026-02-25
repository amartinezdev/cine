@extends('layouts.base')
@section('title', 'Editar película - Pordede')
@section('content')

    <div class="container py-4">
        <h1 class="text-white fw-bold mb-4 border-start border-danger border-4 ps-3">
            <i class="bi bi-pencil"></i> Editar Película
        </h1>

        <div class="card bg-dark border-secondary">
            <div class="card-body">
                <form action="{{ route('peliculas.actualizar', $pelicula->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $pelicula->titulo) }}" required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="genero_id" class="form-label">Género</label>
                            <select id="genero_id" name="genero_id" class="form-select @error('genero_id') is-invalid @enderror" required>
                                @foreach($generos as $genero)
                                    <option value="{{ $genero->id }}" @selected(old('genero_id', $pelicula->genero_id) == $genero->id)>{{ $genero->nombre }}</option>
                                @endforeach
                            </select>
                            @error('genero_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="duracion" class="form-label">Duración (minutos)</label>
                            <input type="number" id="duracion" name="duracion" class="form-control @error('duracion') is-invalid @enderror" value="{{ old('duracion', $pelicula->duracion) }}" required>
                            @error('duracion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="precio_entrada" class="form-label">Precio Entrada (€)</label>
                        <input type="number" step="0.01" id="precio_entrada" name="precio_entrada" class="form-control @error('precio_entrada') is-invalid @enderror" value="{{ old('precio_entrada', $pelicula->precio_entrada) }}" required>
                        @error('precio_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="sipnosis" class="form-label">Sinopsis</label>
                        <textarea id="sipnosis" name="sipnosis" class="form-control @error('sipnosis') is-invalid @enderror" rows="5" required>{{ old('sipnosis', $pelicula->sipnosis) }}</textarea>
                        @error('sipnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="poster" class="form-label">Póster (Imagen)</label>
                        @if($pelicula->getFirstMediaUrl('poster'))
                            <div class="mb-2">
                                <img src="{{ $pelicula->getFirstMediaUrl('poster') }}" alt="Póster actual de {{ $pelicula->titulo }}" class="rounded border border-secondary" style="max-width: 150px;">
                            </div>
                        @endif
                        <input type="file" id="poster" name="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*">
                        <div class="form-text">JPEG, PNG, JPG o GIF, hasta 1&nbsp;MB. Déjalo vacío para conservar el póster actual.</div>
                        @error('poster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-check-lg"></i> Actualizar Película</button>
                        <a href="{{ route('peliculas.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
