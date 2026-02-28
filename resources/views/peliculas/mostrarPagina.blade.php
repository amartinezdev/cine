@extends('layouts.base')
@section('title', $pelicula->titulo . ' - Pordede')
@section('meta_description', Str::limit($pelicula->sipnosis, 150))
@section('content')

@php
    $posterUrl = $pelicula->getFirstMediaUrl('poster');
@endphp

@if($posterUrl)
    <div class="absolute inset-x-0 top-0 h-[420px] overflow-hidden">
        <div class="absolute -inset-5 bg-cover bg-[center_15%] blur-xl brightness-[.45] saturate-150" style="background-image: url('{{ $posterUrl }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-background/10 to-background"></div>
    </div>
@endif

<div class="container relative py-4 {{ $posterUrl ? 'pt-12' : '' }}">
    <nav aria-label="breadcrumb" class="mb-6 flex items-center gap-2 text-sm text-muted-foreground">
        <a href="{{ route('inicio') }}" class="text-primary hover:underline">Inicio</a>
        <span>/</span>
        <a href="{{ route('inicio', ['genero_id' => $pelicula->genero_id]) }}" class="text-primary hover:underline">{{ $pelicula->genero->nombre }}</a>
        <span>/</span>
        <span class="text-foreground">{{ $pelicula->titulo }}</span>
    </nav>

    <div class="mb-12 grid grid-cols-1 gap-8 md:grid-cols-12">
        <div class="md:col-span-4">
            <x-ui.card class="overflow-hidden">
                @if($posterUrl)
                    <img src="{{ $posterUrl }}" alt="{{ $pelicula->titulo }}" class="w-full opacity-0 transition-opacity duration-200 ease-out" onload="this.classList.remove('opacity-0')">
                @else
                    <div class="flex h-[500px] items-center justify-center bg-secondary">
                        <i class="bi bi-image text-6xl text-muted-foreground mr-0"></i>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <div class="md:col-span-8">
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h1 class="mb-2 text-3xl font-bold tracking-tight text-foreground">{{ $pelicula->titulo }}</h1>
                    <x-ui.badge variant="warning"><i class="bi bi-tags"></i> {{ $pelicula->genero->nombre }}</x-ui.badge>
                </div>
                @auth
                    @if(auth()->user()->admin)
                        <x-ui.button href="{{ route('peliculas.edit', $pelicula->id) }}" variant="outline"><i class="bi bi-pencil"></i> Editar</x-ui.button>
                    @endif
                @endauth
            </div>

            <div class="mb-6 flex flex-wrap gap-3 animate-fade-up motion-reduce:animate-none">
                <div class="rounded-lg border border-border bg-card p-3 text-center">
                    <i class="bi bi-clock mb-1 block text-xl text-primary"></i>
                    <span class="font-bold text-foreground">{{ $pelicula->duracion }}</span>
                    <span class="block text-xs text-muted-foreground">minutos</span>
                </div>
                <div class="rounded-lg border border-border bg-card p-3 text-center">
                    <i class="bi bi-star-fill mb-1 block text-xl text-warning"></i>
                    <span class="font-bold text-foreground">{{ number_format($pelicula->valoracion, 1) }}</span>
                    <span class="block text-xs text-muted-foreground">puntuación</span>
                </div>
                <div class="rounded-lg bg-primary p-3 text-center">
                    <i class="bi bi-ticket-perforated mb-1 block text-xl text-primary-foreground"></i>
                    <span class="font-bold text-primary-foreground">{{ number_format($pelicula->precio_entrada, 2) }}€</span>
                    <span class="block text-xs text-primary-foreground/80">entrada</span>
                </div>
            </div>

            <div class="mb-6">
                <h4 class="mb-3 border-l-4 border-primary pl-3 text-lg font-semibold text-foreground">Sinopsis</h4>
                <p class="text-lg leading-relaxed text-muted-foreground">{{ $pelicula->sipnosis }}</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <x-ui.dialog>
                    <x-slot:trigger>
                        <x-ui.button size="lg" type="button"><i class="bi bi-ticket-perforated"></i> Comprar Entrada</x-ui.button>
                    </x-slot:trigger>
                    <div class="p-6 text-center">
                        <i class="bi bi-gear-wide-connected mb-3 block text-5xl text-warning mr-0"></i>
                        <p class="mb-2 text-lg font-semibold text-foreground">Esta funcionalidad está en desarrollo</p>
                        <p class="text-sm text-muted-foreground">Estamos trabajando para ofrecerte esta característica muy pronto. ¡Gracias por tu paciencia!</p>
                        <x-ui.button @click="open = false" class="mt-4">Entendido</x-ui.button>
                    </div>
                </x-ui.dialog>

                <x-ui.dialog>
                    <x-slot:trigger>
                        <x-ui.button size="lg" variant="outline" type="button"><i class="bi bi-heart"></i> Añadir a Favoritos</x-ui.button>
                    </x-slot:trigger>
                    <div class="p-6 text-center">
                        <i class="bi bi-gear-wide-connected mb-3 block text-5xl text-warning mr-0"></i>
                        <p class="mb-2 text-lg font-semibold text-foreground">Esta funcionalidad está en desarrollo</p>
                        <p class="text-sm text-muted-foreground">Estamos trabajando para ofrecerte esta característica muy pronto. ¡Gracias por tu paciencia!</p>
                        <x-ui.button @click="open = false" class="mt-4">Entendido</x-ui.button>
                    </div>
                </x-ui.dialog>

                <x-ui.dialog>
                    <x-slot:trigger>
                        <x-ui.button size="lg" variant="outline" type="button"><i class="bi bi-share"></i> Compartir</x-ui.button>
                    </x-slot:trigger>
                    <div class="p-6 text-center">
                        <i class="bi bi-gear-wide-connected mb-3 block text-5xl text-warning mr-0"></i>
                        <p class="mb-2 text-lg font-semibold text-foreground">Esta funcionalidad está en desarrollo</p>
                        <p class="text-sm text-muted-foreground">Estamos trabajando para ofrecerte esta característica muy pronto. ¡Gracias por tu paciencia!</p>
                        <x-ui.button @click="open = false" class="mt-4">Entendido</x-ui.button>
                    </div>
                </x-ui.dialog>
            </div>
        </div>
    </div>

    <x-ui.card class="mb-12 animate-fade-up motion-reduce:animate-none" style="animation-delay: .06s">
        <x-ui.card.header>
            <x-ui.card.title><i class="bi bi-info-circle text-primary"></i> Información Adicional</x-ui.card.title>
        </x-ui.card.header>
        <x-ui.card.content class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <p class="mb-2"><span class="text-muted-foreground">Género:</span> <span class="text-foreground">{{ $pelicula->genero->nombre }}</span></p>
                <p class="mb-2"><span class="text-muted-foreground">Duración:</span> <span class="text-foreground">{{ $pelicula->duracion }} minutos</span></p>
            </div>
            <div>
                <p class="mb-2"><span class="text-muted-foreground">Precio entrada:</span> <span class="text-foreground">{{ number_format($pelicula->precio_entrada, 2) }}€</span></p>
                <p class="mb-2"><span class="text-muted-foreground">Clasificación:</span> <span class="text-foreground">Todos los públicos</span></p>
            </div>
            <div>
                <p class="mb-2"><span class="text-muted-foreground">Añadida:</span> <span class="text-foreground">{{ $pelicula->created_at->format('d/m/Y') }}</span></p>
            </div>
        </x-ui.card.content>
    </x-ui.card>

    <x-ui.button href="{{ route('inicio') }}" variant="outline"><i class="bi bi-arrow-left"></i> Volver al catálogo</x-ui.button>
</div>

@endsection
