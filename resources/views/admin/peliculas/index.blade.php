@extends('layouts.base')
@section('title', 'Gestionar películas - Pordede')
@section('content')

<div class="container py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="flex items-center gap-2 border-l-4 border-primary pl-3 text-2xl font-bold tracking-tight text-foreground">Gestionar Películas</h1>
        <x-ui.button href="{{ route('peliculas.create') }}"><i class="bi bi-plus-lg"></i> Añadir Película</x-ui.button>
    </div>

    @if(session('info'))
        <x-ui.alert variant="success" dismissible class="mb-5"><i class="bi bi-check-circle mt-0.5"></i> <p>{{ session('info') }}</p></x-ui.alert>
    @endif

    @if(session('error'))
        <x-ui.alert variant="destructive" dismissible class="mb-5"><i class="bi bi-exclamation-triangle mt-0.5"></i> <p>{{ session('error') }}</p></x-ui.alert>
    @endif

    @if($peliculas->count() > 0)
        <x-ui.card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-border bg-secondary/40">
                        <tr>
                            <th class="p-3 font-semibold text-primary"><i class="bi bi-film"></i> Título</th>
                            <th class="p-3 font-semibold text-primary"><i class="bi bi-tags"></i> Género</th>
                            <th class="p-3 font-semibold text-primary"><i class="bi bi-clock"></i> Duración</th>
                            <th class="hidden p-3 font-semibold text-primary md:table-cell"><i class="bi bi-text-left"></i> Sinopsis</th>
                            <th class="p-3 font-semibold text-primary">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peliculas as $pelicula)
                            <tr class="border-b border-border transition-colors last:border-0 hover:bg-secondary/30">
                                <td class="p-3 font-semibold text-foreground">{{ $pelicula->titulo }}</td>
                                <td class="p-3"><x-ui.badge variant="warning">{{ $pelicula->genero->nombre }}</x-ui.badge></td>
                                <td class="p-3 text-muted-foreground">{{ $pelicula->duracion }} min</td>
                                <td class="hidden max-w-xs truncate p-3 text-muted-foreground md:table-cell">{{ Str::limit($pelicula->sipnosis, 50) }}</td>
                                <td class="p-3">
                                    <div class="flex gap-2">
                                        <x-ui.button href="{{ route('peliculas.edit', $pelicula->id) }}" variant="outline" size="sm"><i class="bi bi-pencil"></i> Editar</x-ui.button>
                                        <form action="{{ route('peliculas.delete', $pelicula->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta película?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button type="submit" variant="outline" size="sm" class="text-destructive hover:bg-destructive/10"><i class="bi bi-trash"></i> Eliminar</x-ui.button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    @else
        <div class="animate-fade-up motion-reduce:animate-none py-16 text-center">
            <i class="bi bi-film text-6xl text-muted-foreground"></i>
            <h4 class="mt-4 text-xl font-semibold text-foreground">No hay películas</h4>
            <p class="text-muted-foreground">Agrega películas a tu catálogo de cine.</p>
            <x-ui.button href="{{ route('peliculas.create') }}" class="mt-4"><i class="bi bi-plus-lg"></i> Crear Película</x-ui.button>
        </div>
    @endif
</div>

@endsection
