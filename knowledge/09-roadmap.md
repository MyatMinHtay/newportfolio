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

**Status:** Planned

- Remove Tailwind; Bootstrap 5 + Icons via npm/Vite
- Migrations + models + seeders
- Layouts public / admin / auth
- Core Blade components (mark In Progress → Completed in [12-components](12-components.md))
- Manual login + Socialite + `EnsureUserIsAdmin`
- `routes/web.php` + `routes/admin.php`
- Bootstrap 5 paginator

**Exit criteria:** Admin login works; empty shells render; DB migrated.

---

## Phase 1 — Settings + public shell

**Status:** Planned

- Cached settings CRUD
- Home / About / Contact
- Social links in footer

**Exit criteria:** Public shell live; settings editable.

---

## Phase 2 — Portfolio CRUD

**Status:** Planned

- Experience, Skills, Projects
- Resume upload / activate / download

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
