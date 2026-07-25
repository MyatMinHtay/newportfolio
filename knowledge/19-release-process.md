# 19 — Release Process

**Purpose:** How work moves from development to production safely.

**Related:** [08-changelog](08-changelog.md) · [09-roadmap](09-roadmap.md) · [15-git-workflow](15-git-workflow.md) · [07-deployment](07-deployment.md) · [14-security](14-security.md) · [17-testing](17-testing.md)

---

## Table of contents

1. [Versioning strategy](#1-versioning-strategy)
2. [Development](#2-development)
3. [Review](#3-review)
4. [Testing](#4-testing)
5. [Release](#5-release)
6. [Deployment](#6-deployment)
7. [Hotfix](#7-hotfix)
8. [Rollback](#8-rollback)

---

## 1. Versioning strategy

- App versions follow SemVer in [08-changelog](08-changelog.md)
- Docs lock is **1.0.0** ([21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)) — independent of app `0.x` while building
- First production app launch → tag `v1.0.0` (or continue from highest shipped app version)

---

## 2. Development

1. Branch from `develop` or `main` per [15-git-workflow](15-git-workflow.md)
2. Implement against Locked docs
3. Update component statuses / changelog as needed
4. Keep commits conventional (`feat`, `fix`, `docs`, …)

---

## 3. Review

Solo or with AI assistance:

- Diff matches the requested phase/task only
- No prohibited packages/patterns
- Security checklist for touched surfaces
- Docs updated if architecture/schema/UI contracts changed (via ADR if needed)

---

## 4. Testing

- Run relevant feature/unit tests ([17-testing](17-testing.md))
- Manual smoke: login, one CRUD, one public page, contact (when exist)
- `npm run build` succeeds before production deploy

---

## 5. Release

1. Bump version in changelog
2. Merge to `main`
3. Annotated git tag `vX.Y.Z`
4. Note release in changelog date

---

## 6. Deployment

Follow [07-deployment](07-deployment.md) production checklist:

- Pull/tag on server
- `composer install --no-dev`
- `npm ci && npm run build` (or deploy built assets)
- `php artisan migrate --force`
- `config:cache` / `route:cache` / `view:cache` as appropriate
- `storage:link` if needed
- Verify HTTPS + admin login + homepage

---

## 7. Hotfix

1. Branch `hotfix/*` from `main`
2. Minimal fix + test
3. Tag patch version
4. Deploy
5. Merge back to `develop`

---

## 8. Rollback

| Layer | Action |
|-------|--------|
| Code | Redeploy previous git tag |
| Migrations | Prefer forward-fix; keep migrations backward-safe; restore DB backup if destructive |
| Assets | Redeploy previous `public/build` |
| Config | Keep previous `.env` unless the release required env changes |

Always verify backup freshness before risky migrations.
