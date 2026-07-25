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
```

Nav items: Home, About, Experience, Skills, Projects, Blog, Contact, Resume.

Mobile: Bootstrap collapse navbar. Keep tap targets comfortable.

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
- Success/error via flash + `<x-alert>`
- Prefer inline confirmation for deletes (Bootstrap modal)

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

## 11. Dark mode

**Not in v1.**  
Reserve CSS variables so a future `data-bs-theme="dark"` (or equivalent) can be added without restructuring layouts. See [13-design-system](13-design-system.md) and [10-ideas](10-ideas.md).
