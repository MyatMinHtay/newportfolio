# 18 — SEO

**Purpose:** SEO philosophy and checklist for the public portfolio site.

**Related:** [02-architecture](02-architecture.md) · [05-ui-guidelines](05-ui-guidelines.md) · [09-roadmap](09-roadmap.md) · [10-ideas](10-ideas.md)

---

## Table of contents

1. [Philosophy](#1-philosophy)
2. [Baseline (v1)](#2-baseline-v1)
3. [Meta tags](#3-meta-tags)
4. [Open Graph](#4-open-graph)
5. [Twitter Cards](#5-twitter-cards)
6. [Canonical URLs](#6-canonical-urls)
7. [robots.txt](#7-robotstxt)
8. [sitemap.xml](#8-sitemapxml)
9. [Structured data (future)](#9-structured-data-future)

---

## 1. Philosophy

- Clean URLs and clear titles beat gadgetry.
- One H1 per page; sensible heading order.
- Fast, readable pages help SEO and humans.
- Don’t spam keywords in a personal portfolio.
- Prefer settings-driven defaults + per-resource overrides later if needed.

---

## 2. Baseline (v1)

Phase 4 polish should include:

- Unique `<title>` per page
- Meta description from settings (site-wide) and post/project excerpt when available
- Canonical self URL
- Sensible `robots.txt`
- Basic sitemap of published public URLs

---

## 3. Meta tags

| Tag | Source (v1 guidance) |
|-----|----------------------|
| `title` | Page-specific; fall back to `settings.site_name` |
| `description` | `settings.meta_description` or content excerpt |
| `viewport` | Standard responsive |

---

## 4. Open Graph

Minimum later/v1.1:

- `og:title`, `og:description`, `og:type`, `og:url`
- `og:image` when cover images exist

---

## 5. Twitter Cards

- `summary` or `summary_large_image` when images exist
- Align with Open Graph fields to avoid drift

---

## 6. Canonical URLs

- Each public page emits `<link rel="canonical" href="...">` to its preferred URL
- Avoid duplicate content via query-string variants (don’t index sort/filter noise)

---

## 7. robots.txt

- Allow public site
- Disallow `/admin` and auth endpoints
- Point to sitemap when available

---

## 8. sitemap.xml

- Include published: home, about, experience, skills, projects, posts, contact
- Exclude drafts / admin
- Generate via simple artisan command or static builder in Phase 4+

---

## 9. Structured data (future)

Deferred ([10-ideas](10-ideas.md)):

- `Person` / `ProfilePage`
- `BlogPosting` for posts
- `ItemList` for projects

Add only when content volume justifies it.
