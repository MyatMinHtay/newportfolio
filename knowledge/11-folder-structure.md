# 11 — Folder Structure

**Purpose:** Where code and docs live; naming; extension rules.

**Related:** [02-architecture](02-architecture.md) · [04-coding-style](04-coding-style.md) · [12-components](12-components.md)

---

## Table of contents

1. [Visual tree](#1-visual-tree)
2. [Major folders](#2-major-folders)
3. [Naming conventions](#3-naming-conventions)
4. [Future extension rules](#4-future-extension-rules)
5. [Forbidden folders](#5-forbidden-folders)

---

## 1. Visual tree

```text
portfolio/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Auth/
│   │   │   └── (public controllers)
│   │   ├── Middleware/
│   │   └── Requests/
│   │       └── Admin/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── knowledge/                 ← documentation source of truth
├── public/                    ← web root
│   └── storage → ../storage/app/public
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       ├── components/
│       ├── public/
│       ├── admin/
│       └── auth/
├── routes/
│   ├── web.php
│   └── admin.php
├── storage/
│   └── app/public/
│       ├── projects/covers/
│       ├── blog/covers/
│       ├── resumes/
│       └── profile/
├── tests/
└── (composer.json, package.json, vite.config.js, …)
```

---

## 2. Major folders

### `app/`

Application PHP code. Controllers, models, middleware, form requests, providers.

| Subfolder | Role |
|-----------|------|
| `Http/Controllers` | Public HTTP entrypoints |
| `Http/Controllers/Admin` | CMS |
| `Http/Controllers/Auth` | Login + Google |
| `Http/Requests/Admin` | Validation |
| `Http/Middleware` | e.g. `EnsureUserIsAdmin` |
| `Models` | Eloquent (`Setting` included) |
| `Providers` | Paginator, view composers |

### `resources/`

| Subfolder | Role |
|-----------|------|
| `views/layouts` | `public`, `admin`, `auth` |
| `views/components` | Reusable Blade ([12-components](12-components.md)) |
| `views/public` | Public pages |
| `views/admin` | CMS pages by resource |
| `views/auth` | Login |
| `css` / `js` | Vite entries (Bootstrap) |

### `routes/`

| File | Role |
|------|------|
| `web.php` | Public + auth |
| `admin.php` | `/admin` CMS |

### `database/`

Migrations, seeders (`AdminUserSeeder`, `SettingsSeeder`), optional factories.

### `storage/`

Logs, cache, uploaded files under `app/public/...` (linked to `public/storage`).

### `public/`

**Only** web-accessible entry (`index.php`), built assets, storage symlink. Never secrets.

### `knowledge/`

Locked project documentation (this folder). Not autoloaded by Laravel.

### `tests/`

PHPUnit/Pest feature & unit tests ([17-testing](17-testing.md)).

### `config/`

Laravel config; OAuth + admin allowlist keys live here from `.env`.

---

## 3. Naming conventions

| Kind | Convention | Example |
|------|------------|---------|
| PHP classes | PascalCase | `BlogPostController` |
| DB tables | snake plural | `blog_posts` |
| Route names | dot notation | `admin.projects.index` |
| Blade components | kebab | `<x-empty-state>` |
| Admin view dirs | plural resource | `views/admin/projects/` |
| Upload dirs | lowercase path | `projects/covers` |
| Knowledge files | `NN-name.md` | `03-database.md` |

---

## 4. Future extension rules

1. **New feature domain** → new controller + views under existing public/admin split; avoid new top-level app namespaces without ADR.
2. **New persistence concept** → new model + migration; update [03-database](03-database.md).
3. **New shared UI** → component under `views/components` + [12-components](12-components.md) status update.
4. **API later** → add `routes/api.php` (do not stuff into `admin.php`).
5. **Do not** invent `app/Domains`, `app/Repositories`, or parallel frontend apps without ADR.

---

## 5. Forbidden folders (default)

- `app/Repositories/`
- `app/Services/` (unless ADR Accepted)
- `app/Domains/` / Hexagonal ports
- Filament resource trees
- Tailwind-specific design directories

Document any new top-level folder here **before** creating it.
