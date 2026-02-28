@extends('layouts.base')
@section('title', 'Editar promoción - Pordede')
@section('content')

<div class="container py-8">
    <h1 class="mb-6 flex items-center gap-2 border-l-4 border-primary pl-3 text-2xl font-bold tracking-tight text-foreground">
        <i class="bi bi-pencil"></i> Editar Promoción
    </h1>

    <x-ui.card class="max-w-2xl mx-auto">
        <x-ui.card.content class="p-6">
            <form action="{{ route('promociones.actualizar', $promocion->id) }}" method="POST" onsubmit="pdPending(this)">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <x-ui.label for="titulo">Título de la Promoción</x-ui.label>
                    <x-ui.input type="text" name="titulo" value="{{ old('titulo', $promocion->titulo) }}" required class="mt-1.5" />
                </div>

                <div class="mb-5">
                    <x-ui.label for="mensaje">Mensaje</x-ui.label>
                    <x-ui.textarea name="mensaje" rows="4" required class="mt-1.5">{{ old('mensaje', $promocion->mensaje) }}</x-ui.textarea>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-ui.label for="fecha_inicio">Fecha y Hora Inicio</x-ui.label>
                        <x-ui.input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio', $promocion->fecha_inicio->format('Y-m-d\TH:i')) }}" required class="mt-1.5" />
                    </div>
                    <div>
                        <x-ui.label for="fecha_fin">Fecha y Hora Fin</x-ui.label>
                        <x-ui.input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin', $promocion->fecha_fin->format('Y-m-d\TH:i')) }}" required class="mt-1.5" />
                    </div>
                </div>

                <div class="flex gap-2">
                    <x-ui.button type="submit"><i class="bi bi-check-lg"></i> Guardar Cambios</x-ui.button>
                    <x-ui.button href="{{ route('promociones.index') }}" variant="outline"><i class="bi bi-arrow-left"></i> Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
