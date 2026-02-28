@extends('layouts.base')
@section('title', 'Verificar correo - Pordede')
@section('content')

<div class="container flex justify-center py-12">
    <x-ui.card class="w-full max-w-md">
        <x-ui.card.header class="border-b border-border">
            <x-ui.card.title><i class="bi bi-envelope-check text-primary"></i> Verifica tu Correo</x-ui.card.title>
        </x-ui.card.header>

        <x-ui.card.content class="pt-6">
            <p class="mb-5 text-sm text-muted-foreground">
                {{ __('¡Gracias por registrarte! Antes de empezar, ¿puedes verificar tu correo haciendo clic en el enlace que te acabamos de enviar? Si no lo has recibido, te enviaremos otro con gusto.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <x-ui.alert variant="success" class="mb-5"><i class="bi bi-check-circle mt-0.5"></i> <p>{{ __('Te hemos enviado un nuevo enlace de verificación al correo indicado en el registro.') }}</p></x-ui.alert>
            @endif

            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-ui.button type="submit"><i class="bi bi-arrow-repeat"></i> {{ __('Reenviar Verificación') }}</x-ui.button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-ui.button type="submit" variant="ghost"><i class="bi bi-box-arrow-right"></i> {{ __('Salir') }}</x-ui.button>
                </form>
            </div>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
