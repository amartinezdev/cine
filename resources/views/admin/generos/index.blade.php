@extends('layouts.base')
@section('title', 'Gestionar géneros - Pordede')
@section('content')

<div class="container py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="border-l-4 border-warning pl-3 text-2xl font-bold tracking-tight text-foreground">Gestionar Géneros</h1>
        <x-ui.button href="{{ route('generos.create') }}" class="bg-warning text-warning-foreground hover:bg-warning/90"><i class="bi bi-plus-lg"></i> Añadir Género</x-ui.button>
    </div>

    @if(session('info'))
        <x-ui.alert variant="success" dismissible class="mb-5"><i class="bi bi-check-circle mt-0.5"></i> <p>{{ session('info') }}</p></x-ui.alert>
    @endif

    @if(session('error'))
        <x-ui.alert variant="destructive" dismissible class="mb-5"><i class="bi bi-exclamation-triangle mt-0.5"></i> <p>{{ session('error') }}</p></x-ui.alert>
    @endif

    @if($generos->count() > 0)
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($generos as $genero)
                <x-ui.card hover
                    class="border-l-4 border-l-warning animate-fade-up motion-reduce:animate-none"
                    style="animation-delay: {{ min($loop->index, 8) * 0.06 }}s"
                >
                    <x-ui.card.content class="p-5">
                        <h5 class="mb-1 text-lg font-semibold text-foreground"><i class="bi bi-tags text-warning"></i> {{ $genero->nombre }}</h5>
                        <p class="mb-4 text-sm text-muted-foreground"><i class="bi bi-film"></i> {{ $genero->peliculas->count() }} películas</p>
                        <div class="flex gap-2">
                            <x-ui.button href="{{ route('generos.edit', $genero->id) }}" variant="outline" size="sm" class="flex-1"><i class="bi bi-pencil"></i> Editar</x-ui.button>
                            <form action="{{ route('generos.delete', $genero->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Eliminar este género?');">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" variant="outline" size="sm" class="w-full text-destructive hover:bg-destructive/10"><i class="bi bi-trash"></i> Eliminar</x-ui.button>
                            </form>
                        </div>
                    </x-ui.card.content>
                </x-ui.card>
            @endforeach
        </div>
    @else
        <div class="animate-fade-up motion-reduce:animate-none py-16 text-center">
            <i class="bi bi-tags text-6xl text-muted-foreground mr-0"></i>
            <h4 class="mt-4 text-xl font-semibold text-foreground">No hay géneros</h4>
            <p class="text-muted-foreground">Crea géneros para clasificar tus películas.</p>
            <x-ui.button href="{{ route('generos.create') }}" class="mt-4 bg-warning text-warning-foreground hover:bg-warning/90"><i class="bi bi-plus-lg"></i> Crear Género</x-ui.button>
        </div>
    @endif
</div>

@endsection
