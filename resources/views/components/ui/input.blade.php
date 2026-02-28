@props(['name' => null, 'type' => 'text'])

@php
    $invalid = $name && $errors->has($name);

    $classes = $type === 'file'
        ? 'flex w-full items-center rounded-md border bg-background py-1.5 pl-1.5 pr-3 text-sm text-muted-foreground '
            . 'file:mr-3 file:rounded file:border-0 file:bg-secondary file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-secondary-foreground file:transition-colors file:duration-150 hover:file:bg-secondary/80 file:cursor-pointer '
            . 'transition-colors duration-150 '
            . 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background '
            . 'disabled:cursor-not-allowed disabled:opacity-50 '
            . ($invalid ? 'border-destructive motion-safe:animate-shake' : 'border-input')
        : 'flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm text-foreground '
            . 'placeholder:text-muted-foreground '
            . 'transition-colors duration-150 '
            . 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background '
            . 'disabled:cursor-not-allowed disabled:opacity-50 '
            . ($invalid ? 'border-destructive motion-safe:animate-shake' : 'border-input');
@endphp

<input
    type="{{ $type }}"
    @if($name) name="{{ $name }}" id="{{ $name }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
@if($invalid)
    <p class="mt-1.5 text-sm text-destructive">{{ $errors->first($name) }}</p>
@endif
