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
| `keywords` | Comprehensive keywords (Laravel, n8n, MMQR, Telegram bots, SEO, API, web development Myanmar) |
| `viewport` | Standard responsive |

---

## 4. Open Graph (Social Previews: Facebook, Messenger, Telegram)

**Status:** Completed (`<x-layout.seo-meta />`)

To ensure rich link cards display reliably on Facebook, Messenger, Telegram, LinkedIn, and Discord:

- `og:site_name`
- `og:type` (`website` or `article`)
- `og:title` & `og:description`
- `og:url` (canonical self)
- `og:locale` (`en_US`)
- `og:image` & `og:image:secure_url` (absolute HTTPS URL)
- `og:image:width` (`1200`) & `og:image:height` (`630`) — mandatory for Facebook/Messenger instant preview generation without requiring crawler pre-caching
- `og:image:type` (`image/jpeg` or `image/png`)
- Root HTML declaration contains Open Graph namespaces: `prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb#"`

---

## 5. Twitter / X Cards

**Status:** Completed

- `twitter:card` set to `summary_large_image`
- `twitter:url` matching canonical URL
- `twitter:title` & `twitter:description`
- `twitter:image` & `twitter:image:alt`
- `twitter:site` & `twitter:creator` (from `settings.twitter_handle`)

---

## 6. Canonical URLs

- Each public page emits `<link rel="canonical" href="...">` to its preferred URL
- Avoid duplicate content via query-string variants (don’t index sort/filter noise)

---

## 7. robots.txt

- Allow public site (`Allow: /`)
- Disallow `/admin` and auth endpoints (`Disallow: /admin`, `Disallow: /login`)
- Dynamic endpoint (`/robots.txt`) with configurable search indexing toggle in Admin Settings (`robots_indexing`)
- Direct pointer to sitemap: `Sitemap: https://myatminhtay.dev/sitemap.xml`

---

## 8. sitemap.xml

- Dynamic XML feed at `/sitemap.xml`
- Automatically indexes published Home, Blog index, individual published Blog posts (`/blog/{slug}`), and published Projects (`/projects/{slug}`)
- Excludes drafts, inactive pages, and administrative routes

---

## 9. Structured data (Schema.org)

**Status:** Completed

Emitted in `<x-layout.seo-meta />`:

1. **Schema.org Microdata:**
   - Tagged directly on meta elements (`itemprop="name"`, `itemprop="description"`, `itemprop="image"`).
2. **JSON-LD Script (`application/ld+json`):**
   - Implemented with safe Blade escaping (`@@context` and `@@type`) to prevent Blade directive parser traps.
   - Profile `Person` / `WebSite` schema identifying site owner, skills taxonomy, and core services offered.
