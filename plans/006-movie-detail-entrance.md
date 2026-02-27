# 006 — Add entrance motion to the movie detail page's stat row and info card

- **Status**: DONE
- **Commit**: 02fb2e5
- **Severity**: Missed opportunity (additive, not corrective — lowest priority of the six plans)
- **Category**: Missed opportunities
- **Estimated scope**: 1 file, 2 lines changed

## Problem

`resources/views/peliculas/mostrarPagina.blade.php` (the movie detail
page) has no entrance animation on any of its content, unlike every
other content block sitewide (catalog cards, admin card grids after plan
005, empty states, the 404 page, every alert). Two blocks stand out as
worth the same treatment, since they're the page's clearest discrete
"chunks": the stats row (duration/rating/price) and the "Información
Adicional" card at the bottom.

This is the lowest-priority of the six plans in this batch — it's purely
decorative consistency, not a correctness or accessibility fix, and
there's no existing precedent on *this specific page* forcing it (unlike
plan 005, which copies an established pattern from a sibling page).

**`resources/views/peliculas/mostrarPagina.blade.php:52` — current:**

```blade
            <div class="mb-6 flex flex-wrap gap-3">
```

**`resources/views/peliculas/mostrarPagina.blade.php:115` — current:**

```blade
    <x-ui.card class="mb-12">
```

## Target

```blade
            <div class="mb-6 flex flex-wrap gap-3 animate-fade-up motion-reduce:animate-none">
```

```blade
    <x-ui.card class="mb-12 animate-fade-up motion-reduce:animate-none" style="animation-delay: .06s">
```

The stat row animates in immediately (no delay — it's the first thing
below the title). The info card gets a `.06s` delay so it settles just
after the stat row rather than both popping in at the exact same instant
— `.06s` is this repo's established per-step stagger amount (see
`peliculas/index.blade.php:41`'s `* 0.06` multiplier), reused here as a
single fixed offset rather than a loop-driven stagger since there are
only two elements, not a list.

## Repo conventions to follow

- `animate-fade-up motion-reduce:animate-none` is always used as a pair
  in this repo — never add one without the other (see
  `peliculas/index.blade.php:40,110`, `errors/404.blade.php:5`,
  `alert.blade.php:14`, and the two grids fixed by plan 005).
- `0.06s` is the repo's existing stagger-step unit (from
  `peliculas/index.blade.php:41`'s `min($loop->index, 8) * 0.06`) — reuse
  the literal value, don't invent a new delay constant.
- `<x-ui.card>` already forwards arbitrary attributes via
  `$attributes->merge(...)` (see `card.blade.php`), so adding a `style`
  attribute alongside `class` works exactly the same way it already does
  on the catalog grid's `<x-ui.card hover class="..." style="...">`
  usage — no changes to the card component itself are needed.

## Steps

1. In `resources/views/peliculas/mostrarPagina.blade.php`, change line 52
   from `<div class="mb-6 flex flex-wrap gap-3">` to `<div class="mb-6
   flex flex-wrap gap-3 animate-fade-up motion-reduce:animate-none">`.
2. In the same file, change line 115 from `<x-ui.card class="mb-12">` to
   `<x-ui.card class="mb-12 animate-fade-up motion-reduce:animate-none"
   style="animation-delay: .06s">`.

## Boundaries

- Do NOT add motion to any other block on this page (the poster image
  already has its own fade-in-on-load treatment; the breadcrumb, title,
  sinopsis, and action buttons are intentionally left static — this plan
  is scoped to exactly the two blocks named above).
- Do NOT touch the hero backdrop, the dialog components used by the
  action buttons, or any other file.
- If lines 52 or 115 don't match the excerpts above (drift since commit
  `02fb2e5`), STOP and report instead of improvising.

## Verification

- **Mechanical**: `php artisan tinker --execute="use Illuminate\Support\Facades\Blade; try { Blade::compileString(file_get_contents('resources/views/peliculas/mostrarPagina.blade.php')); echo 'OK'.PHP_EOL; } catch (\Throwable \$e) { echo 'ERROR: '.\$e->getMessage().PHP_EOL; }"` — expect `OK`. Then `npm run build` — expect success.
- **Feel check**: open any movie's detail page (`/pelicula/{id}`):
  - The three stat boxes (minutos/puntuación/entrada) should fade/rise in
    together as one block immediately on load.
  - The "Información Adicional" card at the bottom should fade/rise in
    just slightly after — the offset should read as a subtle sequence,
    not be imperceptible or jarringly separate.
  - Toggle `prefers-reduced-motion: reduce` in DevTools Rendering panel
    and reload: both blocks should appear immediately with no animation.
- **Done when**: both blocks animate in on page load with the specified
  timing, and reduced motion suppresses both.
