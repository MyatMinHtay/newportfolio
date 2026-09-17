# 15 — Git Workflow

**Purpose:** Branching, commits, merges, hotfixes, tags, and version numbering.

**Related:** [08-changelog](08-changelog.md) · [09-roadmap](09-roadmap.md) · [07-deployment](07-deployment.md) · [19-release-process](19-release-process.md)

---

## Table of contents

1. [Branch naming](#1-branch-naming)
2. [Commit message convention](#2-commit-message-convention)
3. [Workflow](#3-workflow)
4. [Merge strategy](#4-merge-strategy)
5. [Release tags](#5-release-tags)
6. [Hotfix process](#6-hotfix-process)
7. [Version numbering](#7-version-numbering)
8. [What not to commit](#8-what-not-to-commit)

---

## 1. Branch naming

| Pattern | Purpose | Example |
|---------|---------|---------|
| `main` | Production-ready | — |
| `develop` | Integration (optional for solo) | — |
| `feature/<slug>` | New capability | `feature/admin-projects` |
| `fix/<slug>` | Non-urgent bug | `fix/contact-throttle` |
| `hotfix/<slug>` | Urgent production fix from `main` | `hotfix/login-500` |
| `docs/<slug>` | Documentation only | `docs/foundation-lock` |
| `chore/<slug>` | Tooling / deps | `chore/update-bootstrap` |

Rules:

- Lowercase kebab-case slugs
- No personal names in branch titles
- One concern per branch

---

## 2. Commit message convention

[Conventional Commits](https://www.conventionalcommits.org/)-style:

```text
type: short summary in imperative mood

optional body explaining why
```

| Type | Use |
|------|-----|
| `feat` | User-facing feature |
| `fix` | Bug fix |
| `docs` | Knowledge / README |
| `style` | Formatting only |
| `refactor` | Internal change (requires approval if large) |
| `test` | Tests |
| `chore` | Housekeeping |
| `build` | Composer / `public/assets/libs` updates |
| `perf` | Performance |

Examples:

- `docs: lock foundation conventions`
- `feat: add projects admin CRUD`
- `fix: throttle contact form submissions`

Do not commit secrets. Prefer small commits over giant dumps.

---

## 3. Workflow

1. Branch from `develop` (or `main` if no develop)
2. Implement against Locked docs
3. Update changelog / ADR / related knowledge when required
4. Self-review diff
5. Merge to integration branch → `main` for release
6. Deploy from `main` / tag

---

## 4. Merge strategy

- Prefer **squash** for short feature branches
- Merge commits OK for long-lived branches
- Never force-push `main`
- Rebase only on private branches you own

---

## 5. Release tags

- Annotated tags matching [08-changelog](08-changelog.md): `v0.4.0`, `v1.0.0`
- Command example: `git tag -a v1.0.0 -m "First production release"`
- Push tags when remotes are used: `git push origin v1.0.0`
- Tag only releasable `main` commits

---

## 6. Hotfix process

1. Branch `hotfix/<slug>` from `main`
2. Minimal fix + test + changelog patch entry
3. Merge to `main`, tag patch version (`vX.Y.Z`)
4. Deploy
5. Merge `main` back into `develop` (if used)

---

## 7. Version numbering

Semantic Versioning ([08-changelog](08-changelog.md)):

| Bump | When |
|------|------|
| **MAJOR** | Breaking owner workflow / public URL / schema care |
| **MINOR** | Backward-compatible features |
| **PATCH** | Fixes, docs lock notes that ship with code |

Also keep `config('project.version')` aligned when cutting a release.

Docs foundation lock may use its own doc version in [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md); app versions continue in the changelog.

---

## 8. What not to commit

- `.env` (use `.env.example` for non-secret keys)
- `vendor/`, `node_modules/`
- `storage/logs/*`, uploaded user files
- Secrets, IDE junk, personal credentials

`knowledge/` **is** committed — documentation is part of the product.
