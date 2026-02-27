@props(['variant' => 'default', 'dismissible' => false])

@php
    $variants = [
        'default' => 'border-border bg-card text-foreground [&>svg]:text-foreground',
        'destructive' => 'border-destructive/40 bg-destructive/10 text-destructive [&>svg]:text-destructive',
        'success' => 'border-emerald-500/40 bg-emerald-500/10 text-emerald-400 [&>svg]:text-emerald-400',
        'warning' => 'border-warning/40 bg-warning/10 text-warning [&>svg]:text-warning',
    ];
@endphp

<div
    @if($dismissible) x-data="{ show: true, reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }" x-show="show" :x-transition:leave="reduceMotion ? 'transition-opacity duration-150 ease-out' : 'transition-[opacity,transform] duration-150 ease-out'" x-transition:leave-start="opacity-100" :x-transition:leave-end="reduceMotion ? 'opacity-0' : 'opacity-0 -translate-y-1'" @endif
    {{ $attributes->merge(['class' => 'relative flex items-start gap-3 rounded-lg border p-4 text-sm animate-fade-up motion-reduce:animate-none ' . ($variants[$variant] ?? $variants['default'])]) }}
>
    {{ $slot }}

    @if($dismissible)
        <button type="button" @click="show = false" class="ml-auto shrink-0 rounded-md p-1 text-current/70 transition-colors hover:bg-black/10 hover:text-current" aria-label="Cerrar">
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    @endif
</div>
