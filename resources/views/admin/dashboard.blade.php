@extends('layouts.base')
@section('title', 'Panel de administración - Pordede')
@section('content')

<div class="container py-8">
    <h1 class="mb-8 flex items-center gap-2 border-l-4 border-primary pl-3 text-3xl font-bold text-foreground">
        <i class="bi bi-speedometer2"></i> Panel de Administración
    </h1>

    <div class="mb-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-ui.card class="border-l-4 border-l-primary">
            <x-ui.card.content class="flex items-center justify-between p-5">
                <div>
                    <p class="mb-1 text-sm text-muted-foreground"><i class="bi bi-film"></i> Películas</p>
                    <p class="text-2xl font-bold text-foreground">{{ \App\Models\pelicula::count() }}</p>
                </div>
                <i class="bi bi-film text-4xl text-muted-foreground/40"></i>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card class="border-l-4 border-l-warning">
            <x-ui.card.content class="flex items-center justify-between p-5">
                <div>
                    <p class="mb-1 text-sm text-muted-foreground"><i class="bi bi-tags"></i> Géneros</p>
                    <p class="text-2xl font-bold text-foreground">{{ \App\Models\genero::count() }}</p>
                </div>
                <i class="bi bi-tags text-4xl text-muted-foreground/40"></i>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card class="border-l-4 border-l-sky-500">
            <x-ui.card.content class="flex items-center justify-between p-5">
                <div>
                    <p class="mb-1 text-sm text-muted-foreground"><i class="bi bi-people"></i> Usuarios</p>
                    <p class="text-2xl font-bold text-foreground">{{ \App\Models\User::count() }}</p>
                </div>
                <i class="bi bi-people text-4xl text-muted-foreground/40"></i>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card class="border-l-4 border-l-emerald-500">
            <x-ui.card.content class="flex items-center justify-between p-5">
                <div>
                    <p class="mb-1 text-sm text-muted-foreground"><i class="bi bi-gift"></i> Promociones</p>
                    <p class="text-2xl font-bold text-foreground">{{ \App\Models\Promocion::count() }}</p>
                </div>
                <i class="bi bi-gift text-4xl text-muted-foreground/40"></i>
            </x-ui.card.content>
        </x-ui.card>
    </div>

    <h2 class="mb-6 border-l-4 border-warning pl-3 text-2xl font-bold text-foreground">Gestión</h2>

    <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-3">
        <x-ui.card hover class="text-center">
            <x-ui.card.content class="flex flex-col items-center p-6">
                <i class="bi bi-film mb-3 text-5xl text-primary"></i>
                <h4 class="mb-1 text-lg font-semibold text-foreground">Gestionar Películas</h4>
                <p class="mb-4 flex-1 text-sm text-muted-foreground">Crear, editar y eliminar películas de la cartelera</p>
                <x-ui.button href="{{ route('peliculas.index') }}" class="w-full"><i class="bi bi-arrow-right"></i> Ir a Películas</x-ui.button>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card hover class="text-center">
            <x-ui.card.content class="flex flex-col items-center p-6">
                <i class="bi bi-tags mb-3 text-5xl text-warning"></i>
                <h4 class="mb-1 text-lg font-semibold text-foreground">Gestionar Géneros</h4>
                <p class="mb-4 flex-1 text-sm text-muted-foreground">Crear, editar y eliminar géneros de películas</p>
                <x-ui.button href="{{ route('generos.index') }}" class="w-full bg-warning text-warning-foreground hover:bg-warning/90"><i class="bi bi-arrow-right"></i> Ir a Géneros</x-ui.button>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card hover class="text-center">
            <x-ui.card.content class="flex flex-col items-center p-6">
                <i class="bi bi-gift mb-3 text-5xl text-emerald-500"></i>
                <h4 class="mb-1 text-lg font-semibold text-foreground">Gestionar Promociones</h4>
                <p class="mb-4 flex-1 text-sm text-muted-foreground">Crear y administrar promociones activas</p>
                <x-ui.button href="{{ route('promociones.index') }}" class="w-full bg-emerald-600 text-white hover:bg-emerald-600/90"><i class="bi bi-arrow-right"></i> Ir a Promociones</x-ui.button>
            </x-ui.card.content>
        </x-ui.card>
    </div>

    <x-ui.button href="{{ route('inicio') }}" variant="outline"><i class="bi bi-arrow-left"></i> Volver al catálogo</x-ui.button>
</div>

@endsection
