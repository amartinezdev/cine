<section>
    <header class="mb-5">
        <h2 class="text-lg font-semibold text-foreground">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-muted-foreground">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-ui.label for="name">{{ __('Name') }}</x-ui.label>
            <x-ui.input id="name" name="name" type="text" class="mt-1.5" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        </div>

        <div>
            <x-ui.label for="email">{{ __('Email') }}</x-ui.label>
            <x-ui.input id="email" name="email" type="email" class="mt-1.5" value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-muted-foreground">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="text-primary underline-offset-4 hover:underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-emerald-400">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-ui.button type="submit">{{ __('Save') }}</x-ui.button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-muted-foreground">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
