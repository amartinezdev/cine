# 001 — Add prefers-reduced-motion handling to dropdown, dialog, and mobile nav

- **Status**: TODO
- **Commit**: 02fb2e5
- **Severity**: HIGH
- **Category**: Accessibility
- **Estimated scope**: 3 files, ~10 attribute changes total

## Problem

Three interactive components animate `transform` (scale and/or translate)
on open/close via Alpine's `x-transition`, with zero
`prefers-reduced-motion` handling anywhere. A user with reduced motion
enabled gets full scale/slide movement on every dropdown open, every
dialog open, and every mobile-menu toggle — exactly the class of motion
`prefers-reduced-motion: reduce` exists to suppress.

**`resources/views/components/ui/dropdown.blade.php` (full file, 19 lines) — current:**

```blade
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
```

**`resources/views/components/ui/dialog.blade.php` (full file, 35 lines) — current:**

```blade
<div x-data="{ open: false }" x-on:keydown.escape.window="open = false" {{ $attributes }}>
    <span class="contents" @click="open = true">{{ $trigger }}</span>

    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-200 ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-150 ease-in-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/70"
                @click="open = false"
            ></div>

            <div
                x-show="open"
                x-transition:enter="transition-[opacity,transform] duration-200 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-[opacity,transform] duration-150 ease-in-out"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                role="dialog"
                aria-modal="true"
                class="relative z-10 w-full max-w-md rounded-lg border border-border bg-card text-card-foreground shadow-xl"
            >
                {{ $slot }}
            </div>
        </div>
    </template>
</div>
```

**`resources/views/layouts/base.blade.php:86-96` — current:**

```blade
        <div
            x-show="mobileOpen"
            x-cloak
            x-transition:enter="transition-[opacity,transform] duration-200 ease-out"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition-[opacity,transform] duration-150 ease-in-out"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="border-t border-border px-4 pb-4 pt-2 md:hidden"
        >
```

(`base.blade.php:21` also declares the `<nav x-data="{ mobileOpen: false }" ...>` that owns this panel.)

## Target

Reduced motion means **fewer and gentler animations, not zero** — keep the
opacity fade (it aids comprehension that something appeared/disappeared),
drop the scale/translate entirely. Alpine's `x-transition:*` attributes
take plain strings, so the way to make them media-query-aware is a
boolean computed once in the component's existing `x-data` from
`matchMedia`, then bind the four transition-related attributes
dynamically with Alpine's `:` prefix (`:x-transition:enter`, etc.) instead
of writing them as static attributes.

Also fix the `leave` easing while touching these lines: change
`ease-in-out` to `ease-out` on every `leave` transition below (entering
*and* exiting both use `ease-out` per this repo's convention —
`ease-in-out` is reserved for on-screen repositioning, which none of
these are). This is finding #2 from the audit for these three files;
plan 002 covers the two remaining occurrences elsewhere.

**`dropdown.blade.php` target:**

```blade
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
```

`x-transition:enter-end` and `x-transition:leave-start` are left static at
the fully-settled transform (`scale-100 translate-y-0`) in both branches —
that's correct: when the bound `transition` string doesn't include
`transform`, that value just applies instantly with no animation, so it's
harmless to leave static.

**`dialog.blade.php` target:** the backdrop div (lines 6-16) is already
opacity-only — leave those six `x-transition:*` attributes untouched
except changing `ease-in-out` → `ease-out` on `leave` (line 11). Apply the
same `reduceMotion` pattern used above to the content panel (lines
18-29), swapping `scale-95` for the reduced-motion branch exactly like
the dropdown:

```blade
    <div x-data="{ open: false, reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }" x-on:keydown.escape.window="open = false" {{ $attributes }}>
        <span class="contents" @click="open = true">{{ $trigger }}</span>

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
```

**`base.blade.php` target:** add `reduceMotion` to the `<nav>` tag's
existing `x-data` (line 21: `x-data="{ mobileOpen: false }"` becomes
`x-data="{ mobileOpen: false, reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"`),
then update the mobile menu panel:

```blade
        <div
            x-show="mobileOpen"
            x-cloak
            :x-transition:enter="reduceMotion ? 'transition-opacity duration-200 ease-out' : 'transition-[opacity,transform] duration-200 ease-out'"
            :x-transition:enter-start="reduceMotion ? 'opacity-0' : 'opacity-0 -translate-y-2'"
            x-transition:enter-end="opacity-100 translate-y-0"
            :x-transition:leave="reduceMotion ? 'transition-opacity duration-150 ease-out' : 'transition-[opacity,transform] duration-150 ease-out'"
            x-transition:leave-start="opacity-100 translate-y-0"
            :x-transition:leave-end="reduceMotion ? 'opacity-0' : 'opacity-0 -translate-y-2'"
            class="border-t border-border px-4 pb-4 pt-2 md:hidden"
        >
```

## Repo conventions to follow

- Alpine.js is already a dependency (`resources/js/app.js` calls
  `Alpine.start()`); no new dependency needed, no new file needed.
- `x-cloak` + `[x-cloak] { display: none !important; }` (already defined
  in `resources/css/app.css`) is the existing pattern for hiding
  Alpine-controlled elements before first paint — do not change this.
- Motion-related Tailwind variants elsewhere in this repo use
  `motion-safe:`/`motion-reduce:` on static classes (see
  `resources/views/components/ui/card.blade.php:4` and
  `resources/views/components/ui/input.blade.php:11`) — those only work
  for values that are always in the compiled CSS. Alpine's
  `x-transition:*` values are not compiled that way, which is why this
  plan uses a JS `matchMedia` boolean instead. Do not try to force
  `motion-reduce:`/`motion-safe:` into an `x-transition:*` string.

## Steps

1. In `resources/views/components/ui/dropdown.blade.php`, replace the
   whole file with the target shown above.
2. In `resources/views/components/ui/dialog.blade.php`, replace the whole
   file with the target shown above.
3. In `resources/views/layouts/base.blade.php`, change line 21's `x-data`
   to add `reduceMotion`, then replace lines 86-96 (the mobile menu panel)
   with the target shown above.

## Boundaries

- Do NOT touch `resources/views/components/ui/alert.blade.php` — its
  dismiss transition is a much smaller movement (`-translate-y-1`) and is
  handled by plan 002, not this one.
- Do NOT add a JS motion library, a Livewire/Alpine plugin, or a
  `useReducedMotion`-style helper file — inline `matchMedia` in `x-data`
  is the correct scope for a plain Blade/Alpine app this size.
- Do NOT change the trigger markup (`$trigger`/`$slot` usage), `x-cloak`,
  `x-teleport`, ARIA attributes, or any non-transition classes.
- If the current code in any of the three files doesn't match the
  excerpts above (drift since commit `02fb2e5`), STOP and report instead
  of improvising — the dynamic-binding approach depends on the exact
  current attribute names and values.

## Verification

- **Mechanical**: run
  `php artisan tinker --execute="use Illuminate\Support\Facades\Blade; foreach (['resources/views/components/ui/dropdown.blade.php','resources/views/components/ui/dialog.blade.php','resources/views/layouts/base.blade.php'] as \$f) { try { Blade::compileString(file_get_contents(\$f)); echo \"OK \$f\".PHP_EOL; } catch (\Throwable \$e) { echo \"ERROR \$f: \".\$e->getMessage().PHP_EOL; } }"` —
  expect `OK` for all three. Then `npm run build` — expect it to complete
  with no Tailwind/PostCSS errors (the class strings inside the ternaries
  are still static literals, so Tailwind's content scanner finds them).
- **Feel check**: in Chrome DevTools → Rendering panel → "Emulate CSS
  media feature prefers-reduced-motion" → "reduce":
  - Open the admin "Admin" dropdown in the navbar: it should fade in with
    no scale or slide.
  - Open the "Comprar Entrada" dialog on a movie detail page: the panel
    fades in centered, no scale.
  - Resize below the `md` breakpoint and open the hamburger menu: the
    panel fades in, no slide.
  - Switch the emulation to "no preference" and repeat all three — full
    scale/translate motion should return exactly as it was before this
    change.
  - With reduced motion off, in the Animations panel step through the
    dropdown/dialog/mobile-nav leave transitions at 10% speed and confirm
    they now ease out symmetrically with their enter transitions (no
    visible hitch from the `ease-in-out` → `ease-out` swap).
- **Done when**: all three components show opacity-only transitions with
  reduced motion enabled, unchanged transform+opacity transitions with it
  disabled, and both the Blade compile check and `npm run build` succeed.
