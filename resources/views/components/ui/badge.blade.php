@props(['variant' => 'default'])

@php
    $variants = [
        'default' => 'bg-primary/15 text-primary border-primary/30',
        'secondary' => 'bg-secondary text-secondary-foreground border-transparent',
        'destructive' => 'bg-destructive/15 text-destructive border-destructive/30',
        'warning' => 'bg-warning/15 text-warning border-warning/30',
        'outline' => 'bg-transparent text-foreground border-border',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 rounded-md border px-2 py-0.5 text-xs font-medium '
    . ($variants[$variant] ?? $variants['default'])]) }}>
    {{ $slot }}
</span>
