# 002 — Fix alert dismiss easing and its reduced-motion gap

- **Status**: DONE
- **Commit**: 02fb2e5
- **Severity**: MEDIUM
- **Category**: Easing (+ closes one Accessibility gap missed in the original audit)
- **Estimated scope**: 1 file, 1 line

## Problem

**`resources/views/components/ui/alert.blade.php:13` — current:**

```blade
    @if($dismissible) x-data="{ show: true }" x-show="show" x-transition:leave="transition-[opacity,transform] duration-150 ease-in-out" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-1" @endif
```

Two issues on this one line:

1. **Easing**: the dismiss transition uses `ease-in-out`. Per this repo's
   convention, both entering and exiting use `ease-out`; `ease-in-out` is
   reserved for on-screen repositioning. This was originally reported as
   part of audit finding #2 (easing), alongside four other occurrences —
   the other four (in the dropdown, dialog, and mobile nav) are fixed by
   plan 001.
2. **Reduced motion**: this transition also animates `transform`
   (`-translate-y-1`) with no `prefers-reduced-motion` handling — the same
   gap as audit finding #1 (HIGH, accessibility), which plan 001 fixes for
   the dropdown, dialog, and mobile nav. This file was not included in
   finding #1's location list at audit time — it should have been, since
   it has the identical problem. This plan closes that gap here rather
   than leaving one inconsistent unfixed spot right after the other three
   are fixed.

## Target

```blade
    @if($dismissible) x-data="{ show: true, reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }" x-show="show" :x-transition:leave="reduceMotion ? 'transition-opacity duration-150 ease-out' : 'transition-[opacity,transform] duration-150 ease-out'" x-transition:leave-start="opacity-100" :x-transition:leave-end="reduceMotion ? 'opacity-0' : 'opacity-0 -translate-y-1'" @endif
```

Same pattern as plan 001: a `reduceMotion` boolean added to the existing
`x-data`, the `transition` property list and the `leave-end` transform
both branch on it via Alpine's `:` binding prefix, and `ease-in-out`
becomes `ease-out`.

## Repo conventions to follow

- This is the exact same `reduceMotion`-boolean-in-`x-data` pattern used
  in plan 001 for `dropdown.blade.php`, `dialog.blade.php`, and
  `layouts/base.blade.php` — if plan 001 has already been executed, copy
  its `reduceMotion` line verbatim for consistency; if not, this plan
  introduces the pattern for the first time and plan 001 should follow
  the same wording.
- `x-transition:enter*` is intentionally absent here (this component has
  no enter transition — alerts appear via `animate-fade-up` on initial
  render, handled separately by plan 004). Do not add one.

## Steps

1. In `resources/views/components/ui/alert.blade.php`, replace line 13
   with the Target line shown above. No other line in the file changes.

## Boundaries

- Do NOT touch the `animate-fade-up motion-reduce:animate-none` entrance
  animation on line 14 — that's already correctly gated and is in scope
  for plan 004 (duration), not this plan.
- Do NOT touch any other component. This plan is a single-line change.
- If line 13's current content doesn't match the excerpt above (drift
  since commit `02fb2e5`), STOP and report instead of improvising.

## Verification

- **Mechanical**: `php artisan tinker --execute="use Illuminate\Support\Facades\Blade; try { Blade::compileString(file_get_contents('resources/views/components/ui/alert.blade.php')); echo 'OK'.PHP_EOL; } catch (\Throwable \$e) { echo 'ERROR: '.\$e->getMessage().PHP_EOL; }"` — expect `OK`. Then `npm run build` — expect success.
- **Feel check**: trigger a dismissible alert (e.g. submit the "crear
  género" admin form successfully to get the success alert, or trigger a
  validation error to get the destructive one) and click its close (×)
  button:
  - With no reduced-motion preference, it should fade out while drifting
    up slightly (`-translate-y-1`), same distance as before, just eased
    with `ease-out` instead of `ease-in-out` — in the DevTools Animations
    panel at 10% speed, confirm the motion decelerates smoothly into the
    end state rather than easing symmetrically in and out.
  - With Chrome DevTools Rendering panel set to emulate
    `prefers-reduced-motion: reduce`, dismiss another alert and confirm it
    only fades (no upward drift).
- **Done when**: the alert's dismiss transition eases out (not
  in-out) and respects reduced motion exactly like the three components
  fixed in plan 001.
