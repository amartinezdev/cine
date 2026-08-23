<x-ui.card.header class="border-b border-border">
    <x-ui.card.title><i class="bi bi-exclamation-triangle text-destructive"></i> Eliminar Cuenta</x-ui.card.title>
    <x-ui.card.description>Una vez que elimines tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar tu cuenta, descarga cualquier información que desees conservar.</x-ui.card.description>
</x-ui.card.header>

<x-ui.card.content class="pt-6">
    <x-ui.dialog :auto-open="$errors->userDeletion->isNotEmpty()">
        <x-slot:trigger>
            <x-ui.button variant="destructive" type="button">Eliminar Cuenta</x-ui.button>
        </x-slot:trigger>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-foreground">¿Seguro que quieres eliminar tu cuenta?</h2>
            <p class="mt-1 text-sm text-muted-foreground">Una vez que elimines tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.</p>

            <div class="mt-5">
                <x-ui.label for="password_delete" class="sr-only">Contraseña</x-ui.label>
                <x-ui.input id="password_delete" name="password" type="password" placeholder="Contraseña" class="{{ $errors->userDeletion->has('password') ? '!border-destructive motion-safe:animate-shake' : '' }}" />
                @error('password', 'userDeletion')
                    <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <x-ui.button type="button" variant="outline" @click="open = false">Cancelar</x-ui.button>
                <x-ui.button type="submit" variant="destructive">Eliminar Cuenta</x-ui.button>
            </div>
        </form>
    </x-ui.dialog>

    <x-ui.dialog :auto-open="session('status') === 'account-deletion-blocked'">
        <div class="p-6 text-center">
            <i class="bi bi-shield-lock mb-3 block text-5xl text-warning mr-0"></i>
            <p class="mb-2 text-lg font-semibold text-foreground">Eliminación deshabilitada</p>
            <p class="text-sm text-muted-foreground">Por tratarse de un entorno de demostración, no es posible eliminar cuentas de usuario. Tu contraseña es correcta, pero la cuenta se mantiene intacta.</p>
            <x-ui.button @click="open = false" class="mt-4">Entendido</x-ui.button>
        </div>
    </x-ui.dialog>
</x-ui.card.content>
