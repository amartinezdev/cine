@extends('layouts.base')
@section('title', 'Mi perfil - Pordede')
@section('content')

<div class="container max-w-2xl py-8">
    <h1 class="mb-8 border-l-4 border-primary pl-3 text-3xl font-bold tracking-tight text-foreground">
        <i class="bi bi-person-circle"></i> Mi Perfil
    </h1>

    <div class="space-y-6">
        <x-ui.card>
            <x-ui.card.content class="p-6">
                @include('profile.partials.update-profile-information-form')
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.content class="p-6">
                @include('profile.partials.update-password-form')
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.content class="p-6">
                @include('profile.partials.delete-user-form')
            </x-ui.card.content>
        </x-ui.card>
    </div>
</div>

@endsection
