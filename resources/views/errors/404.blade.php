@extends('layouts.base')
@section('title', 'Página no encontrada - Pordede')
@section('content')

<div class="container py-5 text-center">
    <i class="bi bi-film display-1 text-danger"></i>
    <h1 class="text-white fw-bold mt-4">Esta película no está en cartelera</h1>
    <p class="text-secondary fs-5 mb-4">La página que buscas no existe o se ha movido.</p>
    <a href="{{ route('inicio') }}" class="btn btn-danger">
        <i class="bi bi-house"></i> Volver al inicio
    </a>
</div>

@endsection
