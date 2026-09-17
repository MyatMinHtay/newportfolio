# 13 — Design System

**Purpose:** UI source of truth for tokens, component styles, responsive and accessibility rules.  
**Implementation:** `public/assets/css/app.css` (tokens) + Bootstrap 5 + Blade components ([22-ui-components](22-ui-components.md)).  
**No page designs in this file.**

**Related:** [05-ui-guidelines](05-ui-guidelines.md) · [12-components](12-components.md) · [22-ui-components](22-ui-components.md) · ADR-001 · ADR-010 · ADR-015 · ADR-016

---

## Table of contents

1. [Principles](#1-principles)
2. [Color palette](#2-color-palette)
3. [Typography scale](#3-typography-scale)
4. [Spacing system](#4-spacing-system)
5. [Radius & shadows](#5-radius--shadows)
6. [Z-index & transitions](#6-z-index--transitions)
7. [Breakpoints & container](#7-breakpoints--container)
8. [Buttons](#8-buttons)
9. [Forms](#9-forms)
10. [Tables](#10-tables)
11. [Cards](#11-cards)
12. [Modals](#12-modals)
13. [Alerts vs toasts](#13-alerts-vs-toasts)
14. [Badges](#14-badges)
15. [Icons](#15-icons)
16. [Responsive rules](#16-responsive-rules)
17. [Accessibility rules](#17-accessibility-rules)
18. [Motion](#18-motion)
19. [Dark mode](#19-dark-mode)

---

## 1. Principles

1. Clarity and restraint — one accent family (teal)
2. Bootstrap-native — theme via CSS variables, don’t fight the framework
3. Same language for public and admin (admin may be denser)
4. Content first; chrome second
5. Accessible contrast (WCAG AA where practical)

Inspiration: GitHub, Laravel Docs, Linear (calm).

---

## 2. Color palette

CSS custom properties (prefix `--pf-`):

### Light Theme (Default)

| Role | Hex | RGB | HSL | CSS Variable |
|------|-----|-----|-----|--------------|
| **Text** | `#030507` | `rgb(3, 5, 7)` | `hsl(210, 40%, 2%)` | `--pf-text` |
| **Background** | `#f5f9fb` | `rgb(245, 249, 251)` | `hsl(200, 43%, 97%)` | `--pf-bg` |
| **Primary** | `#3B82F6` | `rgb(59, 130, 246)` | `hsl(217, 91%, 60%)` | `--pf-primary` / `--bs-primary` |
| **Secondary** | `#47566b` | `rgb(71, 86, 107)` | `hsl(215, 20%, 35%)` | `--pf-secondary` / `--bs-secondary` |
| **Accent** | `#06B6D4` | `rgb(6, 182, 212)` | `hsl(189, 94%, 43%)` | `--pf-accent` / `--bs-info` |
| Surface | `#ffffff` | `rgb(255, 255, 255)` | — | `--pf-surface` |
| Surface muted | `#e9f0f5` | — | — | `--pf-surface-muted` |
| Border | `#dbe4ea` | — | — | `--pf-border` |
| Border strong | `#bac7d5` | — | — | `--pf-border-strong` |
| Text muted | `#47566b` | `rgb(71, 86, 107)` | — | `--pf-text-muted` |

#### Light Theme Gradients

| Gradient Name | Definition |
|---------------|------------|
| `--linearPrimarySecondary` | `linear-gradient(#3B82F6, #47566b)` |
| `--linearPrimaryAccent` | `linear-gradient(#3B82F6, #06B6D4)` |
| `--linearSecondaryAccent` | `linear-gradient(#47566b, #06B6D4)` |
| `--radialPrimarySecondary` | `radial-gradient(#3B82F6, #47566b)` |
| `--radialPrimaryAccent` | `radial-gradient(#3B82F6, #06B6D4)` |
| `--radialSecondaryAccent` | `radial-gradient(#47566b, #06B6D4)` |

Bootstrap `--bs-primary` maps to `--pf-primary` (`#3B82F6`), `--bs-secondary` maps to `--pf-secondary` (`#47566b`), and `--bs-info` maps to `--pf-accent` (`#06B6D4`).

---

## 3. Typography scale

| Token / role | Size | Weight |
|--------------|------|--------|
| Font sans | system-ui stack (`--pf-font-sans`) | — |
| Font mono | ui-monospace stack | — |
| `--pf-text-xs` | 0.75rem | meta |
| `--pf-text-sm` | 0.875rem | help, footer |
| `--pf-text-base` | 1rem | body |
| `--pf-text-lg` | 1.125rem | H4 |
| `--pf-text-xl` | 1.25rem | H3 |
| `--pf-text-2xl` | 1.5rem | H2 |
| `--pf-text-3xl` | 1.875rem | H1 |

Line heights: tight `1.25` (headings), normal `1.6` (body), relaxed `1.75` (long-form later).

One `h1` per page. No novelty display/serif fonts in v1.

---

## 4. Spacing system

Scale: `--pf-space-0` … `--pf-space-10` (0 → 4rem). Prefer Bootstrap spacing utilities (`m-*`, `p-*`, `gap-*`) aligned to this rhythm.

| Context | Guidance |
|---------|----------|
| Page sections | `--pf-space-8` vertical |
| Card padding | Bootstrap `card-body` / `p-3` |
| Form groups | `mb-3` |
| Admin density | Slightly tighter than public |

Helpers: `.pf-stack`, `.pf-stack-sm`, `.pf-stack-lg`.

---

## 5. Radius & shadows

| Token | Value |
|-------|-------|
| `--pf-radius-sm` | 0.25rem |
| `--pf-radius` | 0.5rem (default) |
| `--pf-radius-lg` | 0.75rem |
| `--pf-shadow-sm` | subtle |
| `--pf-shadow` | cards |
| `--pf-shadow-md` | elevated / offcanvas |

No multi-layer neon glows. No pill-everything aesthetics.

---

## 6. Z-index & transitions

Z ladder: dropdown → sticky → fixed → modal-backdrop → modal → popover → tooltip → **toast (`--pf-z-toast: 1090`)**.

Transitions: `--pf-duration-fast` 150ms, `--pf-duration` 200ms, `--pf-duration-slow` 300ms. Prefer color/opacity/border/shadow — not width/height layout animation.

---

## 7. Breakpoints & container

| Token | Width |
|-------|-------|
| `--pf-bp-sm` | 576px |
| `--pf-bp-md` | 768px |
| `--pf-bp-lg` | 992px |
| `--pf-bp-xl` | 1200px |
| `--pf-bp-xxl` | 1400px |
| `--pf-container` | 1140px |
| `--pf-container-narrow` | 720px |
| `--pf-admin-sidebar-width` | 240px |

Use Bootstrap’s grid and breakpoints in practice; tokens document intent.

---

## 8. Buttons

| Variant | Use |
|---------|-----|
| `primary` | Main CTA |
| `secondary` / `outline-secondary` | Cancel, secondary |
| `danger` | Destructive |
| `link` | Tertiary |

Sizes: default forms; `sm` in tables. Component: `<x-button>`.

---

## 9. Forms

- Labels above inputs
- Required marker `*`
- Validation: `is-invalid` + feedback
- Help: `.form-text`
- Components: `<x-form.input>`, `<x-form.textarea>`, `<x-form.checkbox>`, `<x-form.select>`

---

## 10. Tables

- Wrap with `<x-table>` (`table-responsive`)
- Optional hover/striped
- Actions column right-aligned, `btn-sm`
- Header quiet (not loud color blocks)

---

## 11. Cards

- Surface + border + light shadow (`.pf-surface` / `<x-card>`)
- Optional header/footer slots
- No glassmorphism

---

## 12. Modals

- Bootstrap modal via `<x-modal>`
- Confirm destructive actions
- Use built-in Bootstrap transitions only

---

## 13. Alerts vs toasts

| Kind | Tool | Use |
|------|------|-----|
| **Global notification** | Toastify (`public/assets/libs/toast/`) | Login/save/delete/validation/permission/upload |
| **Inline message** | `<x-alert>` Bootstrap Alert | Contextual page notices, validation summary block |

Do not use Bootstrap Alert for global flash success/error. Do not add another toast package (ADR-016).

---

## 14. Badges

Published / Draft / Featured / Unread — text + color. Component: `<x-badge>`.

---

## 15. Icons

Bootstrap Icons only. Decorative icons need accompanying text or `aria-label` on icon-only controls.

---

## 16. Responsive rules

| Breakpoint | Behavior |
|------------|----------|
| `< md` | Collapsed public nav; admin sidebar → offcanvas |
| `md+` | Horizontal nav; fixed admin sidebar |
| `lg+` | Comfortable reading measure for blog later |

Mobile-first. Tables never force page-wide horizontal scroll without `table-responsive`. Touch targets ≥ ~40px where practical.

---

## 17. Accessibility rules

1. One `h1` per page; logical heading order  
2. Associate every input with a `<label>`  
3. Visible `:focus-visible` ring (accent)  
4. Do not rely on color alone for status  
5. `aria-label` on icon-only buttons  
6. Modals: use Bootstrap’s labelled-by pattern  
7. Respect `prefers-reduced-motion`  

---

## 18. Motion

| Concern | Guideline |
|---------|-----------|
| Hover | Color / underline / border — avoid large scale |
| Duration | 150–300ms typical; ≤ 400ms UI chrome |
| Loading | Prefer disabled button for short submits |

---

## 19. Dark mode

Activated via `[data-bs-theme="dark"]` attribute or `html.dark` / `body.dark` class. State is persisted in `localStorage('portfolio_theme')`.

### Dark Theme Palette

| Role | Hex | RGB | HSL | CSS Variable |
|------|-----|-----|-----|--------------|
| **Text** | `#f8fafc` | `rgb(248, 250, 252)` | `hsl(210, 40%, 98%)` | `--pf-text` |
| **Background** | `#04090b` | `rgb(4, 9, 11)` | `hsl(197, 47%, 3%)` | `--pf-bg` |
| **Primary** | `#38bdf8` | `rgb(56, 189, 248)` | `hsl(198, 93%, 60%)` | `--pf-primary` / `--bs-primary` |
| **Secondary** | `#47566b` | `rgb(71, 86, 107)` | `hsl(215, 20%, 35%)` | `--pf-secondary` / `--bs-secondary` |
| **Accent** | `#2ad9f8` | `rgb(42, 217, 248)` | `hsl(189, 94%, 57%)` | `--pf-accent` / `--bs-info` |
| Surface | `#0b1318` | — | — | `--pf-surface` |
| Surface muted | `#111e27` | — | — | `--pf-surface-muted` |
| Border | `#1a2c38` | — | — | `--pf-border` |
| Border strong | `#273e4f` | — | — | `--pf-border-strong` |
| Text muted | `#94a3b8` | — | — | `--pf-text-muted` |

#### Dark Theme Gradients

| Gradient Name | Definition |
|---------------|------------|
| `--linearPrimarySecondary` | `linear-gradient(#38bdf8, #47566b)` |
| `--linearPrimaryAccent` | `linear-gradient(#38bdf8, #2ad9f8)` |
| `--linearSecondaryAccent` | `linear-gradient(#47566b, #2ad9f8)` |
| `--radialPrimarySecondary` | `radial-gradient(#38bdf8, #47566b)` |
| `--radialPrimaryAccent` | `radial-gradient(#38bdf8, #2ad9f8)` |
| `--radialSecondaryAccent` | `radial-gradient(#47566b, #2ad9f8)` |

---

## Asset paths (official)

```text
public/assets/
├── css/app.css
├── js/app.js
└── libs/
    ├── bootstrap/
    ├── bootstrap-icons/
    ├── toast/          ← Toastify
    ├── jquery/         ← reserved
    ├── gsap/           ← reserved
    ├── slick/          ← reserved
    └── splide/         ← reserved
```

---

## Maintenance

Update this document **before** large token/CSS changes. Keep [22-ui-components](22-ui-components.md) in sync when adding components. Preview at `/ui-preview`.
