# 005 — Add the catalog's stagger entrance to the admin card grids

- **Status**: DONE
- **Commit**: 02fb2e5
- **Severity**: Missed opportunity (additive, not corrective)
- **Category**: Cohesion & tokens / Missed opportunities
- **Estimated scope**: 2 files, 1 line changed each

## Problem

`resources/views/admin/generos/index.blade.php` and
`resources/views/admin/promociones/index.blade.php` render card grids
using the exact same `<x-ui.card hover>` primitive and the exact same
`grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3` layout as the
public catalog grid — but unlike the catalog
(`resources/views/peliculas/index.blade.php:39-41`), these two admin
grids have no entrance animation at all. They pop in all at once. This is
exactly the "everything-at-once group entrance where a stagger belongs"
pattern this skill flags, and there's a direct, already-approved
precedent to copy rather than invent.

**Existing precedent — `resources/views/peliculas/index.blade.php:38-41`:**

```blade
                    @foreach($peliculasPorGeneroActual as $pelicula)
                        <x-ui.card hover
                            class="flex flex-col animate-fade-up motion-reduce:animate-none"
                            style="animation-delay: {{ min($loop->index, 8) * 0.06 }}s"
                        >
```

**`resources/views/admin/generos/index.blade.php:20-22` — current:**

```blade
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($generos as $genero)
                <x-ui.card hover class="border-l-4 border-l-warning">
```

**`resources/views/admin/promociones/index.blade.php:16-18` — current:**

```blade
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($promociones as $promocion)
                <x-ui.card hover>
```

## Target

**`admin/generos/index.blade.php:22`:**

```blade
                <x-ui.card hover
                    class="border-l-4 border-l-warning animate-fade-up motion-reduce:animate-none"
                    style="animation-delay: {{ min($loop->index, 8) * 0.06 }}s"
                >
```

**`admin/promociones/index.blade.php:18`:**

```blade
                <x-ui.card hover
                    class="animate-fade-up motion-reduce:animate-none"
                    style="animation-delay: {{ min($loop->index, 8) * 0.06 }}s"
                >
```

Both use the identical `animate-fade-up motion-reduce:animate-none` class
pair and the identical `min($loop->index, 8) * 0.06` stagger-delay
expression as the catalog grid — same animation (250ms after plan 004 is
applied, or 500ms if plan 004 has not been applied yet — this plan does
not depend on plan 004 and works correctly either way, since it only
reuses the existing `animate-fade-up` token whatever its current
duration is), same per-card delay, same cap at the 9th card (index 8) so
a long list doesn't produce a multi-second cascade.

## Repo conventions to follow

- `min($loop->index, 8) * 0.06` is this repo's established stagger-delay
  formula (defined and explained nowhere but the catalog page — replicate
  it verbatim, don't recompute or approximate it).
- `motion-reduce:animate-none` always travels together with
  `animate-fade-up` in this repo (see `peliculas/index.blade.php:40,110`,
  `errors/404.blade.php:5`, `alert.blade.php:14`) — never add
  `animate-fade-up` without it.
- `$loop->index` is Blade's built-in loop variable, already in scope
  inside each file's existing `@foreach` — no new variable needs to be
  introduced.

## Steps

1. In `resources/views/admin/generos/index.blade.php`, replace line 22
   (`<x-ui.card hover class="border-l-4 border-l-warning">`) with the
   three-line Target block shown above (opening tag now spans three
   lines with `class` and `style` on their own lines, matching the
   catalog's formatting style).
2. In `resources/views/admin/promociones/index.blade.php`, replace line
   18 (`<x-ui.card hover>`) with the three-line Target block shown above.

## Boundaries

- Do NOT touch `resources/views/admin/peliculas/index.blade.php` — that
  page renders a `<table>`, not a card grid; per this skill's Function
  guidance, dense functional tabular data the user is scanning/acting on
  should not animate row-by-row. Do not add a stagger there.
- Do NOT change the stagger formula, the animation token, or the grid
  layout classes (`grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3`).
- Do NOT touch `resources/views/peliculas/index.blade.php` (the source of
  the pattern being copied) or any other file.
- If either target line doesn't match the excerpts above (drift since
  commit `02fb2e5`), STOP and report instead of improvising.

## Verification

- **Mechanical**: `php artisan tinker --execute="use Illuminate\Support\Facades\Blade; foreach (['resources/views/admin/generos/index.blade.php','resources/views/admin/promociones/index.blade.php'] as \$f) { try { Blade::compileString(file_get_contents(\$f)); echo \"OK \$f\".PHP_EOL; } catch (\Throwable \$e) { echo \"ERROR \$f: \".\$e->getMessage().PHP_EOL; } }"` — expect `OK` for both.
- **Feel check**: as a logged-in admin, load `/generos` with at least 4-5
  géneros seeded, and `/promociones` with at least 4-5 promociones
  seeded:
  - Cards should cascade in with a short stagger, matching the feel of
    the public catalog grid at `/`.
  - Reload each page a couple of times — the stagger should look
    identical to the catalog's, not slower/faster or offset differently.
  - Toggle `prefers-reduced-motion: reduce` in DevTools Rendering panel
    and reload both pages: cards should appear immediately with no
    animation.
- **Done when**: both admin grids visually cascade in on load exactly
  like the public catalog grid, and both respect reduced motion.
