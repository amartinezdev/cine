<x-ui.card.header class="border-b border-border">
    <x-ui.card.title><i class="bi bi-shield-lock text-primary"></i> Actualizar Contraseña</x-ui.card.title>
    <x-ui.card.description>Asegúrate de que tu cuenta usa una contraseña larga y aleatoria para mantenerla segura.</x-ui.card.description>
</x-ui.card.header>

<x-ui.card.content class="pt-6">
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <x-ui.label for="current_password">Contraseña Actual</x-ui.label>
            <x-ui.input id="current_password" name="current_password" type="password" class="mt-1.5 {{ $errors->updatePassword->has('current_password') ? '!border-destructive motion-safe:animate-shake' : '' }}" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-ui.label for="password">Nueva Contraseña</x-ui.label>
            <x-ui.input id="password" name="password" type="password" class="mt-1.5 {{ $errors->updatePassword->has('password') ? '!border-destructive motion-safe:animate-shake' : '' }}" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-ui.label for="password_confirmation">Confirmar Contraseña</x-ui.label>
            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" class="mt-1.5 {{ $errors->updatePassword->has('password_confirmation') ? '!border-destructive motion-safe:animate-shake' : '' }}" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-ui.button type="submit">Guardar</x-ui.button>
        </div>
    </form>

    <x-ui.dialog :auto-open="session('status') === 'password-update-blocked'">
        <div class="p-6 text-center">
            <i class="bi bi-shield-lock mb-3 block text-5xl text-warning mr-0"></i>
            <p class="mb-2 text-lg font-semibold text-foreground">Cambio de contraseña deshabilitado</p>
            <p class="text-sm text-muted-foreground">Por tratarse de un entorno de demostración, no es posible cambiar la contraseña. Tu contraseña actual es correcta, pero no se ha modificado.</p>
            <x-ui.button @click="open = false" class="mt-4">Entendido</x-ui.button>
        </div>
    </x-ui.dialog>
</x-ui.card.content>
