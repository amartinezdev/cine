@extends('layouts.base')
@section('title', 'Iniciar sesión - Pordede')
@section('content')

<div class="container flex justify-center py-12">
    <x-ui.card class="w-full max-w-md">
        <x-ui.card.header class="border-b border-border">
            <x-ui.card.title><i class="bi bi-box-arrow-in-right text-primary"></i> Iniciar Sesión</x-ui.card.title>
        </x-ui.card.header>

        <x-ui.card.content class="pt-6">
            <div class="mb-5 rounded-lg border border-primary/30 bg-primary/10 p-3 text-sm text-foreground">
                <p class="mb-1 font-semibold"><i class="bi bi-info-circle"></i> Credenciales de prueba</p>
                <p><span class="font-semibold">Admin:</span> admin@demo.com / CineDemo2026!</p>
                <p><span class="font-semibold">Usuario:</span> user@demo.com / CineDemo2026!</p>
            </div>

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

            @if(session('status'))
                <x-ui.alert variant="success" class="mb-5">
                    <i class="bi bi-check-circle mt-0.5"></i>
                    <p>{{ session('status') }}</p>
                </x-ui.alert>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <x-ui.label for="email">Correo Electrónico</x-ui.label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1.5" />
                </div>

                <div>
                    <x-ui.label for="password">Contraseña</x-ui.label>
                    <x-ui.input type="password" name="password" required class="mt-1.5" />
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-input text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                    <label for="remember" class="text-sm text-muted-foreground">Recuérdame</label>
                </div>

                <div class="flex items-center justify-between pt-2">
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">¿Olvidaste tu contraseña?</a>
                    @endif
                    <x-ui.button type="submit"><i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión</x-ui.button>
                </div>
            </form>
        </x-ui.card.content>

        <x-ui.card.footer class="justify-center border-t border-border text-sm text-muted-foreground">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="ml-1 text-primary hover:underline">Regístrate aquí</a>
        </x-ui.card.footer>
    </x-ui.card>
</div>

@endsection
