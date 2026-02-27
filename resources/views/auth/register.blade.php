@extends('layouts.base')
@section('title', 'Crear cuenta - Pordede')
@section('content')

<div class="container flex justify-center py-12">
    <x-ui.card class="w-full max-w-md">
        <x-ui.card.header class="border-b border-border">
            <x-ui.card.title><i class="bi bi-person-plus text-primary"></i> Crear Cuenta</x-ui.card.title>
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <x-ui.label for="name">Nombre Completo</x-ui.label>
                    <x-ui.input type="text" name="name" value="{{ old('name') }}" required autofocus class="mt-1.5" />
                </div>

                <div>
                    <x-ui.label for="email">Correo Electrónico</x-ui.label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}" required class="mt-1.5" />
                </div>

                <div>
                    <x-ui.label for="password">Contraseña</x-ui.label>
                    <x-ui.input type="password" name="password" required class="mt-1.5" />
                </div>

                <div>
                    <x-ui.label for="password_confirmation">Confirmar Contraseña</x-ui.label>
                    <x-ui.input type="password" name="password_confirmation" required class="mt-1.5" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">¿Ya tienes cuenta?</a>
                    <x-ui.button type="submit"><i class="bi bi-person-plus"></i> Registrarse</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>

        <x-ui.card.footer class="justify-center border-t border-border text-sm text-muted-foreground">
            Al registrarte, aceptas nuestros términos de servicio
        </x-ui.card.footer>
    </x-ui.card>
</div>

@endsection
