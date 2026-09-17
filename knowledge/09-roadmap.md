# 09 — Roadmap

**Purpose:** Ordered delivery plan with explicit phase statuses.  
**Related:** [01-project-overview](01-project-overview.md) · [02-architecture](02-architecture.md) · [08-changelog](08-changelog.md) · [10-ideas](10-ideas.md) · [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)

---

## Status values

| Status | Meaning |
|--------|---------|
| **Completed** | Done and accepted |
| **Planned** | Scheduled, not started |
| **In Progress** | Actively being built |
| **Blocked** | Waiting on dependency/decision |
| **Deferred** | Intentionally postponed |

---

## Phase −1 — Documentation foundation

**Status:** Completed (2026-07-24)

- Full `knowledge/` set (00–21)
- Architecture locked
- ADRs recorded
- Documentation **Version 1.0.0 LOCKED**

**Exit criteria:** Met.

---

## Phase 0 — Foundation

**Status:** Completed (2026-07-25)

**Scope (assets / layouts / routes only — no DB, no auth logic):**

- Remove Tailwind / Vite usage; Bootstrap 5 + Icons under `public/assets/libs/` (ADR-014 / ADR-015)
- Token CSS + Bootstrap init JS
- Layouts: `public` / `admin` / `auth` skeletons
- `routes/web.php` + `routes/admin.php` placeholder groups
- Bootstrap 5 paginator

**Deferred from original Phase 0 plan (do in Phase 0b / Phase 1 prep):**

- Migrations + models + seeders
- Core Blade components
- Manual login + Socialite + `EnsureUserIsAdmin`

**Exit criteria:** Public/admin/auth shells render via `php artisan serve` with no npm build.

---

## Phase 0b — UI Foundation

**Status:** Completed (2026-07-25)

- Design tokens in `public/assets/css/app.css`
- Reusable Blade components under `resources/views/components/`
- Full admin / public / auth layouts (static placeholders)
- Toastify loaded in layouts (notification logic deferred — ADR-016)
- Dev-only `/ui-preview` catalog
- Docs: design system + UI component reference (`22-ui-components.md`)
- Asset libs path: `public/assets/libs/` (ADR-015)

**Exit criteria:** `/ui-preview` shows all components; no DB/auth required.

---

## Phase 0c — Foundation Lock

**Status:** Completed (2026-07-25)

- `config/project.php` + `app/Support` utilities (ADR-017)
- Bootstrap error pages 401–503
- Knowledge: logging, file storage, validation, naming, toast (23–27)
- Expanded git + AI rules
- `FOUNDATION-LOCK-REPORT.md`

**Exit criteria:** Conventions frozen; no Auth/DB/CRUD yet. Await approval before Phase 1.

---

## Phase 1 — Settings + public shell

**Status:** Planned *(starts after Auth/DB foundation approval — may be split)*

- Cached settings CRUD
- Home / About / Contact
- Social links in footer

**Exit criteria:** Public shell live; settings editable.

**Note:** Authentication + database schema land immediately before or as the first slice of Phase 1, per human approval — not inside Foundation Lock.

---

## Phase 2 — Portfolio CRUD

**Status:** In Progress (2026-09-17)

- Experience, Skills, Projects
- Resume upload / activate / download
- **Shipped this slice:** Admin CRUD for Projects (case studies), Skills (icon upload), Services; public Services section

**Exit criteria:** Core portfolio manageable end-to-end.

---

## Phase 3 — Blog + messages

**Status:** Planned

- Categories + Markdown posts
- Contact inbox

**Exit criteria:** Blog + messages operational.

---

## Phase 4 — Polish

**Status:** Planned

- Dashboard counts
- Featured / publish UX
- Upload hardening
- Basic SEO ([18-seo](18-seo.md))
- Empty states everywhere

**Exit criteria:** Production-candidate UX.

---

## Phase 5 — Docs sync + deploy

**Status:** Planned

- Sync knowledge with shipped code (component statuses, changelog)
- Production notes in [07-deployment](07-deployment.md)
- Release via [19-release-process](19-release-process.md)

**Exit criteria:** Launch checklist complete.

---

## Future

**Status:** Deferred — see [10-ideas](10-ideas.md)

Case studies, gallery, API, dark mode, search, analytics, etc.
