# 26 — Naming Conventions

**Purpose:** Consistent names across PHP, Blade, routes, and database artifacts.

**Related:** [04-coding-style](04-coding-style.md) · [11-folder-structure](11-folder-structure.md) · [03-database](03-database.md) · [22-ui-components](22-ui-components.md)

---

## Controllers

| Kind | Pattern | Example |
|------|---------|---------|
| Public | `{Resource}Controller` | `ProjectController` |
| Admin | `Admin\{Resource}Controller` | `Admin\ProjectController` |
| Auth | `Auth\{Action}Controller` | `Auth\LoginController` |

Resource methods: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.

---

## Models

- Singular PascalCase: `BlogPost`, `SocialLink`, `ContactMessage`
- Table: plural snake_case (`blog_posts`)
- Relationships: method names camelCase (`category()`, `posts()`)

---

## Blade views

| Area | Path | Example |
|------|------|---------|
| Public pages | `resources/views/public/` | `public/projects/show.blade.php` |
| Admin | `resources/views/admin/{resource}/` | `admin/projects/index.blade.php` |
| Auth | `resources/views/auth/` | `auth/login.blade.php` |
| Layouts | `resources/views/layouts/` | `layouts/admin.blade.php` |
| Errors | `resources/views/errors/` | `errors/404.blade.php` |
| Dev only | `resources/views/dev/` | `dev/ui-preview.blade.php` |

File names: kebab or resource-style lowercase matching Laravel norms (`index`, `create`, `edit`, `show`).

---

## Blade components

- Directory under `resources/views/components/`
- Tags: `<x-alert>`, `<x-form.input>`, `<x-layout.page-header>`
- Do **not** duplicate an existing component — extend or compose ([22-ui-components](22-ui-components.md))

---

## Routes

| Area | Name pattern | Example |
|------|--------------|---------|
| Public | `{resource}.{action}` | `projects.show` |
| Admin | `admin.{resource}.{action}` | `admin.projects.index` |
| Auth | `auth.{action}` | `auth.login` |

URI: kebab-case plural resources (`/projects`, `/admin/blog-posts` or `/admin/posts` — pick one and stay consistent; prefer `blog-posts` if using `BlogPost`).

---

## Migrations

```text
YYYY_MM_DD_HHMMSS_create_{table}_table
YYYY_MM_DD_HHMMSS_add_{column}_to_{table}_table
```

One purposeful change per migration when practical.

---

## Seeders

```text
{Purpose}Seeder
```

Examples: `AdminUserSeeder`, `SettingsSeeder`.

---

## Form Requests

```text
Admin\StoreProjectRequest
Admin\UpdateProjectRequest
StoreContactMessageRequest
```

Verb + resource + `Request`.

---

## Policies (when added)

```text
{Model}Policy
```

Example: `ProjectPolicy`. Register in `AppServiceProvider` or `AuthServiceProvider` per Laravel 12 norms.

---

## Events / Listeners (future)

```text
Events\{Noun}{PastVerb}   → ProjectPublished
Listeners\{Verb}{Noun}    → SendProjectNotification
```

Do not add events until an ADR or clear duplication need exists.

---

## Config & Support

| Item | Name |
|------|------|
| Config file | `config/project.php` → `config('project.*')` |
| Helpers | `project()`, `project_asset()`, `project_url()` |
| Support classes | `App\Support\Asset`, `Url`, `Settings`, `PublicUpload` |

---

## Database columns

Booleans: `is_*`. Dates: `*_at`. Foreign keys: `{model}_id`. Order: `sort_order`.
