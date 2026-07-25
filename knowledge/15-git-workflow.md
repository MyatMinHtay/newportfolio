# 15 — Git Workflow

**Purpose:** Branching, commits, merges, and releases for this solo/personal CMS (still disciplined).

**Related:** [08-changelog](08-changelog.md) · [09-roadmap](09-roadmap.md) · [07-deployment](07-deployment.md)

---

## Table of contents

1. [Branches](#1-branches)
2. [Commit convention](#2-commit-convention)
3. [Workflow](#3-workflow)
4. [Merge strategy](#4-merge-strategy)
5. [Release tagging](#5-release-tagging)
6. [What not to commit](#6-what-not-to-commit)

---

## 1. Branches

| Branch | Purpose |
|--------|---------|
| `main` | Production-ready history |
| `develop` | Integration branch for ongoing work |
| `feature/*` | New features (`feature/admin-projects`) |
| `bugfix/*` | Non-hotfix fixes |
| `hotfix/*` | Urgent production fixes from `main` |
| `docs/*` | Documentation-only changes (optional) |

For a solo developer, `develop` may be optional—but if used, keep `main` releasable.

---

## 2. Commit convention

Use Conventional Commits style:

```text
type: short summary in imperative mood

optional body
```

| Type | Use |
|------|-----|
| `feat` | New user-facing feature |
| `fix` | Bug fix |
| `docs` | Knowledge / README only |
| `style` | Formatting; no logic change |
| `refactor` | Internal change without feature/fix |
| `test` | Tests |
| `chore` | Tooling, deps, housekeeping |
| `build` | Vite/npm/composer build plumbing |
| `perf` | Performance |

Examples:

- `docs: add knowledge foundation`
- `feat: add projects admin CRUD`
- `fix: throttle contact form submissions`

---

## 3. Workflow

1. Branch from `develop` (or `main` if no develop)
2. Implement + update docs/changelog when needed
3. Self-review diff
4. Merge via PR if remote collaboration; otherwise merge locally with care
5. Deploy from `main`

---

## 4. Merge strategy

- Prefer **squash** for short feature branches (clean `main` history)
- Use merge commits for long-lived branches if needed
- Rebase only if comfortable; never rewrite published `main` history

Hotfix:

1. Branch `hotfix/...` from `main`
2. Fix + tag release
3. Merge back into `develop`

---

## 5. Release tagging

- Tag versions matching [08-changelog](08-changelog.md): `v0.1.0`, `v1.0.0`
- Annotated tags preferred: `git tag -a v1.0.0 -m "First production release"`
- First public launch → `v1.0.0`

---

## 6. What not to commit

- `.env`
- `node_modules/`, `vendor/` (unless project policy says otherwise — default Composer/npm ignore)
- Built secrets, IDE junk, personal notes with passwords
- Large binary dumps unrelated to the repo

`knowledge/` **is** committed — it is part of the product.
