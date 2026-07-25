# 01 — Project Overview

**Purpose:** Describe what this product is, who it serves, and what it deliberately is not.

**Related:** [00-CONSTITUTION](00-CONSTITUTION.md) · [02-architecture](02-architecture.md) · [09-roadmap](09-roadmap.md) · [10-ideas](10-ideas.md)

---

## Table of contents

1. [Product summary](#1-product-summary)
2. [Goals](#2-goals)
3. [Target users](#3-target-users)
4. [In scope](#4-in-scope)
5. [Out of scope](#5-out-of-scope)
6. [Future vision](#6-future-vision)
7. [Product philosophy](#7-product-philosophy)
8. [Tech stack (locked)](#8-tech-stack-locked)

---

## 1. Product summary

**Laravel Portfolio CMS** is a personal portfolio website with a private content management system.

It is:

- A public multi-page portfolio (Home, About, Experience, Skills, Projects, Blog, Contact, Resume)
- A private `/admin` CMS for the site owner

It is **not**:

- A SaaS product
- A multi-tenant platform
- A distributable open-source CMS for other companies’ teams

---

## 2. Goals

1. Replace a static portfolio with dynamic, owner-editable content.
2. Keep the codebase maintainable for years with Laravel conventions.
3. Ship a professional, minimal UI (Bootstrap 5) for public and admin.
4. Stay simple enough that one developer (plus AI assistants) can own it.
5. Leave room for later features (gallery, case studies, API) without rewriting cores.

---

## 3. Target users

| Role | Needs |
|------|--------|
| **Site owner (you)** | Login, CRUD content, manage settings, read contact messages, publish resume |
| **Public visitors** | Read portfolio content, contact you, download resume |

There is exactly **one admin**. There is no end-user account system for visitors.

---

## 4. In scope

### Public

- Home (hero, featured projects, latest posts)
- About
- Experience timeline
- Skills (grouped)
- Projects index + detail
- Blog index + detail + category filter
- Contact form
- Resume download

### Admin

- Dashboard
- Manage projects, blog posts, categories, skills, experience, social links
- Resume upload / activate
- Site settings
- Contact messages inbox
- Manual login + Google OAuth (allowlisted)

### Cross-cutting

- CSRF, validation, rate limiting, secure uploads
- Markdown for long-form content
- Cached key-value settings
- Documentation in `knowledge/`

---

## 5. Out of scope

Do **not** build in v1 (see also [10-ideas](10-ideas.md)):

- Multi-admin roles / permissions packages
- Filament, Nova, Livewire, Vue, React, SPA
- Tailwind CSS
- Repository / Service / DDD layers
- Case studies UI, project galleries, analytics dashboards
- Public JSON API
- Dark mode (tokens only; theme later)
- CAPTCHA (until spam appears)
- Visitor registration

---

## 6. Future vision

Over ~3 years the site may grow:

- Richer project case studies and image galleries
- Better SEO (per-page meta, sitemap polish)
- Optional public API for a separate frontend experiment
- Search, RSS, analytics

These must be additive. Core tables and controller style should not require a rewrite. See [02-architecture](02-architecture.md) and [09-roadmap](09-roadmap.md).

---

## 7. Product philosophy

- **Owner tools, not platform features.** Optimize for your workflow.
- **Content over chrome.** Quiet UI; content is the product.
- **Boring technology.** Laravel + Bootstrap age well.
- **Docs are part of the product.** Assistants and humans share one truth.

---

## 8. Tech stack (locked)

| Layer | Choice |
|-------|--------|
| Backend | Laravel 12, PHP 8.3+, MySQL |
| Templates | Blade |
| CSS/JS | Bootstrap 5, Bootstrap Icons, Vanilla JS, Vite |
| Auth | Manual login UI + Laravel Socialite (Google) |
| Hosting (dev) | XAMPP on Windows |

Changes to this stack require an ADR in [06-decisions](06-decisions.md) and an update to [00-CONSTITUTION](00-CONSTITUTION.md) if principles are affected.
