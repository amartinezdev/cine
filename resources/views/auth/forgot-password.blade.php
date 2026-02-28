@extends('layouts.base')
@section('title', 'Recuperar contraseña - Pordede')
@section('content')

<div class="container flex justify-center py-12">
    <x-ui.card class="w-full max-w-md">
        <x-ui.card.header class="border-b border-border">
            <x-ui.card.title><i class="bi bi-key text-primary"></i> Recuperar Contraseña</x-ui.card.title>
        </x-ui.card.header>

        <x-ui.card.content class="pt-6">
            <p class="mb-5 text-sm text-muted-foreground">
                {{ __('¿Olvidaste tu contraseña? No pasa nada. Indícanos tu correo y te enviaremos un enlace para elegir una nueva.') }}
            </p>

            @if(session('status'))
                <x-ui.alert variant="success" class="mb-5"><i class="bi bi-check-circle mt-0.5"></i> <p>{{ session('status') }}</p></x-ui.alert>
            @endif

            @if($errors->any())
                <x-ui.alert variant="destructive" class="mb-5">
                    <i class="bi bi-exclamation-triangle mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </x-ui.alert>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <x-ui.label for="email">{{ __('Correo Electrónico') }}</x-ui.label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1.5" />
                </div>

                <div class="flex justify-end pt-2">
                    <x-ui.button type="submit"><i class="bi bi-envelope"></i> {{ __('Enviar Enlace') }}</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
