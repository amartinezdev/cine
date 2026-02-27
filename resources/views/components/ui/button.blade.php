@props([
    'variant' => 'default',
    'size' => 'default',
    'href' => null,
    'type' => 'button',
])

@php
    $variants = [
        'default' => 'bg-primary text-primary-foreground hover:bg-primary/90',
        'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
        'outline' => 'border border-input bg-transparent hover:bg-accent hover:text-accent-foreground',
        'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
        'ghost' => 'bg-transparent hover:bg-accent hover:text-accent-foreground',
        'link' => 'bg-transparent text-primary underline-offset-4 hover:underline',
    ];

    $sizes = [
        'default' => 'h-10 px-4 py-2',
        'sm' => 'h-9 rounded-md px-3',
        'lg' => 'h-11 rounded-md px-8',
        'icon' => 'h-10 w-10 shrink-0',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium '
        . 'transition-[color,background-color,border-color,transform] duration-150 ease-out '
        . 'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background '
        . 'disabled:pointer-events-none disabled:opacity-50 motion-safe:active:scale-[0.97] '
        . ($variants[$variant] ?? $variants['default']) . ' '
        . ($sizes[$size] ?? $sizes['default']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
