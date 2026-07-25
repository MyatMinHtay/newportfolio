# 17 — Testing

**Purpose:** Testing philosophy and roadmap. Documentation only for now — implement tests as features land.

**Related:** [04-coding-style](04-coding-style.md) · [09-roadmap](09-roadmap.md) · [19-release-process](19-release-process.md)

---

## Table of contents

1. [Philosophy](#1-philosophy)
2. [Unit tests](#2-unit-tests)
3. [Feature tests](#3-feature-tests)
4. [Browser tests](#4-browser-tests)
5. [What to test first](#5-what-to-test-first)
6. [Future testing roadmap](#6-future-testing-roadmap)

---

## 1. Philosophy

- Test behavior that protects the **admin gate**, **publishing rules**, and **contact/upload** surfaces first.
- Prefer fewer high-value feature tests over exhaustive unit trivia.
- Tests should read like specifications.
- Do not block Phase 0 on a perfect suite — grow tests with each phase.
- Use Laravel’s default PHPUnit (or Pest if later approved — default remains PHPUnit).

---

## 2. Unit tests

**Target:** Pure logic with little IO.

Examples:

- Slug generation helpers
- Setting cache get/set/bust behavior (with cache fake)
- Markdown rendering expectations (escaped output)

Avoid unit-testing Eloquent itself.

---

## 3. Feature tests

**Target:** HTTP + database (RefreshDatabase).

Examples:

- Guest cannot access `/admin`
- Non-admin user gets 403
- Admin can CRUD a project
- Unpublished project not visible publicly
- Contact form validation + throttle
- Resume download returns active file only
- Google allowlist rejection (where mockable)

---

## 4. Browser tests

**Status:** Deferred for early phases.

Optional later with Laravel Dusk for:

- Admin login happy path
- Mobile nav smoke
- Critical publish flows

Not required for v1 launch unless pain appears.

---

## 5. What to test first (priority)

1. Admin middleware / `is_admin`  
2. Published scopes on public routes  
3. Contact form  
4. Resume activation invariant (one active)  
5. Settings cache bust  

---

## 6. Future testing roadmap

| Stage | Focus |
|-------|-------|
| Phase 0–1 | Auth + settings smoke feature tests |
| Phase 2–3 | Resource CRUD + public visibility |
| Phase 4 | Regression around SEO meta / uploads |
| Post-v1 | Dusk smoke; CI on push |

Document new critical invariants here when discovered.
