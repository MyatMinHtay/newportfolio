# 00 — Project Constitution

**Purpose:** Highest authority for project governance. All other docs and code defer to these principles.

**Audience:** Humans and AI assistants.

**Related:** [01-project-overview](01-project-overview.md) · [02-architecture](02-architecture.md) · [06-decisions](06-decisions.md) · [16-ai-rules](16-ai-rules.md) · [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)

---

## Table of contents

1. [Governance](#1-governance)
2. [Principles](#2-principles)
3. [Enforcement](#3-enforcement)
4. [Documentation Status](#4-documentation-status)

---

## 1. Governance

These rules define **how the project may change**. They outrank chat suggestions, convenience refactors, and “helpful” AI inventions.

| Rule | Why |
|------|-----|
| **Constitution is the highest authority.** | Without a top law, every session renegotiates basics. |
| **Documentation is the source of truth.** | Code follows locked docs ([21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)). Chat memory is not authoritative. |
| **Architecture must not change without an ADR.** | Silent redesign causes drift. Update [06-decisions](06-decisions.md) + [02-architecture](02-architecture.md) first. |
| **Consistency is more important than clever code.** | Readable repetition beats clever abstraction for a solo CMS. |
| **Prefer Laravel native solutions.** | Fewer packages, fewer upgrade surprises. |
| **Keep the project simple.** | Personal portfolio ≠ SaaS platform. |
| **Avoid unnecessary abstraction.** | No Repository/Service/DDD by default. |
| **Documentation evolves before architecture.** | Write/update the decision, then change the architecture doc. |
| **Architecture evolves before implementation.** | Spec first; code second. Never “code then invent a story.” |

**Change order (mandatory):**

```text
Docs / ADR  →  Architecture doc  →  Implementation
```

Never the reverse.

---

## 2. Principles

### 2.1 Laravel Native First

Prefer Eloquent, Blade, Form Requests, Middleware, Cache, Socialite, and static `public/assets` before third-party frameworks or frontend build tools.

### 2.2 Bootstrap Only

UI = Bootstrap 5 + Bootstrap Icons + vanilla JS. No Tailwind. No Filament/Nova.

### 2.3 Documentation First

`knowledge/` is maintained continuously. Implementation follows locked docs.

### 2.4 AI Friendly

Clear names, numbered docs, explicit ADRs. Assistants must load docs before coding ([16-ai-rules](16-ai-rules.md)).

### 2.5 Keep It Simple

Smallest solution that works. Defer ideas to [10-ideas](10-ideas.md).

### 2.6 Convention over Configuration

Laravel naming and resource patterns unless an ADR says otherwise.

### 2.7 No Over-Engineering

No Repository, Service Layer, CQRS, DDD, Hexagonal, Event Sourcing, or microservices unless an ADR **Accepted** explicitly allows it.

### 2.8 One Source of Truth

| Concern | Document |
|---------|----------|
| Architecture | [02-architecture](02-architecture.md) |
| Database | [03-database](03-database.md) |
| Coding style | [04-coding-style](04-coding-style.md) |
| Design | [13-design-system](13-design-system.md) |
| Security | [14-security](14-security.md) |
| Decisions | [06-decisions](06-decisions.md) |

### 2.9 Reusable Components

Repeated UI → Blade components tracked in [12-components](12-components.md).

### 2.10 Consistency over Cleverness

Boring, consistent patterns win.

---

## 3. Enforcement

If a proposal violates this constitution:

1. **Reject** it, or  
2. Update this constitution **and** add/accept an ADR **before** any code change.

During **LOCKED** documentation status, implementation must follow docs. Architecture changes require new ADR entries with status updates.

---

## 4. Documentation Status

See the canonical lock record: [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md).

| Field | Value |
|-------|-------|
| Version | **1.1.0** |
| Status | **LOCKED** (Foundation Lock) |
| Last Review | **2026-07-25** |
