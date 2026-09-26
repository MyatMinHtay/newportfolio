# 05 — UI Guidelines

**Purpose:** How public and admin interfaces should feel and behave. Visual tokens live in [13-design-system](13-design-system.md). Components in [12-components](12-components.md).

**Related:** [01-project-overview](01-project-overview.md) · [02-architecture](02-architecture.md) · [13-design-system](13-design-system.md)

---

## Table of contents

1. [Philosophy](#1-philosophy)
2. [Inspiration](#2-inspiration)
3. [Page hierarchy](#3-page-hierarchy)
4. [Public layout](#4-public-layout)
5. [Admin layout](#5-admin-layout)
6. [Typography and spacing](#6-typography-and-spacing)
7. [Forms and tables](#7-forms-and-tables)
8. [Empty states and feedback](#8-empty-states-and-feedback)
9. [Responsive behavior](#9-responsive-behavior)
10. [Accessibility](#10-accessibility)
11. [Dark mode](#11-dark-mode)

---

## 1. Philosophy

- Simple, professional, minimal, readable
- Content first; chrome second
- Consistency over novelty
- One accent color family; neutral surfaces

---

## 2. Inspiration

Aim for the calm clarity of:

- GitHub documentation / UI density
- Laravel Docs structure
- Linear’s restraint (not Linear’s full product chrome)

Avoid: heavy glassmorphism, neon cyberpunk, purple-gradient SaaS clichés, emoji-laden marketing blocks.

---

## 3. Page hierarchy

Every page should usually contain:

1. Clear page title
2. Optional short supporting sentence
3. Primary content
4. Optional secondary actions

Admin list pages: title + primary “Create” button + table/filters.  
Admin form pages: title + form + cancel/save.

---

## 4. Public layout

```
Top navbar (brand + links + Resume CTA)
Main content (container)
Footer (social links + copyright from settings)
@stack('modals') (Document root modal dialogs)
```

Nav items: Home, About, Experience, Skills, Projects, Blog, Contact, Resume.

Mobile: Bootstrap collapse navbar. Keep tap targets comfortable. Fully responsive down to 320px minimum screen width.

Modals: Must always be pushed to `@stack('modals')` at the root of `<body>` rather than nested inside `<main>` or layout containers, preventing Bootstrap `.modal-backdrop` stacking context trapping.

Footer data comes from settings + published social links (View Composer recommended).

---

## 5. Admin layout

```
Left sidebar (nav + unread badge on Messages)
Top bar (page context / user menu)
Main (flash alerts + content)
```

Sidebar groups (logical order):

- Dashboard
- Content: Projects, Blog, Categories
- Profile content: Experience, Skills, Social, Resume
- Inbox: Messages
- System: Settings

Do not invent a second admin visual language. Same Bootstrap + tokens as public, denser spacing allowed.

---

## 6. Typography and spacing

- System / clean sans (document exact stack in design system)
- **Minimum Font Size Floor:**
  - **Desktop / PC Minimum:** `16px` (`1rem`) for all `small`, `.small`, `.badge`, `.pf-tech-pill`, and secondary meta.
  - **Mobile Minimum:** `12px` (`0.75rem`) on viewports `<= 575.98px` (strict legibility floor down to `320px`).
- Comfortable line length for blog posts (~65–75 characters)
- Consistent vertical rhythm (section gaps via spacing scale)
- Prefer Bootstrap type utilities; avoid one-off font sizes

---

## 7. Forms and tables

- Forms: labels above inputs; validation errors under fields + optional top alert
- Required fields marked
- Tables: striped optional; actions column right-aligned; confirm destructive actions
- Pagination: Bootstrap 5 pagination component

---

## 8. Empty states and feedback

- Every index needs an empty state (icon + message + CTA when relevant)
- **Global notifications** (login/save/delete/validation/permission/upload): Toastify via `public/assets/libs/toast/` (ADR-016). Full rules: [27-toast-guidelines](27-toast-guidelines.md). Do not use Bootstrap Alert for these.
- **Inline page messages** only: `<x-alert>` (contextual notices on a page)
- Prefer modal confirmation for deletes (Bootstrap modal)

---

## 9. Responsive behavior

- Mobile-first Bootstrap grid
- Tables: wrap in `table-responsive`
- Admin sidebar: collapsible / offcanvas on small screens
- No horizontal scroll on public pages except intentional code/tables

---

## 10. Accessibility

- Semantic headings (one `h1` per page)
- Buttons/links distinguishable
- Form inputs associated with labels
- Sufficient color contrast on accent/text
- Do not rely on color alone for status (use text/badge labels)
- Icons decorative: provide text labels for primary actions

---

## 11. Dark mode & Theme Guidelines

The project supports both **Light Theme** and **Dark Theme** using CSS variables and Bootstrap 5's native `[data-bs-theme="dark"]` attribute (alongside `.dark` class).

- **Theme Persistence:** Stored in `localStorage('portfolio_theme')` and applied via `public/assets/js/app.js`.
- **Contrast & Hierarchy:**
  - Light mode uses a clean high-contrast palette (`#030507` text on `#f5f9fb` soft background with `#3B82F6` primary and `#06B6D4` cyan accent).
  - Dark mode flips to high-contrast dark surfaces (`#f8fafc` text on `#04090b` deep background with `#38bdf8` sky primary and `#2ad9f8` vibrant accent).
- **Gradients:** Both themes include 3 linear and 3 radial gradients combining Primary, Secondary (`#47566b`), and Accent colors.
- Full token and gradient definitions: [13-design-system](13-design-system.md).
