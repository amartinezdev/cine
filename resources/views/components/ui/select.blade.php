@props(['name' => null])

@php
    $invalid = $name && $errors->has($name);

    $classes = 'flex h-10 w-full appearance-none rounded-md border bg-background pl-3 pr-9 py-2 text-sm text-foreground '
        . 'transition-colors duration-150 '
        . 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background '
        . 'disabled:cursor-not-allowed disabled:opacity-50 '
        . ($invalid ? 'border-destructive motion-safe:animate-shake' : 'border-input');
@endphp

<div class="relative">
    <select
        @if($name) name="{{ $name }}" id="{{ $name }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >{{ $slot }}</select>
    <i class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground"></i>
</div>
@if($invalid)
    <p class="mt-1.5 text-sm text-destructive">{{ $errors->first($name) }}</p>
@endif
