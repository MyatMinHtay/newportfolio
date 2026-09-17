# 08 — Changelog

**Purpose:** Human-readable history of meaningful changes.  
**Related:** [09-roadmap](09-roadmap.md) · [15-git-workflow](15-git-workflow.md) · [19-release-process](19-release-process.md) · [16-ai-rules](16-ai-rules.md)

---

## Semantic Versioning

This project follows **SemVer**: `MAJOR.MINOR.PATCH`

| Part | When to bump |
|------|----------------|
| **MAJOR** | Breaking changes for the owner’s workflow or public URLs/schema that require migration care (`1.0.0` = first production launch) |
| **MINOR** | Backward-compatible features (new admin resource, new public page) |
| **PATCH** | Bug fixes, small docs clarifications, dependency patches |

### Version bands (this project)

| Version | Meaning |
|---------|---------|
| `0.x.y` | Pre-production / building toward launch |
| `1.0.0` | First production release **or** documentation lock milestone (see below) |
| `1.x.y` | Post-launch compatible evolution |

**Note:** Documentation lock is recorded as **Docs 1.0.0** in [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md). Application release versions continue independently in this changelog once Phase 0 ships (e.g. app `0.2.0`).

---

## Rules

1. Newest entries at the **top**
2. Date format: `YYYY-MM-DD`
3. Group under: **Added** · **Changed** · **Fixed** · **Removed** · **Docs** · **Security**
4. AI must append an entry after implementation ([16-ai-rules](16-ai-rules.md))
5. Tag git releases to match when shipping ([15-git-workflow](15-git-workflow.md))

---

## Release note format

```markdown
## X.Y.Z — YYYY-MM-DD

### Added
- …

### Changed
- …

### Fixed
- …

### Removed
- …

### Docs
- …

### Security
- …
```

Keep bullets user/owner-relevant. Link PRs/commits optionally.

---

## Entries

## 0.7.0 — 2026-09-17

### Added
- Admin CRUD for **Projects / case studies**, **Skills** (icon upload from create), and **Services**.
- Public Services section on the homepage.
- Skills: Laravel Socialite, Linux Basic. Skill icons stored on the public disk (`skills/icons/`).

### Changed
- Vue.js and Angular removed from published skills.
- Nexus VPN Panel unpublished (hidden until later).

### Docs
- ADR-018: services as a first-class table.
- File storage: `skills/icons/`.

## 0.6.1 — 2026-09-17

### Changed
- Wired live URLs: MorningStar, Nexus VPN Panel (`allisfree.online`), Dream Comic, KM Explorer (`kmexplorer.com`). Travel & Tour renamed to KM Explorer.
- Added Dev Toolkit as a Preview card (`devtoolkit.freedev.app`) — experimental, not presented as finished.

## 0.6.0 — 2026-09-17

### Added
- Current work on the homepage: MorningStar Translation MM, Nexus VPN Panel, Dream Comic (freelance, AWS S3), Travel & Tour (freelance), and this Laravel Portfolio CMS. Markdown case-study stubs stored on each project for later detail pages.

### Changed
- Early HTML/JS demos remain in the database but are unpublished so the homepage shows production Laravel work first.
- Skills now include AWS S3, Docker, and Telegram Bots.

### Docs
- [10-ideas](10-ideas.md): P Finance and LMS parked as future products (not homepage cards).

## 0.5.1 — 2026-09-17

### Changed
- Public homepage: section anchors now clear the sticky navbar (no clipped headings), theme-aware scrollbars, and Light/Dark contrast for buttons, forms, nav, and contact channels.

### Docs
- Changelog only — visual polish within existing design tokens.

## 0.5.0 — 2026-09-16

### Added
- **Database Schema:** 10 migrations for `users` (updates), `projects`, `skills`, `experiences`, `social_links`, `settings`, `resumes`, `categories`, `blog_posts`, `contact_messages`.
- **Eloquent Models:** `Project`, `Skill`, `Experience`, `SocialLink`, `Setting`, `Resume`, `Category`, `BlogPost`, `ContactMessage` with appropriate casts, scopes, and relationships.
- **Database Seeders:** `AdminUserSeeder` (creates default admin `myatminhtay7@gmail.com`) and `OldPortfolioSeeder` (seeds 9 projects, 16 skills, bio, experiences, social links, and settings from `oldportfolio/`).
- **Authentication System:** Adapted Breeze controller pattern to Bootstrap 5 (`AuthenticatedSessionController`, `PasswordResetLinkController`, `NewPasswordController`, `LoginRequest` with rate limiting).
- **Admin Protection:** `EnsureUserIsAdmin` middleware registered and applied to `routes/admin.php`.
- **Views:** Bootstrap 5 styled `login.blade.php`, `forgot-password.blade.php`, `reset-password.blade.php`, and `admin/dashboard.blade.php`.
- **Automated Tests:** Comprehensive feature test suite for authentication and admin authorization (`tests/Feature/Auth/AuthenticationTest.php`) passing 100%.

### Changed
- Configured `.env` mail driver template for Gmail SMTP.
- Replaced admin placeholder route with `DashboardController` showcasing seeded stats.
- Configured complete **Light Theme & Dark Theme** color tokens and 6 gradient variables (`public/assets/css/app.css` & `public/assets/js/app.js`).
- Redesigned `ui-preview` to match the **Realtime Colors** landing page layout (Hero with interactive palette toolbar, geometric artwork mockup, 3 feature cards, Bento Grid stats, How It Works 4-step workflow, 3 Pricing cards, Testimonials, and FAQ accordions).
- Overwrote all Bootstrap component colors to use CSS tokens strictly for layout structure.

### Docs
- Added `knowledge/28-old-portfolio-analysis.md` (audit of `oldportfolio/` projects, skills, biography, and renewal map).
- Updated `knowledge/10-ideas.md` with Developer Scripts & Tools Hub.
- Updated `knowledge/21-DOCUMENTATION-STATUS.md` index.

## 0.4.0 — 2026-07-25

### Added

- Foundation Lock: `config/project.php`, `app/Support/*`, Bootstrap error pages
- ADR-017 foundation infrastructure conventions
- Knowledge docs 23–27 (logging, file storage, validation, naming, toast)
- Expanded git workflow + AI mandatory rules
- `FOUNDATION-LOCK-REPORT.md`

### Docs

- Architecture §15 foundation infrastructure
- Documentation status review 2026-07-25 (Foundation Lock)

## 0.3.0 — 2026-07-25

### Changed

- **ADR-015:** Third-party assets live under `public/assets/libs/` (not `vendor/`)
- **ADR-016:** Toastify is the global notification standard; Bootstrap Alert is inline-only

### Added

- Phase 0b UI foundation: design tokens, Blade components, full layout shells, `/ui-preview`
- [22-ui-components](22-ui-components.md) component reference
- Expanded [13-design-system](13-design-system.md)

## 0.2.0 — 2026-07-25

### Changed

- **ADR-014:** Asset pipeline is `public/assets/` + `asset()` — Vite / Tailwind / npm build removed from architecture
- Phase 0 narrowed to foundation shells (layouts, assets, route groups); DB/auth deferred

### Docs

- Updated architecture §12, constitution, overview, folder structure, deployment, coding style, design system paths, roadmap Phase 0

## 1.0.0 — 2026-07-24

### Docs

- Final documentation review complete
- Documentation set **LOCKED** at version **1.0.0** ([21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md))
- Added priority hierarchy to AI rules
- Strengthened constitution governance
- Component tracking statuses; ADR Status fields
- Added testing, SEO, release process, glossary docs (17–20)
- Roadmap phase statuses normalized

## 0.1.0 — 2026-07-24

### Docs

- Initial `knowledge/` foundation (constitution through AI rules)
- Architecture moved to [02-architecture](02-architecture.md)
- ADRs recorded in [06-decisions](06-decisions.md)
