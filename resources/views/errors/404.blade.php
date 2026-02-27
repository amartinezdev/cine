@extends('layouts.base')
@section('title', 'Página no encontrada - Pordede')
@section('content')

<div class="container animate-fade-up motion-reduce:animate-none py-20 text-center">
    <i class="bi bi-film text-6xl text-primary"></i>
    <h1 class="mt-4 text-3xl font-bold text-foreground">Esta película no está en cartelera</h1>
    <p class="mb-6 text-lg text-muted-foreground">La página que buscas no existe o se ha movido.</p>
    <x-ui.button href="{{ route('inicio') }}"><i class="bi bi-house"></i> Volver al inicio</x-ui.button>
</div>

@endsection
