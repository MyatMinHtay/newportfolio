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
