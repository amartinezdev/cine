@extends('layouts.base')
@section('title', 'Crear promoción - Pordede')
@section('content')

<div class="container py-8">
    <h1 class="mb-6 flex items-center gap-2 border-l-4 border-primary pl-3 text-2xl font-bold tracking-tight text-foreground">
        <i class="bi bi-gift"></i> Crear Promoción
    </h1>

    <x-ui.card class="max-w-2xl mx-auto">
        <x-ui.card.content class="p-6">
            <form action="{{ route('promociones.crear') }}" method="POST" onsubmit="pdPending(this)">
                @csrf

                <div class="mb-5">
                    <x-ui.label for="titulo">Título de la Promoción</x-ui.label>
                    <x-ui.input type="text" name="titulo" value="{{ old('titulo') }}" required class="mt-1.5" />
                </div>

                <div class="mb-5">
                    <x-ui.label for="mensaje">Mensaje</x-ui.label>
                    <x-ui.textarea name="mensaje" rows="4" required class="mt-1.5">{{ old('mensaje') }}</x-ui.textarea>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-ui.label for="fecha_inicio">Fecha y Hora Inicio</x-ui.label>
                        <x-ui.input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required class="mt-1.5" />
                    </div>
                    <div>
                        <x-ui.label for="fecha_fin">Fecha y Hora Fin</x-ui.label>
                        <x-ui.input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin') }}" required class="mt-1.5" />
                    </div>
                </div>

                <div class="flex gap-2">
                    <x-ui.button type="submit"><i class="bi bi-plus-lg"></i> Crear Promoción</x-ui.button>
                    <x-ui.button href="{{ route('promociones.index') }}" variant="outline"><i class="bi bi-arrow-left"></i> Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
