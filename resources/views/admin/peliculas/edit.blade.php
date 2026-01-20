@extends('layouts.base')
@section('content')

    <div class="container mt-5">
        <h1>Editar Película</h1>

        <form action="{{ route('peliculas.actualizar', $pelicula->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ $pelicula->titulo }}" required>
                @error('titulo')<span class="text-danger">El título es requerido</span>@enderror
            </div>

            <div class="mb-3">
                <label>Género</label>
                <select name="genero_id" class="form-control" required>
                    @foreach($generos as $genero)
                        <option value="{{ $genero->id }}" @selected($pelicula->genero_id == $genero->id)>{{ $genero->nombre }}</option>
                    @endforeach
                </select>
                @error('genero_id')<span class="text-danger">Debes seleccionar un género</span>@enderror
            </div>

            <div class="mb-3">
                <label>Duración (minutos)</label>
                <input type="number" name="duracion" class="form-control" value="{{ $pelicula->duracion }}" required>
                @error('duracion')<span class="text-danger">La duración debe ser un número mayor a 0</span>@enderror
            </div>

            <div class="mb-3">
                <label>Precio Entrada (€)</label>
                <input type="number" step="0.01" name="precio_entrada" class="form-control" value="{{ $pelicula->precio_entrada }}" required>
                @error('precio_entrada')<span class="text-danger">El precio debe ser un número mayor a 0</span>@enderror
            </div>

            <div class="mb-3">
                <label>Sinopsis</label>
                <textarea name="sipnosis" class="form-control" rows="5" required>{{ $pelicula->sipnosis }}</textarea>
                @error('sipnosis')<span class="text-danger">La sinopsis es requerida</span>@enderror
            </div>

            <div class="mb-3">
                <label>Póster (Imagen)</label>
                @if($pelicula->getFirstMediaUrl('poster'))
                    <div class="mb-2">
                        <img src="{{ $pelicula->getFirstMediaUrl('poster') }}" alt="Póster" style="max-width: 150px;">
                    </div>
                @endif
                <input type="file" name="poster" class="form-control" accept="image/*">
                @error('poster')<span class="text-danger">El archivo debe ser una imagen (JPEG, PNG, JPG, GIF) menor a 2MB</span>@enderror
            </div>

            <button type="submit" class="btn btn-success">Actualizar Película</button>
            <a href="{{ route('peliculas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

@endsection
