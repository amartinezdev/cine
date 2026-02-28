@extends('layouts.base')
@section('title', 'Crear película - Pordede')
@section('content')

<div class="container py-8">
    <h1 class="mb-6 flex items-center gap-2 border-l-4 border-primary pl-3 text-2xl font-bold tracking-tight text-foreground">
        <i class="bi bi-film"></i> Crear Película
    </h1>

    <x-ui.card class="max-w-2xl mx-auto">
        <x-ui.card.content class="p-6">
            <form action="{{ route('peliculas.crear') }}" method="POST" enctype="multipart/form-data" onsubmit="pdPending(this)">
                @csrf

                <div class="mb-5">
                    <x-ui.label for="titulo">Título</x-ui.label>
                    <x-ui.input type="text" name="titulo" value="{{ old('titulo') }}" required class="mt-1.5" />
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-[2fr_1fr]">
                    <div>
                        <x-ui.label for="genero_id">Género</x-ui.label>
                        <x-ui.select name="genero_id" required class="mt-1.5">
                            <option value="">Selecciona un género</option>
                            @foreach($generos as $genero)
                                <option value="{{ $genero->id }}" @selected(old('genero_id') == $genero->id)>{{ $genero->nombre }}</option>
                            @endforeach
                        </x-ui.select>
                    </div>
                    <div>
                        <x-ui.label for="duracion">Duración (min)</x-ui.label>
                        <x-ui.input type="number" name="duracion" value="{{ old('duracion') }}" required class="mt-1.5" />
                    </div>
                </div>

                <div class="mb-5">
                    <x-ui.label for="precio_entrada">Precio Entrada (€)</x-ui.label>
                    <x-ui.input type="number" step="0.01" name="precio_entrada" value="{{ old('precio_entrada') }}" required class="mt-1.5" />
                </div>

                <div class="mb-5">
                    <x-ui.label for="sipnosis">Sinopsis</x-ui.label>
                    <x-ui.textarea name="sipnosis" rows="5" required class="mt-1.5">{{ old('sipnosis') }}</x-ui.textarea>
                </div>

                <div class="mb-6">
                    <x-ui.label for="poster">Póster (Imagen)</x-ui.label>
                    <x-ui.input type="file" name="poster" accept="image/*" class="mt-1.5" />
                    <p class="mt-1.5 text-sm text-muted-foreground">JPEG, PNG, JPG o GIF, hasta 1&nbsp;MB.</p>
                </div>

                <div class="flex gap-2">
                    <x-ui.button type="submit"><i class="bi bi-plus-lg"></i> Crear Película</x-ui.button>
                    <x-ui.button href="{{ route('peliculas.index') }}" variant="outline"><i class="bi bi-arrow-left"></i> Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
