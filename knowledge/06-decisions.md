# 06 — Architecture Decision Records (ADR)

**Purpose:** Numbered decisions that bind implementation. Locked documentation references these ADRs.

**Related:** [00-CONSTITUTION](00-CONSTITUTION.md) · [02-architecture](02-architecture.md) · [16-ai-rules](16-ai-rules.md) · [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)

---

## ADR format (mandatory)

Every ADR must include:

| Field | Meaning |
|-------|---------|
| **Decision** | What we chose |
| **Reason** | Why |
| **Alternative** | What we rejected |
| **Trade-offs** | Costs of the choice |
| **Future Impact** | What this locks in later |
| **Status** | `Proposed` · `Accepted` · `Superseded` · `Deprecated` |

Only **Accepted** ADRs bind implementation. Superseding requires a new ADR that references the old one.

---

## Table of contents

1. [ADR-001](#adr-001-bootstrap-over-tailwind)
2. [ADR-002](#adr-002-manual-auth-instead-of-breeze-blade)
3. [ADR-003](#adr-003-admin-gate-with-is_admin--google-allowlist)
4. [ADR-004](#adr-004-settings-key-value-with-cache)
5. [ADR-005](#adr-005-markdown-for-long-form-content)
6. [ADR-006](#adr-006-no-repository-pattern)
7. [ADR-007](#adr-007-no-service-layer-by-default)
8. [ADR-008](#adr-008-json-tech_stack-on-projects)
9. [ADR-009](#adr-009-soft-deletes-only-on-major-content)
10. [ADR-010](#adr-010-light-theme-only-for-v1)
11. [ADR-011](#adr-011-split-web-and-admin-route-files)
12. [ADR-012](#adr-012-no-filament--nova)
13. [ADR-013](#adr-013-skill-category-as-string)
14. [ADR-014](#adr-014-public-assets-instead-of-vite)
15. [ADR-015](#adr-015-public-assets-libs-directory)
16. [ADR-016](#adr-016-toastify-global-notifications)
17. [ADR-017](#adr-017-foundation-infrastructure-conventions)
18. [ADR-018](#adr-018-services-as-a-first-class-content-table)

---

## ADR-001 Bootstrap over Tailwind

**Decision:** Use Bootstrap 5 + Bootstrap Icons as the only UI framework.

**Reason:** Single familiar component system for public and admin. Skeleton Tailwind would force dual systems.

**Alternative:** Keep Tailwind; use Filament for admin.

**Trade-offs:** Less utility-first customization; theme carefully via tokens.

**Future Impact:** All UI assumes Bootstrap. Tailwind later requires a superseding ADR.

**Status:** Accepted

---

## ADR-002 Manual auth instead of Breeze Blade

**Decision:** Manual login UI + Socialite Google. Do not install Breeze Blade.

**Reason:** Breeze Blade is Tailwind-oriented; restyling wastes time.

**Alternative:** Breeze then strip Tailwind; laravel/ui.

**Trade-offs:** Slightly more auth boilerplate once.

**Future Impact:** Password reset can be added without Breeze.

**Status:** Accepted

---

## ADR-003 Admin gate with is_admin + Google allowlist

**Decision:** `/admin` requires `auth` + `EnsureUserIsAdmin`. Google email must match allowlist. No registration.

**Reason:** Authentication ≠ authorization.

**Alternative:** Spatie Permission; env-only gate.

**Trade-offs:** Extra `is_admin` column; never mass-assign it.

**Future Impact:** Second admin via flag + allowlist expansion possible.

**Status:** Accepted

---

## ADR-004 Settings key-value with cache

**Decision:** `settings` key-value table; cache map; bust on update.

**Reason:** Avoid migrations for copy/SEO strings; settings hit every page.

**Alternative:** Wide single-row profile table; config files.

**Trade-offs:** Weaker column typing; validate known keys in admin.

**Future Impact:** Optional `type` column later.

**Status:** Accepted

---

## ADR-005 Markdown for long-form content

**Decision:** Store long-form as Markdown; render via Laravel Markdown helpers.

**Reason:** Safer than raw HTML; enough for a personal site.

**Alternative:** Rich HTML editor.

**Trade-offs:** Less layout control.

**Future Impact:** Controlled HTML subset only via new ADR.

**Status:** Accepted

---

## ADR-006 No Repository Pattern

**Decision:** Do not create repositories.

**Reason:** Eloquent is sufficient persistence API.

**Alternative:** Repository per model.

**Trade-offs:** Controllers use Eloquent directly.

**Future Impact:** Revisit if a second data source appears.

**Status:** Accepted

---

## ADR-007 No Service Layer by default

**Decision:** No `app/Services` unless duplication is real and a new ADR approves a specific service.

**Reason:** Premature services become dumpsters.

**Alternative:** Services for every write.

**Trade-offs:** Controllers may briefly hold multi-step writes (e.g. resume activation).

**Future Impact:** Image processing / complex transactions may get approved services later.

**Status:** Accepted

---

## ADR-008 JSON tech_stack on projects

**Decision:** `projects.tech_stack` as JSON string array.

**Reason:** No tag pages in v1.

**Alternative:** tags + pivot.

**Trade-offs:** Harder “all Laravel projects” queries.

**Future Impact:** Migrate to tags if needed.

**Status:** Accepted

---

## ADR-009 Soft deletes only on major content

**Decision:** Soft delete `projects`, `blog_posts`, `experiences` only.

**Reason:** Undo where content is costly; skip tiny lists.

**Alternative:** Soft delete everything.

**Trade-offs:** Inconsistent restore UX (documented).

**Future Impact:** Can enable more SoftDeletes later.

**Status:** Accepted

---

## ADR-010 Light theme only for v1

**Decision:** Ship light theme; reserve CSS variables; no theme toggle.

**Reason:** Dual themes double QA.

**Alternative:** Full dark mode in v1.

**Trade-offs:** No dark preference yet.

**Future Impact:** [10-ideas](10-ideas.md); requires superseding ADR for toggle.

**Status:** Accepted

---

## ADR-011 Split web and admin route files

**Decision:** `routes/web.php` + `routes/admin.php`.

**Reason:** Clear separation as routes grow.

**Alternative:** Single file with groups.

**Trade-offs:** Slightly more bootstrap wiring.

**Future Impact:** Easy to add `api.php` later.

**Status:** Accepted

---

## ADR-012 No Filament / Nova

**Decision:** Custom Bootstrap admin.

**Reason:** One design system; avoid admin package lock-in.

**Alternative:** Filament for speed.

**Trade-offs:** More Blade CRUD work.

**Future Impact:** Fully owned admin UI.

**Status:** Accepted

---

## ADR-013 Skill category as string

**Decision:** `skills.category` plain string, not FK.

**Reason:** Tiny taxonomy; table premature.

**Alternative:** `skill_categories` table.

**Trade-offs:** Label consistency — mitigate with select options.

**Future Impact:** Normalize later if needed.

**Status:** Accepted

---

## ADR-014 Public assets instead of Vite

**Decision:** Serve CSS/JS from `public/assets/` via Laravel’s `asset()` helper. Ship Bootstrap 5 and Bootstrap Icons as static files under `public/assets/vendor/`. Do **not** use Vite, `@vite()`, `npm run dev`, or `npm run build` for this project.

**Reason:** Phase 0 must work immediately after `php artisan serve` with no Node build step. Traditional public assets match XAMPP/solo-dev simplicity and remove Tailwind/Vite coupling from the Laravel skeleton.

**Alternative:** Keep Vite + npm to bundle Bootstrap (previous architecture §12).

**Trade-offs:** Manual vendor upgrades (copy new dist files); no HMR; slightly less “modern” frontend tooling. Mitigate by pinning Bootstrap/Icons versions in `IMPLEMENTATION-NOTES.md` / changelog when upgrading.

**Future Impact:** All Blade layouts load `asset('assets/...')`. `resources/css` and `resources/js` are unused for production UI. Reintroducing Vite requires a superseding ADR.

**Status:** Accepted *(path `vendor/` superseded by ADR-015)*

**Supersedes:** Architecture §12 “Vite + npm Required” (docs v1.0.0).

---

## ADR-015 Public assets `libs/` directory

**Decision:** Third-party front-end libraries live under `public/assets/libs/` (not `vendor/`). Application CSS/JS remain in `public/assets/css/` and `public/assets/js/`.

**Reason:** `vendor/` is easily confused with Composer’s `vendor/`. `libs/` is the project standard for Bootstrap, Bootstrap Icons, Toastify, and future optional libraries (folders reserved: jquery, gsap, slick, splide).

**Alternative:** Keep `public/assets/vendor/`.

**Trade-offs:** One-time path migration in layouts and docs.

**Future Impact:** All Blade `asset()` references use `assets/libs/...`. Composer `vendor/` is unrelated.

**Status:** Accepted

**Supersedes:** ADR-014 path wording (`public/assets/vendor/` → `public/assets/libs/`).

---

## ADR-016 Toastify global notifications

**Decision:** Global success/error/info notifications use the Toastify library at `public/assets/libs/toast/` (`toastify.min.css` / `toastify.min.js`). Do not add another toast/notification package. Bootstrap Alerts are **inline page messages only** (e.g. form context, permanent page notices)—not global flash toasts.

**Reason:** One consistent non-blocking notification UX for login/save/delete/validation/permission/upload feedback.

**Alternative:** Bootstrap toast component; session flash via Alert only; toastr/sweetalert packages.

**Trade-offs:** Small custom wrapper JS will be needed in a later phase; Toastify API must be wrapped once for consistency.

**Future Impact:** Layouts load Toastify assets. Notification helper/logic lands in a later phase—structure only in Phase 0b. Component catalog treats Toast as Planned (wired later).

**Status:** Accepted

---

## ADR-017 Foundation infrastructure conventions

**Decision:** Before business logic, the project freezes conventions via:

- Central `config/project.php` for site/meta UI defaults (pagination size, toast duration, upload limits, version)
- Thin `app/Support/` utilities (`helpers.php`, `Asset`, `Url`, `Settings` placeholder) — **not** a Service Layer
- Bootstrap error pages under `resources/views/errors/`
- Knowledge docs for logging, file storage, validation, naming, toast guidelines (23–27)

**Reason:** Prevents ad-hoc conventions during Auth/DB/CRUD phases. Keeps infrastructure discoverable for humans and AI.

**Alternative:** Discover conventions only while coding features; put helpers in random places.

**Trade-offs:** More docs to maintain; `Settings` class is a stub until ADR-004 is implemented.

**Future Impact:** Controllers/Form Requests must follow 23–27. Do not invent parallel helper namespaces. Expanding `app/Support` into domain services requires a new ADR (still forbidden by ADR-007).

**Status:** Accepted

---

## ADR-018 Services as a first-class content table

**Decision:** Public “Services” offerings are stored in a `services` table (title, summary, Bootstrap Icon class, sort_order, is_published) and managed via admin CRUD. Do not encode services as settings keys or hardcoded Blade-only copy.

**Reason:** The homepage needs an owner-editable services section. Skills/experiences already use Eloquent rows; settings key-value is a poor fit for a list with icons and order.

**Alternative:** Hardcoded homepage cards; JSON in `settings`.

**Trade-offs:** One extra table and admin resource. No RBAC package.

**Future Impact:** Case-study pages stay on `projects`. Do not merge services into projects.

**Status:** Accepted

---

## Adding new ADRs

1. Use next number `ADR-019`, …
2. Set **Status: Proposed** until human accepts → **Accepted**
3. Update [02-architecture](02-architecture.md) if behavior changes
4. Changelog entry
5. Do not silently edit Accepted ADRs — supersede instead
