<div x-data="{ open: false, reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative inline-block text-left">
    <div @click="open = !open">
        {{ $trigger }}
    </div>
    <div
        x-show="open"
        :x-transition:enter="reduceMotion ? 'transition-opacity duration-150 ease-out' : 'transition-[opacity,transform] duration-150 ease-out'"
        :x-transition:enter-start="reduceMotion ? 'opacity-0' : 'opacity-0 scale-95 -translate-y-1'"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        :x-transition:leave="reduceMotion ? 'transition-opacity duration-100 ease-out' : 'transition-[opacity,transform] duration-100 ease-out'"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        :x-transition:leave-end="reduceMotion ? 'opacity-0' : 'opacity-0 scale-95 -translate-y-1'"
        x-cloak
        @click="open = false"
        class="absolute right-0 z-50 mt-2 min-w-[12rem] origin-top-right rounded-md border border-border bg-popover p-1 text-popover-foreground shadow-lg"
    >
        {{ $slot }}
    </div>
</div>
