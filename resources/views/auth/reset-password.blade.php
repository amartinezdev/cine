@extends('layouts.base')
@section('title', 'Restablecer contraseña - Pordede')
@section('content')

<div class="container flex justify-center py-12">
    <x-ui.card class="w-full max-w-md">
        <x-ui.card.header class="border-b border-border">
            <x-ui.card.title><i class="bi bi-shield-lock text-primary"></i> Restablecer Contraseña</x-ui.card.title>
        </x-ui.card.header>

        <x-ui.card.content class="pt-6">
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

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <x-ui.label for="email">{{ __('Correo Electrónico') }}</x-ui.label>
                    <x-ui.input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="mt-1.5" />
                </div>

                <div>
                    <x-ui.label for="password">{{ __('Contraseña') }}</x-ui.label>
                    <x-ui.input type="password" name="password" required autocomplete="new-password" class="mt-1.5" />
                </div>

                <div>
                    <x-ui.label for="password_confirmation">{{ __('Confirmar Contraseña') }}</x-ui.label>
                    <x-ui.input type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1.5" />
                </div>

                <div class="flex justify-end pt-2">
                    <x-ui.button type="submit"><i class="bi bi-check-lg"></i> {{ __('Restablecer Contraseña') }}</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>
    </x-ui.card>
</div>

@endsection
