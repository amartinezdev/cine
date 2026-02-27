@extends('layouts.base')
@section('title', 'Gestionar promociones - Pordede')
@section('content')

<div class="container py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="border-l-4 border-primary pl-3 text-2xl font-bold tracking-tight text-foreground">Gestionar Promociones</h1>
        <x-ui.button href="{{ route('promociones.create') }}"><i class="bi bi-plus-lg"></i> Añadir Promoción</x-ui.button>
    </div>

    @if(session('info'))
        <x-ui.alert variant="success" dismissible class="mb-5"><i class="bi bi-check-circle mt-0.5"></i> <p>{{ session('info') }}</p></x-ui.alert>
    @endif

    @if($promociones->count() > 0)
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($promociones as $promocion)
                <x-ui.card hover>
                    <x-ui.card.content class="p-5">
                        <h5 class="mb-2 text-lg font-semibold text-foreground">{{ $promocion->titulo }}</h5>
                        <p class="mb-4 text-sm text-muted-foreground">{{ Str::limit($promocion->mensaje, 100) }}</p>

                        <div class="mb-4 grid grid-cols-2 gap-2 rounded-lg bg-background p-3 text-center">
                            <div>
                                <span class="block text-xs text-muted-foreground">Inicio</span>
                                <span class="text-foreground">{{ $promocion->fecha_inicio->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-muted-foreground">Fin</span>
                                <span class="text-foreground">{{ $promocion->fecha_fin->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            @if(!$promocion->activo)
                                <x-ui.badge variant="secondary"><i class="bi bi-x-circle"></i> Inactiva</x-ui.badge>
                            @elseif($promocion->fecha_inicio > now())
                                <x-ui.badge variant="outline"><i class="bi bi-hourglass"></i> Próximamente</x-ui.badge>
                            @elseif($promocion->fecha_fin < now())
                                <x-ui.badge variant="warning"><i class="bi bi-clock-history"></i> Expirada</x-ui.badge>
                            @else
                                <x-ui.badge class="border-emerald-500/30 bg-emerald-500/15 text-emerald-400"><i class="bi bi-check-circle"></i> Activa</x-ui.badge>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button href="{{ route('promociones.edit', $promocion->id) }}" variant="outline" size="sm" class="flex-1"><i class="bi bi-pencil"></i> Editar</x-ui.button>
                            <form action="{{ route('promociones.delete', $promocion->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Eliminar esta promoción?');">
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
            <i class="bi bi-gift text-6xl text-muted-foreground"></i>
            <h4 class="mt-4 text-xl font-semibold text-foreground">No hay promociones</h4>
            <p class="text-muted-foreground">Crea una nueva promoción para comenzar.</p>
            <x-ui.button href="{{ route('promociones.create') }}" class="mt-4"><i class="bi bi-plus-lg"></i> Crear Promoción</x-ui.button>
        </div>
    @endif
</div>

@endsection
