<section>
    <header class="mb-5">
        <h2 class="text-lg font-semibold text-foreground">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-sm text-muted-foreground">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <x-ui.label for="current_password">{{ __('Current Password') }}</x-ui.label>
            <x-ui.input id="current_password" name="current_password" type="password" class="mt-1.5 {{ $errors->updatePassword->has('current_password') ? '!border-destructive motion-safe:animate-shake' : '' }}" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-ui.label for="password">{{ __('New Password') }}</x-ui.label>
            <x-ui.input id="password" name="password" type="password" class="mt-1.5 {{ $errors->updatePassword->has('password') ? '!border-destructive motion-safe:animate-shake' : '' }}" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-ui.label for="password_confirmation">{{ __('Confirm Password') }}</x-ui.label>
            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" class="mt-1.5 {{ $errors->updatePassword->has('password_confirmation') ? '!border-destructive motion-safe:animate-shake' : '' }}" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1.5 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-ui.button type="submit">{{ __('Save') }}</x-ui.button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-muted-foreground">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
