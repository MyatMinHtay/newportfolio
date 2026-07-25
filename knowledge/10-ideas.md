# 10 — Ideas (Deferred)

**Purpose:** Parking lot for future features. **Do not implement** unless moved onto [09-roadmap](09-roadmap.md) with an ADR if architecture is affected.

**Related:** [01-project-overview](01-project-overview.md) · [02-architecture](02-architecture.md) · [06-decisions](06-decisions.md)

---

## Content & portfolio

| Idea | Notes |
|------|-------|
| Case Studies | Structured sections beyond Markdown body |
| Project Gallery | `project_images` table, lightbox UI |
| Testimonials | New model or settings blocks |
| Services / offerings | Only if freelancing pages needed |

---

## Blog & discovery

| Idea | Notes |
|------|-------|
| Full-text Search | Start with SQL; Scout later |
| RSS / Atom feed | Cheap win later |
| Related posts | Tagging may be required first |
| Reading time | Derived from Markdown length |

---

## SEO & growth

| Idea | Notes |
|------|-------|
| Per-page meta title/description | Columns or meta table |
| Sitemap.xml generator | Artisan command or package |
| Open Graph images | Per project/post |
| Analytics | Privacy-friendly first; don’t pollute content tables |

---

## Platform

| Idea | Notes |
|------|-------|
| Public JSON API | Sanctum + `routes/api.php` |
| Dark Mode | CSS variables already reserved |
| Theme Toggle | Depends on dark mode |
| Multi-admin | Expand `is_admin` / allowlist carefully |
| Activity log | Optional package later |
| Contact CAPTCHA | If spam appears |
| Email notifications on contact | Queue optional |

---

## Explicitly rejected (unless constitution changes)

- Tailwind
- Filament / Nova
- Livewire / Vue / React SPA admin
- Repository Pattern as default
- Premature microservices

---

## How to promote an idea

1. Write a short problem statement.
2. Add a roadmap phase/item.
3. If schema/stack changes → ADR in [06-decisions](06-decisions.md).
4. Update [02-architecture](02-architecture.md) / [03-database](03-database.md) as needed.
