# 004 — Bring fade-up entrance animation under the 300ms UI budget

- **Status**: TODO
- **Commit**: 02fb2e5
- **Severity**: MEDIUM
- **Category**: Easing & duration
- **Estimated scope**: 1 file, 1 line (fixes every usage sitewide via the shared token)

## Problem

**`tailwind.config.js:76-79` — current:**

```js
animation: {
    'fade-up': 'fade-up .5s cubic-bezier(0.23, 1, 0.32, 1) both',
    shake: 'shake .4s cubic-bezier(.36,.07,.19,.97) both',
},
```

`fade-up` runs 500ms. This skill's duration budget is explicit: "UI
animations stay under 300ms." 500ms is 67% over. This one token is used
as `animate-fade-up` in six places:

- `resources/views/peliculas/index.blade.php:40` — the catalog card-grid
  stagger entrance (60ms delay per card, capped at index 8).
- `resources/views/peliculas/index.blade.php:110` — the catalog "no
  results" empty state.
- `resources/views/admin/peliculas/index.blade.php`,
  `resources/views/admin/generos/index.blade.php`,
  `resources/views/admin/promociones/index.blade.php` — their respective
  empty states (same pattern as above).
- `resources/views/errors/404.blade.php:5` — the whole 404 page body.
- `resources/views/components/ui/alert.blade.php:14` — **every** alert
  gets this animation unconditionally (not just dismissible ones),
  including the promo banner and every session-flash message, so this is
  the highest-frequency user-facing instance of the 500ms wait.

Because the fix lives in the shared Tailwind `animation` token, fixing it
once in `tailwind.config.js` fixes all six usages simultaneously — none of
the six Blade files need to change.

## Target

```js
animation: {
    'fade-up': 'fade-up .25s cubic-bezier(0.23, 1, 0.32, 1) both',
    shake: 'shake .4s cubic-bezier(.36,.07,.19,.97) both',
},
```

Only the `fade-up` duration changes, `.5s` → `.25s` (250ms — comfortably
under the 300ms budget, still long enough to read as a deliberate
entrance rather than a flicker). The `shake` animation (400ms) is
untouched — it's a one-shot validation-feedback cue, not a UI-control
entrance, and this skill's duration table doesn't budget it the same way;
it was not flagged in the audit.

The keyframe definition itself
(`tailwind.config.js:64-68`, `'fade-up': { from: { opacity: 0, transform:
'translateY(14px)' }, to: { opacity: 1, transform: 'none' } }`) does not
need to change — only the duration in the `animation` mapping.

## Repo conventions to follow

- The `fade-up`/`shake` keyframes and their `animation` mappings are the
  only two custom animation tokens in this repo, both defined in
  `tailwind.config.js` under `theme.extend.keyframes` /
  `theme.extend.animation` — this is the established location for any
  animation token; do not define a competing one elsewhere (e.g. a raw
  `@keyframes` block in `resources/css/app.css`).
- `resources/views/peliculas/index.blade.php:41` sets a per-card
  `animation-delay` inline (`style="animation-delay: {{ min($loop->index,
  8) * 0.06 }}s"`) — this stagger delay is unrelated to the animation's
  own duration and is already within this skill's recommended 30–80ms
  stagger range. Do not change it as part of this plan.

## Steps

1. In `tailwind.config.js`, change `'fade-up .5s cubic-bezier(0.23, 1, 0.32, 1) both'` to `'fade-up .25s cubic-bezier(0.23, 1, 0.32, 1) both'` on the `fade-up` line inside `theme.extend.animation`. Leave the `shake` line and the `keyframes` block untouched.

## Boundaries

- Do NOT touch any of the six Blade files listed in Problem — they
  reference the animation by name (`animate-fade-up`) and inherit the new
  duration automatically once the config changes.
- Do NOT change the `fade-up` keyframe's translateY distance (14px), its
  easing curve, or the `shake` animation at all.
- Do NOT change the per-card stagger delay in
  `peliculas/index.blade.php:41`.
- If `tailwind.config.js`'s `animation.fade-up` line doesn't match the
  excerpt above (drift since commit `02fb2e5`), STOP and report instead
  of improvising.

## Verification

- **Mechanical**: `npm run build` — expect success. Then confirm the new
  duration made it into the compiled CSS:
  `node -e "const fs=require('fs');const f=fs.readdirSync('public/build/assets').find(x=>x.startsWith('app-')&&x.endsWith('.css'));const c=fs.readFileSync('public/build/assets/'+f,'utf8');console.log(c.includes('fade-up .25s')||c.includes('fade-up:.25s')?'FOUND 250ms':'NOT FOUND — check output');"`
  — adjust the substring check if Tailwind's minifier reformats the
  animation shorthand differently; the goal is confirming `.25s` (not
  `.5s`) appears associated with the `fade-up` animation name in the
  built CSS.
- **Feel check**: load the public catalog (`/`) in a real browser with
  several movies seeded:
  - The card grid should still read as a cascade (thanks to the
    unchanged 60ms per-card stagger), just settling noticeably faster
    than before — compare by eye against a git-stashed version if unsure.
  - Trigger a session-flash alert (e.g. successfully create a género in
    the admin panel) and confirm it appears crisply, not with a visible
    half-second lag before the text is legible.
  - In DevTools Animations panel, select the `fade-up` animation on any
    element and confirm its duration reads `250ms` (previously `500ms`).
  - Toggle `prefers-reduced-motion: reduce` in the Rendering panel and
    confirm `motion-reduce:animate-none` (already present alongside every
    `animate-fade-up` usage in this repo, including
    `alert.blade.php:14`) still suppresses the animation everywhere it's
    applied.
- **Done when**: `tailwind.config.js` reports 250ms for `fade-up`, the
  compiled CSS reflects it, and all six usage sites visually settle
  faster with no other behavior change.
