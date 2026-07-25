# 13 — Design System

**Purpose:** Visual language and token documentation. **No CSS code in this file** — implementation happens in `resources/css/app.css` during Phase 0+.

**Related:** [05-ui-guidelines](05-ui-guidelines.md) · [12-components](12-components.md) · [06-decisions](06-decisions.md) (ADR-001, ADR-010)

---

## Table of contents

1. [Design principles](#1-design-principles)
2. [Typography](#2-typography)
3. [Color tokens](#3-color-tokens)
4. [Spacing](#4-spacing)
5. [Radius](#5-radius)
6. [Shadows](#6-shadows)
7. [Icons](#7-icons)
8. [Buttons](#8-buttons)
9. [Forms](#9-forms)
10. [Cards](#10-cards)
11. [Tables](#11-tables)
12. [Alerts and badges](#12-alerts-and-badges)
13. [Dropdowns](#13-dropdowns)
14. [Responsive rules](#14-responsive-rules)
15. [Responsive philosophy](#15-responsive-philosophy)
16. [Interaction principles](#16-interaction-principles)
17. [Motion guidelines](#17-motion-guidelines)
18. [Dark mode strategy](#18-dark-mode-strategy-future)

---

## 1. Design principles

1. **Clarity** — readable type, clear hierarchy  
2. **Restraint** — one accent family; limited decoration  
3. **Consistency** — same patterns in public and admin  
4. **Bootstrap-native** — theme Bootstrap rather than fighting it  
5. **Accessible contrast** — text/background meet WCAG AA where practical  

Inspiration: GitHub, Laravel Docs, Linear (calm, not flashy).

---

## 2. Typography

| Role | Guidance |
|------|----------|
| Font family | System stack or one clean sans (e.g. system-ui / Inter-like via Bunny/Google only if needed) |
| Body | Comfortable size (~1rem), line-height ~1.5–1.6 |
| Page title | Strong weight; one H1 |
| Section title | H2/H3 with consistent margins |
| Muted | Secondary text for help/meta |
| Mono | Optional for slugs/IDs in admin |

Do not introduce display/serif novelty fonts for v1.

---

## 3. Color tokens

Define CSS custom properties (names illustrative):

| Token | Role |
|-------|------|
| `--pf-bg` | Page background (near-white / soft gray) |
| `--pf-surface` | Cards, sidebar, nav |
| `--pf-border` | Hairline borders |
| `--pf-text` | Primary text |
| `--pf-text-muted` | Secondary text |
| `--pf-accent` | Primary actions / links |
| `--pf-accent-hover` | Hover accent |
| `--pf-danger` | Destructive |
| `--pf-success` | Success states |
| `--pf-warning` | Warning states |

Map Bootstrap `$primary` (or CSS overrides) to `--pf-accent` so components stay coherent.

Avoid purple-on-white cliché gradients as brand identity.

---

## 4. Spacing

Use Bootstrap spacing scale (`0`–`5` / `4` / `5`) consistently.

| Context | Guidance |
|---------|----------|
| Page sections | Generous vertical gap |
| Card padding | Comfortable, not cramped |
| Form groups | Consistent `mb-*` |
| Admin density | Slightly tighter than public |

---

## 5. Radius

- Prefer Bootstrap default radius or a single custom radius token (e.g. 0.5rem)
- Keep radius consistent across cards, buttons, inputs
- Avoid large “pill everything” aesthetics

---

## 6. Shadows

- Prefer subtle shadows or border-only elevation
- One soft shadow token for cards/dropdowns
- No multi-layer neon glows

---

## 7. Icons

- **Bootstrap Icons only**
- Size aligned with text (1em–1.25em for inline)
- Always pair icon-only controls with `aria-label` or visible text for primary actions

---

## 8. Buttons

| Variant | Use |
|---------|-----|
| Primary | Main CTA (Create, Save, Send) |
| Outline secondary | Cancel, secondary nav |
| Danger | Delete / destructive confirm |
| Link | Tertiary actions |

Sizes: default for forms; `btn-sm` in tables.

---

## 9. Forms

- Labels above fields
- Validation: Bootstrap `is-invalid` + feedback text
- Help text muted under fields
- Full-width inputs on mobile

---

## 10. Cards

- Light surface + border
- Optional header/footer
- Used for public project grids and admin dashboard widgets
- No heavy glassmorphism

---

## 11. Tables

- `table` + optional `table-hover`
- Header contrast subtle (not loud color blocks)
- Action buttons `btn-sm`
- Wrap with `table-responsive`

---

## 12. Alerts and badges

- Alerts: success / danger / warning / info — match flash types
- Badges: published/draft/featured/unread — text + color, not color alone

---

## 13. Dropdowns

- Bootstrap dropdowns for user menu and row actions if needed
- Prefer visible buttons when only 1–2 actions exist

---

## 14. Responsive rules

| Breakpoint | Behavior |
|------------|----------|
| `< md` | Collapsed nav; stacked forms; offcanvas admin sidebar |
| `md+` | Horizontal nav; multi-column grids |
| `lg+` | Comfortable reading measure for blog |

Touch targets ≥ ~40px where possible.

---

## 15. Responsive philosophy

- **Mobile first:** layout must work at 360px width before enhancing.
- **Progressive enhancement:** core content readable without fancy JS.
- **Reflow over shrink:** stack columns; don’t force tiny unreadable tables.
- **Admin usability on tablet:** sidebar may become offcanvas; primary actions remain reachable.
- **Public marketing restraint:** avoid hero carousels and auto-play motion.

---

## 16. Interaction principles

1. Feedback is immediate (hover/focus/active states).
2. Destructive actions require confirmation.
3. Primary action per view is visually dominant (one primary button).
4. Don’t animate layout shifts that disorient (especially sidebar).
5. Prefer opacity/color/underline transitions over bouncing motion.
6. Respect `prefers-reduced-motion` (disable non-essential animation).

---

## 17. Motion guidelines

| Concern | Guideline |
|---------|-----------|
| **Default duration** | 150–200ms for color/opacity; 200–300ms for small transforms |
| **Max duration** | ≤ 400ms for UI chrome; longer only for deliberate page transitions (rare) |
| **Easing** | Ease-out for entrances; ease-in-out for toggles |
| **Hover** | Subtle color / underline / border; avoid large scale (`scale(1.05+)` discouraged) |
| **Focus** | Visible focus ring (Bootstrap defaults or tokenized outline); never `outline: none` without replacement |
| **Active/pressed** | Slightly darker accent; no extreme press animations |
| **Transitions** | Transition `color`, `background-color`, `border-color`, `opacity`, `box-shadow`; avoid transitioning `width`/`height`/`top`/`left` |
| **Loading** | Spinners only for waits > ~300ms; prefer disabled button state for short submits |
| **Modals** | Use Bootstrap’s built-in transitions; don’t stack custom animations on top |

**Documentation only — no CSS in this file.** Implement tokens/rules in `resources/css/app.css` during Phase 0+.

---

## 18. Dark mode strategy (future)

- v1 ships **light only** (ADR-010)
- Implement tokens so dark mode can override variables later
- Prefer Bootstrap 5.3 `data-bs-theme` when enabling
- Theme toggle component remains deferred ([12-components](12-components.md), [10-ideas](10-ideas.md))

---

## Maintenance

When changing colors/type/motion, update this document **before** large CSS refactors so AI/humans stay aligned.
