# 16 — AI Rules

**Purpose:** Mandatory operating rules for all AI coding assistants (Cursor, ChatGPT, Claude, Gemini, Grok, etc.).

**Related:** [00-CONSTITUTION](00-CONSTITUTION.md) · [02-architecture](02-architecture.md) · [06-decisions](06-decisions.md) · [13-design-system](13-design-system.md) · [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)

---

## Table of contents

1. [Document priority hierarchy](#1-document-priority-hierarchy)
2. [Before writing any code](#2-before-writing-any-code)
3. [Hard prohibitions](#3-hard-prohibitions)
4. [Required practices](#4-required-practices)
5. [Documentation duties](#5-documentation-duties)
6. [When stuck](#6-when-stuck)
7. [Definition of done](#7-definition-of-done)

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
| **6** | Other `knowledge/*` docs (database, security, UI, components, …) |
| **7** | Implementation code (must conform upward) |
| **8** | Chat suggestions / “quick hacks” (lowest) |

**Rules:**

- Implementation code never overrides Locked documentation.
- Chat never overrides Constitution / Architecture / Accepted ADRs.
- To change architecture: new or updated ADR → update architecture doc → then code.
- Documentation status is **LOCKED** at version **1.0.0** — see [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md).

---

## 2. Before writing any code

**Always read (minimum set):**

1. [00-CONSTITUTION.md](00-CONSTITUTION.md)
2. [02-architecture.md](02-architecture.md)
3. [06-decisions.md](06-decisions.md)
4. [13-design-system.md](13-design-system.md)
5. [04-coding-style.md](04-coding-style.md)

Also recommended: [01-project-overview](01-project-overview.md), [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md).

Context-specific:

| Task | Also read |
|------|-----------|
| Schema / migrations | [03-database](03-database.md) |
| UI / Blade | [05-ui-guidelines](05-ui-guidelines.md), [12-components](12-components.md) |
| Auth / uploads | [14-security](14-security.md) |
| Phase planning | [09-roadmap](09-roadmap.md) |
| “Can we build X?” | [10-ideas](10-ideas.md) |
| SEO | [18-seo](18-seo.md) |
| Tests | [17-testing](17-testing.md) |
| Release | [19-release-process](19-release-process.md) |
| Terms | [20-glossary](20-glossary.md) |

---

## 3. Hard prohibitions

Never:

| Action | Reference |
|--------|-----------|
| Introduce Tailwind | ADR-001 |
| Introduce Filament / Nova | ADR-012 |
| Introduce Livewire / Vue / React / SPA | Architecture |
| Create Repository Pattern | ADR-006 |
| Create Service Layer without explicit human request + ADR | ADR-007 |
| Redesign architecture without ADR | Constitution |
| Add Composer/npm packages without human approval | Supply chain |
| Enable public registration | ADR-003 / Security |
| Mass-assign `is_admin` | Security |
| Implement [10-ideas](10-ideas.md) unprompted | Scope |
| Drive-by refactors unrelated to the task | Diff hygiene |
| Change Locked docs casually during Phase 0+ coding | Doc lock |

---

## 4. Required practices

- Laravel-native first
- Bootstrap 5 + Bootstrap Icons only
- Thin controllers; Form Requests; model scopes
- No DB queries in Blade
- Markdown for long-form content
- Cached settings with bust-on-write
- Admin: `auth` + `EnsureUserIsAdmin`
- Use glossary terms consistently ([20-glossary](20-glossary.md))
- Consistency over cleverness
- Focused diffs

---

## 5. Documentation duties

After implementation:

1. [08-changelog](08-changelog.md) entry  
2. Architecture change → ADR + [02-architecture](02-architecture.md)  
3. Schema change → [03-database](03-database.md)  
4. New component → update status in [12-components](12-components.md)  
5. Design token change → [13-design-system](13-design-system.md)  

Unlocking or amending Locked docs requires human approval and a changelog note.

---

## 6. When stuck

1. Re-read priority docs  
2. Ask the human  
3. Propose the simplest Laravel-native option  
4. Do not invent patterns to “be helpful”  

---

## 7. Definition of done

- Matches Constitution, Architecture, ADRs, Design System, Coding Style  
- Security checklist for touched surfaces  
- Component statuses updated if UI shipped  
- Changelog updated  
- No prohibited stacks/patterns  

---

## Quick start prompt

> Documentation is LOCKED at 1.0.0. Read `knowledge/00-CONSTITUTION.md`, `02-architecture.md`, `06-decisions.md`, `13-design-system.md`, `04-coding-style.md`, and follow `16-ai-rules.md` priority hierarchy. Bootstrap only. No Tailwind, Filament, repositories, or unsolicited services. Architecture changes require ADRs before code.
