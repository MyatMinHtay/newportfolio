# 16 — AI Rules

**Purpose:** Mandatory operating rules for all AI coding assistants (Cursor, ChatGPT, Claude, Gemini, Grok, etc.).

**Related:** [00-CONSTITUTION](00-CONSTITUTION.md) · [02-architecture](02-architecture.md) · [06-decisions](06-decisions.md) · [13-design-system](13-design-system.md) · [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md) · [FOUNDATION-LOCK-REPORT](../FOUNDATION-LOCK-REPORT.md)

---

## Table of contents

1. [Document priority hierarchy](#1-document-priority-hierarchy)
2. [Mandatory rules (Foundation Lock)](#2-mandatory-rules-foundation-lock)
3. [Before writing any code](#3-before-writing-any-code)
4. [Hard prohibitions](#4-hard-prohibitions)
5. [Required practices](#5-required-practices)
6. [Documentation duties](#6-documentation-duties)
7. [When stuck](#7-when-stuck)
8. [Definition of done](#8-definition-of-done)

---

## 1. Document priority hierarchy

If two sources conflict, the **higher** item wins.

| Priority | Source |
|---------:|--------|
| **1** | [00-CONSTITUTION.md](00-CONSTITUTION.md) |
| **2** | [02-architecture.md](02-architecture.md) |
| **3** | [06-decisions.md](06-decisions.md) (Accepted ADRs) |
| **4** | [13-design-system.md](13-design-system.md) |
| **5** | [04-coding-style.md](04-coding-style.md) |
| **6** | Other `knowledge/*` docs |
| **7** | Implementation code (must conform upward) |
| **8** | Chat suggestions / “quick hacks” (lowest) |

---

## 2. Mandatory rules (Foundation Lock)

These are non-negotiable:

1. **Documentation First** — Update or read docs before coding behavior changes.
2. **Architecture First** — Spec in [02-architecture](02-architecture.md) / ADR before implementation.
3. **Never invent architecture** — No new layers, stacks, or patterns without an Accepted ADR.
4. **Never refactor without approval** — No drive-by cleanups unrelated to the asked task.
5. **Never generate duplicate components** — Reuse [22-ui-components](22-ui-components.md) / [12-components](12-components.md).
6. **Prefer Laravel conventions** — Eloquent, Blade, Form Requests, Middleware, native features first.
7. **Bootstrap only** — UI = Bootstrap 5 + Bootstrap Icons.
8. **Vanilla JS only** — No Livewire, Alpine, Vue, React, SPA frameworks.
9. **Never introduce Tailwind**
10. **Never introduce Vite** / `@vite()` / npm build pipelines (ADR-014 / ADR-015).
11. **Never install packages without approval** — Composer or npm.
12. **Always update CHANGELOG** — [08-changelog](08-changelog.md) for shipped work.
13. **Always update ADR when architecture changes** — Then update architecture doc, then code.

Additional notification rule:

- Toastify = global notifications; Bootstrap Alert = inline only ([27-toast-guidelines](27-toast-guidelines.md)).

---

## 3. Before writing any code

**Always read (minimum set):**

1. [00-CONSTITUTION.md](00-CONSTITUTION.md)
2. [02-architecture.md](02-architecture.md)
3. [06-decisions.md](06-decisions.md)
4. [13-design-system.md](13-design-system.md)
5. [04-coding-style.md](04-coding-style.md)
6. [16-ai-rules.md](16-ai-rules.md) (this file)

Context-specific:

| Task | Also read |
|------|-----------|
| Schema / migrations | [03-database](03-database.md) |
| UI / Blade | [05-ui-guidelines](05-ui-guidelines.md), [12-components](12-components.md), [22-ui-components](22-ui-components.md) |
| Auth / uploads | [14-security](14-security.md), [24-file-storage](24-file-storage.md) |
| Validation | [25-validation](25-validation.md) |
| Naming | [26-naming](26-naming.md) |
| Logging | [23-logging](23-logging.md) |
| Toasts | [27-toast-guidelines](27-toast-guidelines.md) |
| Phase planning | [09-roadmap](09-roadmap.md) |
| Ideas backlog | [10-ideas](10-ideas.md) |

---

## 4. Hard prohibitions

| Action | Reference |
|--------|-----------|
| Introduce Tailwind | ADR-001 |
| Introduce Vite / npm frontend build | ADR-014 |
| Put libs outside `public/assets/libs/` | ADR-015 |
| Extra toast libraries | ADR-016 |
| Filament / Nova | ADR-012 |
| Livewire / Vue / React / SPA | Architecture |
| Repository Pattern | ADR-006 |
| Service Layer without ADR | ADR-007 |
| Public registration | ADR-003 |
| Mass-assign `is_admin` | Security |
| Implement [10-ideas](10-ideas.md) unprompted | Scope |
| Business logic in `app/Support` | ADR-017 |
| Silent architecture changes | Constitution |

---

## 5. Required practices

- Thin controllers; Form Requests; model scopes
- No DB queries in Blade
- Markdown for long-form content (when content lands)
- Cached settings with bust-on-write (when settings land)
- Admin: `auth` + `EnsureUserIsAdmin` (when auth lands)
- Use [20-glossary](20-glossary.md) terms
- Use `config/project.php` for shared numeric/string defaults
- Consistency over cleverness; focused diffs

---

## 6. Documentation duties

After implementation that ships:

1. [08-changelog](08-changelog.md) entry  
2. Architecture change → ADR + [02-architecture](02-architecture.md)  
3. Schema change → [03-database](03-database.md)  
4. New UI component → [12-components](12-components.md) + [22-ui-components](22-ui-components.md)  
5. Design token change → [13-design-system](13-design-system.md)  
6. Naming/validation/storage convention change → docs 24–26  

---

## 7. When stuck

1. Re-read priority docs  
2. Ask the human  
3. Propose the simplest Laravel-native option  
4. Do not invent patterns to “be helpful”  

---

## 8. Definition of done

- Matches Constitution, Architecture, ADRs, Design System, Coding Style  
- Security checklist for touched surfaces  
- Changelog updated  
- No prohibited stacks/patterns  
- No duplicate components  
- Docs updated if conventions changed  

---

## Quick start prompt

> Foundation is LOCKED. Read `knowledge/00-CONSTITUTION.md`, `02-architecture.md`, `06-decisions.md`, `13-design-system.md`, `04-coding-style.md`, `16-ai-rules.md`. Documentation first. Architecture first. Bootstrap + vanilla JS only. No Tailwind, Vite, Filament, repositories, or unsolicited packages. ADR before any architecture change. Update changelog when shipping.
