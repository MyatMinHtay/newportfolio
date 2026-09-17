# 22 — UI Components Reference

**Purpose:** Document every reusable Blade component. Implementation lives under `resources/views/components/`.  
**Note:** File number is **22** because `17-testing.md` already exists. Tracking catalog remains [12-components](12-components.md).

**Related:** [12-components](12-components.md) · [13-design-system](13-design-system.md) · [05-ui-guidelines](05-ui-guidelines.md) · ADR-016

---

## Conventions

| Item | Rule |
|------|------|
| Path | `resources/views/components/{group}/` |
| Tags | `<x-alert>`, `<x-form.input>`, `<x-layout.page-header>` |
| Framework | Bootstrap 5 + Bootstrap Icons only |
| Global feedback | Toastify (`public/assets/libs/toast/`) — not Alert |
| Inline feedback | `<x-alert>` only |

Preview all components at `/ui-preview` (dev-only).

---

## Alert — `<x-alert>`

**Purpose:** Inline page message (not global toast).

**Parameters:**

| Prop | Type | Default | Notes |
|------|------|---------|-------|
| `type` | string | `info` | `success`, `danger`/`error`, `warning`, `info` |
| `message` | string\|null | null | Or use slot |
| `dismissible` | bool | false | Adds close button |

**Example:**

```blade
<x-alert type="warning" message="Draft mode is on." :dismissible="true" />
```

**Best practices:** Use for contextual notices on a page. Never for login/save/delete success — those use Toastify later.

**Future:** Optional icon prop.

---

## Badge — `<x-badge>`

**Purpose:** Status chips.

**Parameters:** `variant` (Bootstrap `text-bg-*` suffix), `label` or slot.

**Example:** `<x-badge variant="success" label="Published" />`

**Best practices:** Always include text; do not rely on color alone.

**Future:** Dot indicators.

---

## Button — `<x-button>`

**Purpose:** Consistent CTAs.

**Parameters:** `variant`, `type` (`button`\|`submit`), `href` (renders `<a>`), `size` (`sm`\|`lg`).

**Example:**

```blade
<x-button variant="primary" type="submit">Save</x-button>
<x-button variant="outline-secondary" href="{{ route('admin.home') }}">Cancel</x-button>
```

**Best practices:** One primary button per view. Use `btn-sm` in tables.

**Future:** Loading / disabled busy state.

---

## Card — `<x-card>`

**Purpose:** Surface container.

**Parameters:** `title` (optional). Slots: default body, `header`, `footer`.

**Example:**

```blade
<x-card title="Projects">
    Content
    <x-slot:footer>...</x-slot:footer>
</x-card>
```

**Future:** Hover elevation token.

---

## Breadcrumb — `<x-breadcrumb>`

**Purpose:** Path context.

**Parameters:** `items` — array of `{ label, url? }` or plain strings.

**Example:**

```blade
<x-breadcrumb :items="[
    ['label' => 'Admin', 'url' => url('/admin')],
    ['label' => 'Projects'],
]" />
```

**Future:** Auto from route names.

---

## Empty state — `<x-empty-state>`

**Purpose:** Zero-data placeholder.

**Parameters:** `title`, `description`, `icon` (Bootstrap Icon class), `actionLabel`, `actionUrl`.

**Example:**

```blade
<x-empty-state
    title="No posts"
    description="Create your first article."
    icon="bi-journal-text"
    action-label="Create post"
    action-url="#"
/>
```

---

## Modal — `<x-modal>`

**Purpose:** Dialog shell (confirm deletes, etc.).

**Parameters:** `id` (required), `title`, `size` (`sm`\|`lg`\|`xl`). Slots: body, `footer`.

**Example:** Trigger with `data-bs-toggle="modal" data-bs-target="#id"`.

**Future:** Focus-trap audit.

---

## Table — `<x-table>`

**Purpose:** Responsive table wrapper.

**Parameters:** `hover` (bool, default true), `striped` (bool).

**Example:** Pass `<thead>` / `<tbody>` in the slot.

---

## Pagination — `<x-pagination>`

**Purpose:** Center Laravel Bootstrap 5 paginator links.

**Parameters:** `paginator` (LengthAwarePaginator) **or** slot with static markup.

**Example:** `<x-pagination :paginator="$projects" />`

---

## Form — `<x-form.*>`

### Input — `<x-form.input>`

Props: `name`, `label`, `type`, `value`, `required`, `help`.

### Textarea — `<x-form.textarea>`

Props: `name`, `label`, `value`, `rows`, `required`, `help`.

### Checkbox — `<x-form.checkbox>`

Props: `name`, `label`, `checked`, `value`.

### Select — `<x-form.select>`

Props: `name`, `label`, `options` (value => label), `selected`, `required`, `help`, `placeholder`.

**Best practices:** Labels above fields; never duplicate validation in the view — Form Requests later. Errors from `$errors` bag.

**Future:** Upload zone component (Phase 2+).

---

## Layout components — `<x-layout.*>`

| Component | Purpose |
|-----------|---------|
| `assets-head` | Bootstrap, Icons, Toastify CSS, `app.css` |
| `assets-scripts` | Bootstrap JS, Toastify JS, `app.js` |
| `flash` | Inline alerts + validation summary |
| `page-header` | Title, subtitle, actions slot |
| `admin-sidebar` | Desktop admin sidebar shell |
| `admin-topbar` | Top bar + mobile menu button |
| `admin-footer` | Admin footer placeholder |
| `public-footer` | Public footer placeholder |

---

## Navigation — `<x-navigation.*>`

| Component | Purpose |
|-----------|---------|
| `public-nav` | Public navbar (placeholder links) |
| `admin-nav` | Admin nav groups (placeholder labels) |

Wire real `route()` / `routeIs()` active states when routes exist.

---

## Toast (structure only)

**Library:** `public/assets/libs/toast/toastify.min.js` (+ CSS).  
**Status:** Loaded in every layout; **no helper API yet**.  
**Do not** install another notification package.  
Documented in ADR-016.

---

## Extension rules

1. New shared UI → add Blade component + update this file + [12-components](12-components.md).
2. Prefer composing existing components over one-off HTML in pages.
3. No Livewire / Alpine / Vue / React for components.
