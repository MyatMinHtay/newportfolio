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

## 0.12.0 — 2026-09-26

### Added
- **Production Deployment Live**:
  - Successfully verified and launched production site at [https://myatminhtay.dev/](https://myatminhtay.dev/).
  - Enforced SSL, storage symlinks, optimized config/route/view caching, and verified Google OAuth production callback URL.
- **Social Media Meta & SEO Upgrade**:
  - Expanded `<x-layout.seo-meta />` with complete Open Graph parameters (`og:image:secure_url`, `og:image:width`, `og:image:height`, `og:image:type`, `og:locale`).
  - Added full Twitter / X card support (`twitter:card`, `twitter:url`, `twitter:title`, `twitter:description`, `twitter:image`, `twitter:image:alt`, `twitter:site`, `twitter:creator`).
  - Added Schema.org microdata (`itemprop="name"`, `itemprop="description"`, `itemprop="image"`) and JSON-LD structured data (`application/ld+json`) for Person/Website with skills & services taxonomy.
  - Added extensive, high-converting Myanmar web development keywords (Laravel, n8n, Telegram bots, MMQR, deploy, API integration, etc.).
- **Interactive Service Details & Offerings Overhaul**:
  - Added `details` column to `services` table supporting full Markdown formatting.
  - Seeded 7 tailored core services: `Website & Webapp Development`, `n8n Automation Service`, `MMQR Payment Integration`, `Telegram Bot Development`, `API Integration`, `SEO (Search Engine Optimization)`, and `Website Deploy Service`.
  - Upgraded Homepage Services section with responsive 3-column grid, compact feature highlight pills with checkmarks, and interactive "View Details & Scope" buttons.
  - Implemented interactive Service Detail Modals (`#serviceModal{id}`) rendering Markdown deliverables (`.pf-prose`) and an "Inquire About This Service" action that pre-fills the contact form subject and smoothly navigates visitors to the contact message box.
  - Updated Admin Services CRUD to support managing service details and markdown formatting.
- **Automated Test Suite**:
  - Added `ServiceDetailTest.php` (4 tests, 22 assertions) and expanded `SeoTest.php` with social metadata assertions.
  - Test suite expanded to 64 tests (369 assertions) passing at 100%.

### Fixed
- **Bootstrap Modal Stacking & Backdrop Context**:
  - Moved all dynamic modals (video modal, service detail modals) into `@stack('modals')` at the root of the document `<body>` in `layouts/public.blade.php`.
  - Resolved the bug where modals nested inside `<main>` and container elements were trapped under `.modal-backdrop` (`z-index: 1050`), blocking all clicks, scroll, and close buttons.
  - Added explicit dismiss listeners and ensured keyboard `Escape` key and backdrop clicks smoothly close dialogs.
- **Modal Header Clipping & Scroll Dynamics**:
  - Removed `modal-dialog-centered` on tall dialogs, preventing modal headers from being clipped beneath sticky navigation bars.
  - Applied top-margin spacing (`1.25rem` mobile, `2rem` desktop) and enhanced smooth touch scrolling (`-webkit-overflow-scrolling: touch; overscroll-behavior: contain;`).

### Changed
- **Typography Floor Enforcement (PC >= 16px / Mobile >= 12px)**:
  - Enforced global typography scale floors: PC desktop minimum font size is `16px` (`1rem`) and mobile minimum font size is `12px` (`0.75rem`) for viewports `<= 575.98px` down to `320px`.
  - Updated `small`, `.small`, `.badge`, `.pf-tech-pill`, and `.pf-service-feature-list li` across `app.css` and Blade templates to eliminate overly small text and ensure comfortable legibility on all displays.

### Docs
- Updated `01-project-overview.md`, `03-database.md`, `05-ui-guidelines.md`, `07-deployment.md`, `09-roadmap.md`, `13-design-system.md`, and `18-seo.md` to reflect production deployment and recent features.
- Bumped documentation status lock to `1.2.0` in `21-DOCUMENTATION-STATUS.md`.

## 0.11.0 — 2026-09-20

### Added
- **Phase 4 (Polish) Complete**:
  - **Enhanced Admin Dashboard (`/admin`)**:
    - Comprehensive metric counters: Published vs Featured case studies breakdown, Published vs Draft blog posts breakdown, and Skills/Services/Roles summary.
    - Active Resume status widget with direct PDF preview and management links.
    - Quick Action toolbar ("New case study", "New post", "Settings").
    - Two-column live activity overview displaying Recent Case Studies, Recent Technical Blog Posts, and Recent Contact Inquiries with unread indicators.
  - **Featured & Publish UX**:
    - Filter tabs for both Case Studies and Blog Posts (`All`, `Published`, `Hidden/Draft`, `Featured`).
    - One-click status toggles for publishing and featuring without opening the edit form (`projects.toggle-publish`, `projects.toggle-featured`, `posts.toggle-publish`).
    - Direct "View live" links for published case studies and blog articles.
  - **Upload Hardening & Cleanup**:
    - Strict allowed image MIME constraints (`jpg, jpeg, png, webp`) across blog and project form requests.
    - Automatic deletion of superseded cover images upon updating case studies.
    - Directory sanitization and traversal prevention in `PublicUpload` helper.
  - **Universal Empty States**:
    - Public homepage graceful fallback states for projects, skills, and experiences.
    - Contextual category empty state in blog index (`/blog?category=...`) with "View All Articles" return button.
    - Detailed empty states for all admin filter views.
  - **Automated Test Suite**:
    - `PhaseFourPolishTest.php` (8 tests, 40 assertions) verifying one-click toggles, status filters, upload cleanup, and dashboard metrics.
    - Full test suite expanded to 46 tests (245 assertions) passing with 100% success.

## 0.10.0 — 2026-09-19

### Added
- **SEO Management in Admin Settings (`/admin/settings`)**:
  - Configurable Meta Description, Meta Keywords, Meta Author, Twitter / X handle, and Search Engine Visibility toggle (`robots_indexing`).
- **Dynamic SEO Meta Component (`<x-layout.seo-meta />`)**:
  - Injected into public layout `<head>` with automatic fallbacks to admin settings.
  - Page-specific overrides for Blog post (`/blog/{slug}`) and Case study (`/projects/{slug}`) articles.
  - Open Graph tags (`og:title`, `og:description`, `og:image`, `og:type`, `og:url`, `og:site_name`) and Twitter Card tags (`twitter:card`, `twitter:creator`, `twitter:site`).
  - Canonical URL links on every public page.
- **Dynamic & Extensible Sitemap (`/sitemap.xml`)**:
  - `SitemapService` generates standard Sitemap Protocol 0.9 XML.
  - Automatically indexes core routes (`/`, `/blog`), all published projects, and published blog posts (excluding drafts/hidden items).
  - Built-in runtime provider registry (`SitemapService::registerProvider()`) allowing upcoming routes/features to be indexed cleanly.
- **Dynamic `robots.txt` (`/robots.txt`)**:
  - Routed via `SeoController@robots` to respect the Admin "Search Engine Visibility" setting.
  - Disallows crawler indexing entirely when indexing is disabled.
  - When enabled, protects `/admin/`, `/login`, `/logout`, and auth routes, while declaring the dynamic `Sitemap:` endpoint.
- **Automated Test Suite**:
  - `SeoTest.php` feature test suite (6 tests, 34 assertions) verifying robots directives, sitemap XML validity, extensible providers, public meta tags, and admin settings update.
  - Total test suite expanded to 38 tests (205 assertions) passing.

### Changed
- Ignored `oldportfolio/` folder in `.gitignore`.
- Removed static `public/robots.txt` to allow dynamic Laravel routing.



### Added
- **Phase 3 Complete:**
  - Admin **Contact Messages Inbox** (`/admin/messages`) with message telemetry inspection, unread badge counters, toggle read/unread, and deletion.
  - Admin **Categories** CRUD (`/admin/categories`) for post organization.
  - Admin **Blog Posts** CRUD (`/admin/posts`) supporting Markdown articles, cover image uploads, and publish date control.
  - Public **Blog index & article reading view** (`/blog`, `/blog/{slug}`) with category filtering and related posts.
- **Case Study Detail Page:**
  - Public **Case Study Detail view** (`/projects/{slug}`) rendering full Markdown bodies (`.pf-prose`), cover media, tech stacks, live links, and demo video modals.
  - Linked project titles and "Case study" CTA buttons on the public homepage.
  - Comprehensive feature test suites (`PhaseThreeCrudTest.php`, `PublicContentTest.php`) bringing total test suite to 32 tests (171 assertions passing).

### Changed
- Added Blog navigation link to public navbar with anchor link compatibility.
- Added live unread message count badge to admin sidebar navigation.
- Added `.pf-prose` typography tokens and responsive styles to `public/assets/css/app.css`.

## 0.8.0 — 2026-09-18

### Added
- **Phase 1 Complete:**
  - Admin **Settings** management (`/admin/settings`) with cached key-value store (`Setting::allCached()`, `Setting::set()`).
  - Admin **Social Links** CRUD (`/admin/social-links`) with Bootstrap Icons and sort ordering.
- **Phase 2 Complete:**
  - Admin **Experience** CRUD (`/admin/experiences`) for career milestones, date ranges, and markdown descriptions.
  - Admin **Resumes** management (`/admin/resumes`) for PDF upload, single-active enforcement, and homepage download button wiring.
  - Public upload support for PDFs via `PublicUpload::storePdf()`.
  - Feature test suite (`PhaseOneAndTwoCrudTest.php`) verifying all CRUD actions and public homepage sync (24 tests / 117 assertions passing).

### Changed
- Reorganized admin navigation into Main, Portfolio, System, and Coming next groups.
- Synchronized hero social links and active resume download button in `welcome.blade.php`.
- Updated admin dashboard with resume and social link metrics.

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
