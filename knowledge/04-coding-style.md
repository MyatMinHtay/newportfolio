# 04 — Coding Style

**Purpose:** Project-wide coding standards for PHP, Blade, routes, validation, and JavaScript.

**Related:** [00-CONSTITUTION](00-CONSTITUTION.md) · [02-architecture](02-architecture.md) · [11-folder-structure](11-folder-structure.md) · [12-components](12-components.md) · [16-ai-rules](16-ai-rules.md)

---

## Table of contents

1. [General](#1-general)
2. [Controllers](#2-controllers)
3. [Models](#3-models)
4. [Form Requests](#4-form-requests)
5. [Routes](#5-routes)
6. [Validation](#6-validation)
7. [Blade](#7-blade)
8. [Naming](#8-naming)
9. [Comments](#9-comments)
10. [PHP style](#10-php-style)
11. [Bootstrap usage](#11-bootstrap-usage)
12. [JavaScript](#12-javascript)
13. [Duplication](#13-duplication)

---

## 1. General

- Prefer **Laravel native solutions before packages**.
- No Repository / Service layers unless an ADR approves them.
- Prefer explicit code over clever metaprogramming.
- Avoid duplicated logic — extract scopes/components, not frameworks.
- Keep methods small and readable (one responsibility).
- Avoid helper function pollution (prefer model methods / focused classes). Approved thin wrappers only: `project()`, `project_asset()`, `project_url()` in `app/Support/helpers.php` (ADR-017).
- Run Laravel Pint when practical.

---

## 2. Controllers

**Thin controllers.** Controllers may:

- Authorize via middleware (preferred)
- Validate via Form Requests
- Call Eloquent / storage
- Return views, redirects, or downloads

Controllers must **not**:

- Own duplicated query filters (use **model scopes**)
- Render HTML strings
- Embed validation rule arrays when a Form Request exists
- Hide multi-step domain frameworks without an ADR-approved service

Namespaces:

- Public → `App\Http\Controllers\`
- Admin → `App\Http\Controllers\Admin\`
- Auth → `App\Http\Controllers\Auth\`

Resource methods: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` — skip unused ones.

---

## 3. Models

- Explicit `$fillable`; never mass-assign `is_admin` from requests
- `$casts` for bool/date/datetime/array
- Clear relationship methods
- Scopes: `published()`, `featured()`, `ordered()`
- Public binding via `slug` where applicable
- SoftDeletes only per [03-database](03-database.md)
- `Setting::get` / `set` with cache bust

---

## 4. Form Requests

- All admin writes under `App\Http\Requests\Admin\`
- Public contact uses a Form Request
- **No duplicated validation** in controllers
- Keep rules readable; custom rules only if reused

---

## 5. Routes

- `web.php` — public + auth
- `admin.php` — `/admin`, `auth` + `EnsureUserIsAdmin`, names `admin.*`
- Prefer `Route::resource` for admin CRUD
- Always name routes
- Throttle login + contact

---

## 6. Validation

- Every external input via Form Requests
- Uploads: mime + max size; generated filenames
- Slugs: unique, alpha-dash
- Never trust client paths

---

## 7. Blade

- Trivial conditionals/loops only
- **No database queries in Blade**
- Escape by default `{{ }}`
- Markdown HTML only via approved renderer
- Components for repeated UI
- Data from controllers or View Composers only

---

## 8. Naming

| Kind | Style |
|------|-------|
| Classes | PascalCase |
| Methods / vars | camelCase |
| DB / routes | snake_case |
| Blade components | kebab-case |

---

## 9. Comments

Explain **why**, not what. Prefer clear names. ADRs live in docs.

---

## 10. PHP style

PHP 8.3+ OK. Typed props/returns. Early returns. Short methods. Import classes cleanly.

---

## 11. Bootstrap usage

Bootstrap utilities/components first. Custom CSS only for tokens. Bootstrap Icons only. No Tailwind.

---

## 12. JavaScript

Minimal: Bootstrap bundle + small helpers in `public/assets/js/app.js`. Load via `asset()`. No jQuery/Livewire/Vue/React/Vite by default.

---

## 13. Duplication

| Smell | Fix |
|-------|-----|
| Repeated Blade | Component |
| Repeated queries | Model scope |
| Repeated validation | Form Request |
| Eloquent “DRY” urge | Do **not** add Repository |
| Random helpers | Prefer model/static methods |
