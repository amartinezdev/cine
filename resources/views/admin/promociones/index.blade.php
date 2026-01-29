@extends('layouts.base')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white fw-bold border-start border-danger border-4 ps-3">Gestionar Promociones</h1>
        <a href="{{ route('promociones.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-lg"></i> Añadir Promoción
        </a>
    </div>

    @if(session('info'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($promociones->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($promociones as $promocion)
                <div class="col">
                    <div class="card bg-dark border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title text-white">{{ $promocion->titulo }}</h5>
                            <p class="card-text text-secondary small">{{ Str::limit($promocion->mensaje, 100) }}</p>

                            <div class="bg-black p-3 rounded mb-3">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <small class="text-secondary d-block">Inicio</small>
                                        <span class="text-white">{{ $promocion->fecha_inicio->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-secondary d-block">Fin</small>
                                        <span class="text-white">{{ $promocion->fecha_fin->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                @if(!$promocion->activo)
                                    <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inactiva</span>
                                @elseif($promocion->fecha_inicio > now())
                                    <span class="badge bg-info"><i class="bi bi-hourglass"></i> Próximamente</span>
                                @elseif($promocion->fecha_fin < now())
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Expirada</span>
                                @else
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Activa</span>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('promociones.edit', $promocion->id) }}" class="btn btn-outline-warning btn-sm flex-grow-1">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('promociones.delete', $promocion->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('¿Eliminar esta promoción?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-gift display-1 text-secondary"></i>
            <h4 class="text-white mt-3">No hay promociones</h4>
            <p class="text-secondary">Crea una nueva promoción para comenzar.</p>
            <a href="{{ route('promociones.create') }}" class="btn btn-danger mt-3">
                <i class="bi bi-plus-lg"></i> Crear Promoción
            </a>
        </div>
    @endif
</div>

@endsection
