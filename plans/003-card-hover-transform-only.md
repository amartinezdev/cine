# 003 — Stop transitioning box-shadow on card hover

- **Status**: DONE
- **Commit**: 02fb2e5
- **Severity**: MEDIUM
- **Category**: Performance
- **Estimated scope**: 1 file, 1 line

## Problem

**`resources/views/components/ui/card.blade.php` (full file, 7 lines) — current:**

```blade
@props(['hover' => false])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-border bg-card text-card-foreground shadow-sm '
    . ($hover ? 'transition-[transform,box-shadow] duration-200 ease-out motion-safe:[@media(hover:hover)_and_(pointer:fine)]:hover:-translate-y-1 [@media(hover:hover)_and_(pointer:fine)]:hover:shadow-lg [@media(hover:hover)_and_(pointer:fine)]:hover:shadow-black/30' : '')]) }}>
    {{ $slot }}
</div>
```

`transition-[transform,box-shadow]` puts `box-shadow` in the animated
property list. `box-shadow` is not a compositor-only property — animating
it forces paint on every frame of the transition, unlike `transform` and
`opacity` which the compositor can animate on the GPU alone. This
component (`<x-ui.card hover>`) is the shared primitive behind every
hoverable card in the app — the public catalog grid, the admin dashboard's
three management cards, and the géneros/promociones admin grids — so the
cost, while only paid by whichever single card is under the cursor at a
time, is paid on a component used dozens of times sitewide.

## Target

Keep the box-shadow as a **static** hover-state class (Tailwind still
applies it instantly on `:hover`, no animation needed for a shadow swap to
read fine — only the *transform* needs to visibly ease in), and only
transition `transform`:

```blade
@props(['hover' => false])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-border bg-card text-card-foreground shadow-sm '
    . ($hover ? 'transition-transform duration-200 ease-out motion-safe:[@media(hover:hover)_and_(pointer:fine)]:hover:-translate-y-1 [@media(hover:hover)_and_(pointer:fine)]:hover:shadow-lg [@media(hover:hover)_and_(pointer:fine)]:hover:shadow-black/30' : '')]) }}>
    {{ $slot }}
</div>
```

The only change is `transition-[transform,box-shadow]` →
`transition-transform`. The `hover:shadow-lg hover:shadow-black/30`
classes are untouched and still apply the moment the hover media query
matches — they just switch instantly instead of easing, which is the
correct fix per this skill's performance rule ("animate `transform` and
`opacity` only").

## Repo conventions to follow

- This repo already writes multi-property Tailwind arbitrary transitions
  as `transition-[prop1,prop2]` (see
  `resources/views/components/ui/button.blade.php:26`:
  `transition-[color,background-color,border-color,transform]`) — that
  pattern is correct there because `color`/`background-color`/
  `border-color` are all cheap, non-layout, non-paint-heavy properties
  (browsers optimize color transitions well). `box-shadow` is the outlier
  here, not the arbitrary-value syntax itself — do not "fix" this by
  changing the button component or any other `transition-[...]` usage.
- The `[@media(hover:hover)_and_(pointer:fine)]:hover:` gating pattern
  used for the shadow/lift classes is correct and repo-standard (see also
  `resources/views/peliculas/index.blade.php:48` for the poster
  hover-zoom using the same gate) — do not change that part.

## Steps

1. In `resources/views/components/ui/card.blade.php`, change
   `transition-[transform,box-shadow]` to `transition-transform` (one
   word substitution, same line 4). No other line changes.

## Boundaries

- Do NOT touch the `hover:shadow-lg`/`hover:shadow-black/30` classes
  themselves, the `motion-safe:`/media-query gating, or the non-hover
  base classes (`rounded-lg border border-border bg-card
  text-card-foreground shadow-sm`).
- Do NOT touch any file that *uses* `<x-ui.card>` — this is a one-file
  fix to the shared primitive; every usage inherits it automatically.
- If line 4's current content doesn't match the excerpt above (drift
  since commit `02fb2e5`), STOP and report instead of improvising.

## Verification

- **Mechanical**: `php artisan tinker --execute="use Illuminate\Support\Facades\Blade; try { Blade::compileString(file_get_contents('resources/views/components/ui/card.blade.php')); echo 'OK'.PHP_EOL; } catch (\Throwable \$e) { echo 'ERROR: '.\$e->getMessage().PHP_EOL; }"` — expect `OK`. Then `npm run build` — expect success, and confirm the compiled CSS still contains a `.transition-transform` rule (it's a Tailwind core utility, will be present regardless, but check `hover\:shadow-lg` and `hover\:shadow-black\/30` are still present in `public/build/assets/app-*.css` after the build, confirming the shadow classes weren't accidentally removed).
- **Feel check**: open the public catalog (`/`) or the admin dashboard
  (`/admin`) in a real browser (desktop, mouse pointer) and hover a card:
  - The card should still visibly lift (`-translate-y-1`) smoothly over
    ~200ms.
  - The shadow should still appear larger/darker on hover, but it can
    (and now will) pop in immediately rather than visibly growing — this
    is expected and correct, not a regression. Compare side-by-side with
    a git stash of the old version if the difference is hard to judge by
    eye.
  - In DevTools Performance panel, record ~2 seconds while repeatedly
    hovering on/off a catalog card; confirm no "Paint" entries are
    attributed to the shadow transition (there will still be Paint on
    layout-affecting rerenders elsewhere in the page, but not per-frame
    during this specific hover).
- **Done when**: `card.blade.php` transitions only `transform`, the hover
  lift still animates, the hover shadow still changes (instantly), and
  `npm run build` succeeds.
