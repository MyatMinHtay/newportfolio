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

**Status:** Completed (2026-09-18)

- Cached settings CRUD (`/admin/settings`)
- Home / About / Contact with dynamic settings
- Social links CRUD (`/admin/social-links`) in footer and contact

**Exit criteria:** Public shell live; settings editable. Met.

---

## Phase 2 — Portfolio CRUD

**Status:** Completed (2026-09-18)

- Experience CRUD (`/admin/experiences`)
- Skills CRUD with icon uploads (`/admin/skills`)
- Projects & Case Studies CRUD (`/admin/projects`)
- Services CRUD (`/admin/services`)
- Resume PDF upload / activate / public download (`/admin/resumes`)

**Exit criteria:** Core portfolio manageable end-to-end. Met.

---

## Phase 3 — Blog + messages

**Status:** Completed (2026-09-18)

- Categories CRUD (`/admin/categories`)
- Markdown blog posts CRUD (`/admin/posts`)
- Public Blog index and article reading views (`/blog`, `/blog/{slug}`)
- Contact inbox (`/admin/messages`) with read/unread toggle and delete
- Public Case Study detail view (`/projects/{slug}`) with full Markdown rendering

**Exit criteria:** Blog + messages operational. Met.

---

## Phase 4 — Polish

**Status:** Completed (2026-09-20)

- Dashboard counts — Completed (Breakdown metrics, active resume banner, recent case studies, blog posts, and inquiries activity feeds)
- Featured / publish UX — Completed (Status filter pills, one-click toggle actions for publish and featured, live view links)
- Upload hardening — Completed (Strict allowed mimes, directory sanitization, old cover image deletion on update)
- Basic SEO ([18-seo](18-seo.md)) — Completed (Admin keywords/meta, Open Graph, dynamic robots.txt, extensible sitemap.xml)
- Empty states everywhere — Completed (Public homepage forelse fallbacks, category-aware blog empty state, admin table filters)

**Exit criteria:** Production-candidate UX. Met.

---

## Phase 5 — Docs sync + deploy

**Status:** In Progress

- Sync knowledge with shipped code (component statuses, changelog)
- Production notes in [07-deployment](07-deployment.md)
- Release via [19-release-process](19-release-process.md)

**Exit criteria:** Launch checklist complete.

---

## Future

**Status:** Deferred — see [10-ideas](10-ideas.md)

Case studies, gallery, API, dark mode, search, analytics, etc.
