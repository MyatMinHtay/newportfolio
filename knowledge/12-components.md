# 12 — Components

**Purpose:** Status catalog of reusable Blade components. Spec detail: [22-ui-components](22-ui-components.md).

**Related:** [05-ui-guidelines](05-ui-guidelines.md) · [13-design-system](13-design-system.md) · [04-coding-style](04-coding-style.md) · [09-roadmap](09-roadmap.md)

**Status values:** `Planned` · `In Progress` · `Completed` · `Deferred`

---

## Conventions

- Path: `resources/views/components/`
- Tags: `<x-alert />`, `<x-form.input />`, `<x-layout.page-header />`
- Preview: `/ui-preview`

---

## Core (Phase 0b) — Completed

| Component | Status | Tag |
|-----------|--------|-----|
| Alert (inline) | Completed | `<x-alert>` |
| Empty State | Completed | `<x-empty-state>` |
| Page Header | Completed | `<x-layout.page-header>` |
| Form Input | Completed | `<x-form.input>` |
| Form Textarea | Completed | `<x-form.textarea>` |
| Form Checkbox | Completed | `<x-form.checkbox>` |
| Form Select | Completed | `<x-form.select>` |
| Badge | Completed | `<x-badge>` |
| Button | Completed | `<x-button>` |
| Card | Completed | `<x-card>` |
| Modal | Completed | `<x-modal>` |
| Table | Completed | `<x-table>` |
| Pagination | Completed | `<x-pagination>` |
| Breadcrumb | Completed | `<x-breadcrumb>` |
| Admin Sidebar | Completed | `<x-layout.admin-sidebar>` |
| Admin Topbar | Completed | `<x-layout.admin-topbar>` |
| Admin Footer | Completed | `<x-layout.admin-footer>` |
| Public Nav | Completed | `<x-navigation.public-nav>` |
| Admin Nav | Completed | `<x-navigation.admin-nav>` |
| Public Footer | Completed | `<x-layout.public-footer>` |
| Flash (inline) | Completed | `<x-layout.flash>` |
| Assets head/scripts | Completed | `<x-layout.assets-*>` |

---

## Notifications

| Component | Status | Notes |
|-----------|--------|-------|
| Toast (Toastify) | Planned | Lib loaded in layouts (ADR-016). Helper API deferred. |

**Rule:** Global notifications → Toastify. Inline → `<x-alert>` only.

---

## Extended (later)

| Component | Status |
|-----------|--------|
| Stat Card | Planned |
| Upload Zone | Planned |
| Tabs | Planned |
| Code Block | Deferred |
| Split Pane | Deferred |
| Theme Toggle | Deferred |
| Quota Meter | Deferred |
