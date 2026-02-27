# Animation improvement plans

Written by `/improve-animations` against commit `02fb2e5`. All six audit
findings were approved for planning. None have been executed yet.

| # | Title | Severity | Status |
| --- | --- | --- | --- |
| [001](001-reduced-motion-on-toggles.md) | Add prefers-reduced-motion handling to dropdown, dialog, and mobile nav | HIGH | TODO |
| [002](002-alert-dismiss-easing-and-reduced-motion.md) | Fix alert dismiss easing and its reduced-motion gap | MEDIUM | TODO |
| [003](003-card-hover-transform-only.md) | Stop transitioning box-shadow on card hover | MEDIUM | TODO |
| [004](004-fade-up-duration-budget.md) | Bring fade-up entrance animation under the 300ms UI budget | MEDIUM | TODO |
| [005](005-admin-card-grid-stagger.md) | Add the catalog's stagger entrance to the admin card grids | Missed opportunity | TODO |
| [006](006-movie-detail-entrance.md) | Add entrance motion to the movie detail page's stat row and info card | Missed opportunity | TODO |

## Recommended execution order

1. **001** first — it's the highest-severity fix and it *introduces* the
   `reduceMotion`-in-`x-data` pattern that 002 explicitly reuses. Doing
   002 first would mean writing that pattern in isolation and 001 having
   nothing to copy from.
2. **002** — trivial once 001 has established the pattern; otherwise
   fine standalone too (002's own Target spells out the full pattern
   independently, so it doesn't hard-block on 001 being merged first).
3. **003** and **004** — fully independent of everything else and of
   each other; either order, or in parallel.
4. **005** — independent, but reuses the `animate-fade-up` token that
   004 shortens. Works correctly whether run before or after 004 (it
   just inherits whatever duration `fade-up` currently has), but running
   004 first means 005's feel-check happens against the final 250ms
   timing instead of the old 500ms.
5. **006** — fully independent, lowest priority, do last or skip.

## Dependencies

- 002 references 001's `reduceMotion` pattern for consistency but does
  not require 001 to be executed first — its own Target section is
  self-contained.
- 005 and 006 both consume the `animate-fade-up` token that 004 modifies
  — no hard dependency, just a soft recommendation to run 004 first (see
  above).
- 003 and everything else are fully independent.
