<div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative inline-block text-left">
    <div @click="open = !open">
        {{ $trigger }}
    </div>
    <div
        x-show="open"
        x-transition:enter="transition-[opacity,transform] duration-150 ease-out"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition-[opacity,transform] duration-100 ease-in-out"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        x-cloak
        @click="open = false"
        class="absolute right-0 z-50 mt-2 min-w-[12rem] origin-top-right rounded-md border border-border bg-popover p-1 text-popover-foreground shadow-lg"
    >
        {{ $slot }}
    </div>
</div>
