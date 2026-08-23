@props(['autoOpen' => false])

<div x-data="{ open: {{ $autoOpen ? 'true' : 'false' }}, reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }" x-on:keydown.escape.window="open = false" {{ $attributes }}>
    @isset($trigger)
        <span class="contents" @click="open = true">{{ $trigger }}</span>
    @endisset

    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-200 ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-150 ease-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/70"
                @click="open = false"
            ></div>

            <div
                x-show="open"
                :x-transition:enter="reduceMotion ? 'transition-opacity duration-200 ease-out' : 'transition-[opacity,transform] duration-200 ease-out'"
                :x-transition:enter-start="reduceMotion ? 'opacity-0' : 'opacity-0 scale-95'"
                x-transition:enter-end="opacity-100 scale-100"
                :x-transition:leave="reduceMotion ? 'transition-opacity duration-150 ease-out' : 'transition-[opacity,transform] duration-150 ease-out'"
                x-transition:leave-start="opacity-100 scale-100"
                :x-transition:leave-end="reduceMotion ? 'opacity-0' : 'opacity-0 scale-95'"
                role="dialog"
                aria-modal="true"
                class="relative z-10 w-full max-w-md rounded-lg border border-border bg-card text-card-foreground shadow-xl"
            >
                {{ $slot }}
            </div>
        </div>
    </template>
</div>
