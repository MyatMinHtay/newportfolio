# 20 — Glossary

**Purpose:** Shared vocabulary for humans and AI assistants. Use these terms consistently in code, docs, UI labels, and commits.

**Related:** [01-project-overview](01-project-overview.md) · [02-architecture](02-architecture.md) · [03-database](03-database.md) · [16-ai-rules](16-ai-rules.md)

---

## A

**Admin** — The authenticated site owner operating the CMS under `/admin`. Requires `is_admin = true`.

**ADR** — Architecture Decision Record in [06-decisions](06-decisions.md).

**Allowlist** — The set of Google emails permitted to authenticate as admin (`ADMIN_GOOGLE_EMAIL`).

---

## B

**Badge** — Small UI chip showing status (Published, Draft, Featured, Unread).

**Blog Post** — A `blog_posts` record; long-form Markdown content; optionally categorized.

---

## C

**Category** — Blog taxonomy row (`categories`). Not used for skills (skills use a string category).

**CMS** — Content Management System; the private `/admin` application.

**Contact Message** — Submission stored in `contact_messages` from the public contact form.

---

## D

**Dashboard** — Admin home with counts/widgets (projects, posts, unread messages).

**Draft** — Content that is not published (`is_published = false`); not visible on the public site.

---

## E

**Experience** — A work-history entry (`experiences`) with company/role/dates.

---

## F

**Featured** — A project flagged `is_featured` for Home highlights (still must be published to appear publicly).

---

## P

**Project** — Portfolio work item (`projects`) with summary, optional Markdown body, links, tech stack.

**Public** — Unauthenticated visitor-facing website (not `/admin`).

**Published** — Content with `is_published = true` (and `published_at` when applicable) visible on public routes.

---

## R

**Resume** — PDF file record (`resumes`); exactly one may be `is_active` for public download.

---

## S

**Setting** — Key-value configuration row (`settings`) powering site copy/SEO defaults; cached.

**Skill** — Competency row (`skills`) with a string `category` (e.g. Backend).

**Slug** — URL-safe unique string for public resources (projects, posts, categories).

**Social Link** — Footer/header external profile link with Bootstrap Icon class.

---

## T

**Tech Stack** — JSON string array on a project listing technologies used.

---

## Usage note for AI

When naming variables, routes, UI copy, or docs:

- Prefer **Published** / **Draft** over vague “active/inactive” for content visibility  
- Prefer **Featured** only for projects  
- Prefer **Admin** for CMS operator; never call visitors “users” in UI unless meaning auth users  
- Prefer **Resume** for PDF CV; don’t confuse with Experience entries  
