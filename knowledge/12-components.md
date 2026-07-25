# 12 — Components

**Purpose:** Catalog of reusable Blade components. Spec only — no implementation code in this file.

**Related:** [05-ui-guidelines](05-ui-guidelines.md) · [13-design-system](13-design-system.md) · [04-coding-style](04-coding-style.md) · [09-roadmap](09-roadmap.md)

**Status values:** `Planned` · `In Progress` · `Completed` · `Deferred`

---

## Conventions

- Path: `resources/views/components/`
- Tags: `<x-alert />`, `<x-admin.page-header />`
- When implementing: set Status → In Progress → Completed; note phase; update [08-changelog](08-changelog.md)

---

## Core (Phase 0–1)

### Alert

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Flash / inline status messages |
| **Props** | `type` (success\|danger\|warning\|info), `message`, `dismissible` (bool, optional) |
| **Usage** | Top of layout content after session flash |
| **Dependencies** | Bootstrap alert |
| **Future** | Optional toast channel |

### Empty State

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Zero-data placeholder |
| **Props** | `title`, `description`, `icon` (optional), `actionLabel`, `actionUrl` |
| **Usage** | Admin/public indexes |
| **Dependencies** | Bootstrap Icons |
| **Future** | Illustration variants |

### Page Header (admin)

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Consistent admin title + actions row |
| **Props** | `title`, `subtitle` (optional), actions slot |
| **Usage** | Every admin page |
| **Dependencies** | Button component (optional) |
| **Future** | Breadcrumb integration |

### Form Input

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Labeled input + validation error |
| **Props** | `name`, `label`, `type`, `value`, `required`, `help` |
| **Usage** | Admin forms |
| **Dependencies** | Laravel `$errors` |
| **Future** | Prefix/suffix addons |

### Form Textarea

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Multiline / Markdown fields |
| **Props** | `name`, `label`, `value`, `rows`, `required`, `help` |
| **Usage** | Body, summary, description |
| **Dependencies** | Laravel `$errors` |
| **Future** | Split-pane preview |

### Form Checkbox

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Boolean flags |
| **Props** | `name`, `label`, `checked` |
| **Usage** | `is_published`, `is_featured`, etc. |
| **Dependencies** | Bootstrap form-check |
| **Future** | Switch style option |

### Badge

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Status chips |
| **Props** | `variant`, `label` |
| **Usage** | Tables (Published, Draft, Featured, Unread) |
| **Dependencies** | Bootstrap badge |
| **Future** | Dot indicators |

### Button

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Consistent CTAs |
| **Props** | `variant`, `type`, `href` (optional), `size`, slot label |
| **Usage** | Forms and tables |
| **Dependencies** | Bootstrap `btn` |
| **Future** | Loading state |

### Card

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Surface container |
| **Props** | `title` (optional), body slot, footer slot |
| **Usage** | Project grids, dashboard widgets |
| **Dependencies** | Bootstrap card / custom tokens |
| **Future** | Hover elevation token |

### Modal

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Confirm dialogs |
| **Props** | `id`, `title`, `body`, confirm form/action attrs |
| **Usage** | Deletes |
| **Dependencies** | Bootstrap Modal JS |
| **Future** | Focus trap audit |

### Table

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Responsive table wrapper |
| **Props** | Default slot (`<table>`) |
| **Usage** | Admin indexes |
| **Dependencies** | Bootstrap table |
| **Future** | Sticky header |

### Pagination

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | List pagination |
| **Props** | N/A — Laravel `links()` after Bootstrap 5 paginator config |
| **Usage** | Indexes |
| **Dependencies** | Laravel paginator |
| **Future** | Simple prev/next on public |

### Sidebar (admin)

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Admin navigation |
| **Props** | Active route via `routeIs` |
| **Usage** | Admin layout |
| **Dependencies** | Bootstrap Icons, Badge (unread) |
| **Future** | Collapsible groups |

### Breadcrumb

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Path context |
| **Props** | items: `{ label, url? }[]` |
| **Usage** | Nested edit screens |
| **Dependencies** | Bootstrap breadcrumb |
| **Future** | Auto from route names |

---

## Extended (Phase 2–4)

### Stat Card

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Dashboard metric |
| **Props** | `label`, `value`, `icon`, `url` (optional) |
| **Usage** | Dashboard |
| **Dependencies** | Card, Icons |
| **Future** | Sparkline |

### Upload Zone

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | File field + preview |
| **Props** | `name`, `label`, `accept`, `currentUrl` |
| **Usage** | Covers, resume PDF |
| **Dependencies** | Form validation |
| **Future** | Drag-and-drop |

### Tabs

| Field | Value |
|-------|-------|
| **Status** | Planned |
| **Purpose** | Group settings sections |
| **Props** | Tab ids + slots |
| **Usage** | Settings (if needed) |
| **Dependencies** | Bootstrap tabs |
| **Future** | URL hash sync |

### Toast

| Field | Value |
|-------|-------|
| **Status** | Deferred |
| **Purpose** | Non-blocking notifications |
| **Props** | Same family as Alert |
| **Usage** | Optional later |
| **Dependencies** | JS |
| **Future** | After flash alerts prove insufficient |

### Code Block

| Field | Value |
|-------|-------|
| **Status** | Deferred |
| **Purpose** | Styled `<pre><code>` wrapper |
| **Props** | `language`, slot |
| **Usage** | If Markdown default styling is not enough |
| **Dependencies** | Design tokens |
| **Future** | Syntax highlight |

### Split Pane

| Field | Value |
|-------|-------|
| **Status** | Deferred |
| **Purpose** | Markdown edit + preview |
| **Props** | `name`, `value` |
| **Usage** | Admin editors |
| **Dependencies** | Textarea, Markdown render endpoint or client |
| **Future** | Phase 4+ polish |

### Theme Toggle

| Field | Value |
|-------|-------|
| **Status** | Deferred |
| **Purpose** | Light/dark switch |
| **Props** | — |
| **Usage** | After dark mode ADR |
| **Dependencies** | Design tokens, ADR-010 supersession |
| **Future** | [10-ideas](10-ideas.md) |

### Quota Meter

| Field | Value |
|-------|-------|
| **Status** | Deferred |
| **Purpose** | Storage usage meter |
| **Props** | `used`, `max` |
| **Usage** | Unlikely for personal CMS |
| **Dependencies** | — |
| **Future** | Only if hosting limits demand |
