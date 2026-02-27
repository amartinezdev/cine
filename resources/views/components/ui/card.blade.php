@props(['hover' => false])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-border bg-card text-card-foreground shadow-sm '
    . ($hover ? 'transition-[transform,box-shadow] duration-200 ease-out motion-safe:[@media(hover:hover)_and_(pointer:fine)]:hover:-translate-y-1 [@media(hover:hover)_and_(pointer:fine)]:hover:shadow-lg [@media(hover:hover)_and_(pointer:fine)]:hover:shadow-black/30' : '')]) }}>
    {{ $slot }}
</div>
