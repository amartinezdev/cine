@props(['name' => null])

@php
    $invalid = $name && $errors->has($name);

    $classes = 'flex min-h-[120px] w-full rounded-md border bg-background px-3 py-2 text-sm text-foreground '
        . 'placeholder:text-muted-foreground '
        . 'transition-colors duration-150 '
        . 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background '
        . 'disabled:cursor-not-allowed disabled:opacity-50 '
        . ($invalid ? 'border-destructive motion-safe:animate-shake' : 'border-input');
@endphp

<textarea
    @if($name) name="{{ $name }}" id="{{ $name }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>{{ $slot }}</textarea>
@if($invalid)
    <p class="mt-1.5 text-sm text-destructive">{{ $errors->first($name) }}</p>
@endif
