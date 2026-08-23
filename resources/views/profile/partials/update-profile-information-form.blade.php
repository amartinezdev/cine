<x-ui.card.header class="border-b border-border">
    <x-ui.card.title><i class="bi bi-person text-primary"></i> Información del Perfil</x-ui.card.title>
    <x-ui.card.description>Actualiza el nombre y el correo electrónico de tu cuenta.</x-ui.card.description>
</x-ui.card.header>

<x-ui.card.content class="pt-6">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-ui.label for="name">Nombre</x-ui.label>
            <x-ui.input id="name" name="name" type="text" class="mt-1.5" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        </div>

        <div>
            <x-ui.label for="email">Correo Electrónico</x-ui.label>
            <x-ui.input id="email" name="email" type="email" class="mt-1.5" value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-muted-foreground">
                    Tu dirección de correo electrónico no está verificada.
                    <button form="send-verification" class="text-primary underline-offset-4 hover:underline">
                        Haz clic aquí para reenviar el correo de verificación.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-emerald-400">Se ha enviado un nuevo enlace de verificación a tu correo electrónico.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-ui.button type="submit">Guardar</x-ui.button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-muted-foreground">Guardado.</p>
            @endif
        </div>
    </form>
</x-ui.card.content>
