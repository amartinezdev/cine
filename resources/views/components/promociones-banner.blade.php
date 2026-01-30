@if($promocionesActivas->count() > 0)
    <div class="bg-warning text-dark py-3">
        <div class="container">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                @foreach($promocionesActivas as $promocion)
                    <div class="alert alert-warning mb-0 flex-grow-1">
                        <h5 class="alert-heading mb-2">{{ $promocion->titulo }}</h5>
                        <p class="mb-0">{{ $promocion->mensaje }}</p>
                        <small class="text-muted d-block mt-1">Válido hasta: {{ $promocion->fecha_fin->format('d/m/Y H:i') }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
