@extends('layouts.base')
@section('title', 'Confirmar contraseña - Pordede')
@section('content')

<div class="container flex justify-center py-12">
    <x-ui.card class="w-full max-w-md">
        <x-ui.card.header class="border-b border-border">
            <x-ui.card.title><i class="bi bi-shield-check text-primary"></i> Confirmar Contraseña</x-ui.card.title>
        </x-ui.card.header>

        <x-ui.card.content class="pt-6">
            <p class="mb-5 text-sm text-muted-foreground">
                {{ __('Esta es un área segura de la aplicación. Confirma tu contraseña antes de continuar.') }}
            </p>

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

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <div>
                    <x-ui.label for="password">{{ __('Contraseña') }}</x-ui.label>
                    <x-ui.input type="password" name="password" required autocomplete="current-password" autofocus class="mt-1.5" />
                </div>

                <div class="flex justify-end pt-2">
                    <x-ui.button type="submit"><i class="bi bi-check-lg"></i> {{ __('Confirmar') }}</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
