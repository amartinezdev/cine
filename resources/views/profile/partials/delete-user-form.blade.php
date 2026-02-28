<section>
    <header class="mb-5">
        <h2 class="text-lg font-semibold text-foreground">{{ __('Delete Account') }}</h2>
        <p class="mt-1 text-sm text-muted-foreground">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>

    <x-ui.dialog :auto-open="$errors->userDeletion->isNotEmpty()">
        <x-slot:trigger>
            <x-ui.button variant="destructive" type="button">{{ __('Delete Account') }}</x-ui.button>
        </x-slot:trigger>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-foreground">{{ __('Are you sure you want to delete your account?') }}</h2>
            <p class="mt-1 text-sm text-muted-foreground">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

            <div class="mt-5">
                <x-ui.label for="password_delete" class="sr-only">{{ __('Password') }}</x-ui.label>
                <x-ui.input id="password_delete" name="password" type="password" placeholder="{{ __('Password') }}" class="{{ $errors->userDeletion->has('password') ? '!border-destructive motion-safe:animate-shake' : '' }}" />
                @error('password', 'userDeletion')
                    <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <x-ui.button type="button" variant="outline" @click="open = false">{{ __('Cancel') }}</x-ui.button>
                <x-ui.button type="submit" variant="destructive">{{ __('Delete Account') }}</x-ui.button>
            </div>
        </form>
    </x-ui.dialog>
</section>
