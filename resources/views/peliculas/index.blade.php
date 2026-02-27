@extends('layouts.base')
@section('title', 'Pordede - Cartelera de Cine')
@section('meta_description', 'Explora la cartelera al completo: busca por título o filtra por género y descubre tu próxima película.')
@section('content')

<div class="container py-8">
    <h1 class="mb-6 border-l-4 border-primary pl-3 text-3xl font-bold text-foreground">Catálogo de Películas</h1>

    <form method="GET" action="{{ route('inicio') }}" class="mb-10 grid grid-cols-1 gap-3 lg:grid-cols-12">
        <div class="relative lg:col-span-5">
            <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-primary"></i>
            <x-ui.input type="text" name="titulo" placeholder="Buscar película..." value="{{ request('titulo') }}" class="pl-9" />
        </div>
        <div class="lg:col-span-4">
            <x-ui.select name="genero_id">
                <option value="">Todos los géneros</option>
                @foreach($generos as $genero)
                    <option value="{{ $genero->id }}" @selected(request('genero_id') == $genero->id)>{{ $genero->nombre }}</option>
                @endforeach
            </x-ui.select>
        </div>
        <div class="flex gap-2 lg:col-span-3">
            <x-ui.button type="submit" class="flex-1"><i class="bi bi-search"></i> Buscar</x-ui.button>
            <x-ui.button href="{{ route('inicio') }}" variant="outline" size="icon"><i class="bi bi-arrow-counterclockwise"></i></x-ui.button>
        </div>
    </form>

    @if($peliculas->count() > 0)
        @php
            $peliculasPorGenero = $peliculas->groupBy('genero.nombre')->sortKeys();
        @endphp

        @foreach($peliculasPorGenero as $generoNombre => $peliculasPorGeneroActual)
            <section class="mb-12">
                <h2 class="mb-5 border-l-4 border-warning pl-3 text-2xl font-bold text-foreground">{{ $generoNombre }}</h2>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($peliculasPorGeneroActual as $pelicula)
                        <x-ui.card hover
                            class="flex flex-col animate-fade-up motion-reduce:animate-none"
                            style="animation-delay: {{ min($loop->index, 8) * 0.06 }}s"
                        >
                            <a href="{{ route('pelicula.mostrarPagina', $pelicula->id) }}" class="block overflow-hidden rounded-t-lg">
                                @if($pelicula->getFirstMediaUrl('poster'))
                                    <img
                                        src="{{ $pelicula->getFirstMediaUrl('poster') }}"
                                        alt="{{ $pelicula->titulo }}"
                                        class="h-[350px] w-full object-cover opacity-0 transition-[opacity,transform] duration-200 ease-out motion-safe:[@media(hover:hover)_and_(pointer:fine)]:hover:scale-105"
                                        onload="this.classList.remove('opacity-0')"
                                    >
                                @else
                                    <div class="flex h-[350px] w-full items-center justify-center bg-secondary">
                                        <i class="bi bi-image text-6xl text-muted-foreground"></i>
                                    </div>
                                @endif
                            </a>

                            <x-ui.card.content class="flex flex-1 flex-col p-4">
                                <a href="{{ route('pelicula.mostrarPagina', $pelicula->id) }}" class="mb-1">
                                    <h3 class="font-bold text-foreground">{{ $pelicula->titulo }}</h3>
                                </a>

                                <p class="mb-2 flex items-center gap-3 text-xs text-muted-foreground">
                                    <span><i class="bi bi-clock"></i> {{ $pelicula->duracion }} min</span>
                                    <span><i class="bi bi-star-fill text-warning"></i> {{ number_format($pelicula->valoracion, 1) }}</span>
                                </p>

                                <p class="mb-3 flex-1 text-sm text-muted-foreground">{{ Str::limit($pelicula->sipnosis, 80) }}</p>

                                <x-ui.button href="{{ route('pelicula.mostrarPagina', $pelicula->id) }}" variant="outline" size="sm" class="mb-2 w-full">
                                    <i class="bi bi-eye"></i> Ver más
                                </x-ui.button>

                                <div class="mb-2 flex items-center gap-2">
                                    <x-ui.badge class="shrink-0 text-sm">{{ number_format($pelicula->precio_entrada, 2) }}€</x-ui.badge>

                                    <x-ui.dialog class="flex-1">
                                        <x-slot:trigger>
                                            <x-ui.button size="sm" class="w-full" type="button"><i class="bi bi-ticket-perforated"></i> Comprar</x-ui.button>
                                        </x-slot:trigger>

                                        <div class="p-6 text-center">
                                            <i class="bi bi-gear-wide-connected mb-3 block text-5xl text-warning"></i>
                                            <p class="mb-2 text-lg font-semibold text-foreground">Esta funcionalidad está en desarrollo</p>
                                            <p class="text-sm text-muted-foreground">Estamos trabajando para ofrecerte esta característica muy pronto. ¡Gracias por tu paciencia!</p>
                                            <x-ui.button @click="open = false" class="mt-4">Entendido</x-ui.button>
                                        </div>
                                    </x-ui.dialog>
                                </div>

                                @auth
                                    @if(auth()->user()->admin)
                                        <div class="flex gap-2">
                                            <x-ui.button href="{{ route('peliculas.edit', $pelicula->id) }}" variant="outline" size="sm" class="flex-1"><i class="bi bi-pencil"></i></x-ui.button>
                                            <form action="{{ route('peliculas.delete', $pelicula->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Eliminar esta película?');">
                                                @csrf
                                                @method('DELETE')
                                                <x-ui.button type="submit" variant="outline" size="sm" class="w-full text-destructive hover:bg-destructive/10"><i class="bi bi-trash"></i></x-ui.button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </x-ui.card.content>
                        </x-ui.card>
                    @endforeach
                </div>
            </section>
        @endforeach
    @else
        <div class="animate-fade-up motion-reduce:animate-none py-16 text-center">
            <i class="bi bi-search text-6xl text-muted-foreground"></i>
            <h4 class="mt-4 text-xl font-semibold text-foreground">No hay películas disponibles</h4>
            <p class="text-muted-foreground">Intenta con otros términos de búsqueda o filtra por género diferente.</p>
            <x-ui.button href="{{ route('inicio') }}" class="mt-4"><i class="bi bi-arrow-counterclockwise"></i> Limpiar filtros</x-ui.button>
        </div>
    @endif
</div>

@endsection
