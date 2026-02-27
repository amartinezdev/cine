@extends('layouts.base')
@section('title', 'Editar género - Pordede')
@section('content')

<div class="container py-8">
    <h1 class="mb-6 flex items-center gap-2 border-l-4 border-warning pl-3 text-2xl font-bold text-foreground">
        <i class="bi bi-pencil"></i> Editar Género
    </h1>

    <x-ui.card class="max-w-xl">
        <x-ui.card.content class="p-6">
            <form action="{{ route('generos.actualizar', $genero->id) }}" method="POST" onsubmit="pdPending(this)">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <x-ui.label for="nombre">Nombre del Género</x-ui.label>
                    <x-ui.input type="text" name="nombre" value="{{ old('nombre', $genero->nombre) }}" required class="mt-1.5" />
                </div>

                <div class="flex gap-2">
                    <x-ui.button type="submit" class="bg-warning text-warning-foreground hover:bg-warning/90"><i class="bi bi-check-lg"></i> Actualizar Género</x-ui.button>
                    <x-ui.button href="{{ route('generos.index') }}" variant="outline"><i class="bi bi-arrow-left"></i> Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
