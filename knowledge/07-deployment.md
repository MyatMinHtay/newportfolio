# 07 — Deployment

**Purpose:** Local (XAMPP/Windows) and production deployment notes for the Portfolio CMS.

**Related:** [01-project-overview](01-project-overview.md) · [14-security](14-security.md) · [15-git-workflow](15-git-workflow.md)

---

## Table of contents

1. [Development environment](#1-development-environment)
2. [First-time setup](#2-first-time-setup)
3. [Day-to-day commands](#3-day-to-day-commands)
4. [Environment variables](#4-environment-variables)
5. [Storage](#5-storage)
6. [Production checklist](#6-production-checklist)
7. [Future VPS notes](#7-future-vps-notes)

---

## 1. Development environment

| Tool | Role |
|------|------|
| XAMPP | Apache + MySQL + PHP on Windows |
| Composer | PHP dependencies |
| Git | Source control |
| Node.js + npm | **Not required** (ADR-014 — static `public/assets/`) |

Document PHP version: **8.3+** (Laravel 12). Ensure XAMPP PHP matches.

Project path example: `C:\xampp\htdocs\portfolio`  
URL example: `http://localhost/portfolio/public` (or vhost pointing at `public/`).

---

## 2. First-time setup

High-level steps (implementation will flesh exact package installs in Phase 0):

1. Clone / open project
2. `composer install`
3. Copy `.env.example` → `.env`, generate `APP_KEY`
4. Create MySQL database; set `DB_*` (when Phase 0b+ migrations exist)
5. `php artisan migrate --seed` (when seeders exist)
6. `php artisan storage:link`
7. Serve via Apache vhost or `php artisan serve` — **no npm build**

---

## 3. Day-to-day commands

```bash
php artisan serve          # optional if not using Apache vhost
php artisan migrate
php artisan db:seed --class=SettingsSeeder
php artisan optimize:clear # local cache reset
```

Static assets are already under `public/assets/` (no `npm run build`).

On XAMPP Apache: point the vhost document root to `public/`, not the project root.

---

## 4. Environment variables

Minimum relevant keys (names finalized in Phase 0):

| Key | Purpose |
|-----|---------|
| `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `APP_URL` | App identity |
| `DB_*` | MySQL |
| `ADMIN_GOOGLE_EMAIL` | Google OAuth allowlist |
| `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` | Socialite |
| `MAIL_*` | Optional contact notifications later |
| `FILESYSTEM_DISK=public` | Uploads |

Never commit `.env`. Keep secrets out of `knowledge/` and chat logs when possible.

---

## 5. Storage

- Public uploads via `storage/app/public` → `public/storage`
- Suggested subdirs: `projects/covers`, `blog/covers`, `resumes`, `profile`
- Run `php artisan storage:link` on each environment

---

## 6. Production checklist

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Strong `APP_KEY`
- [ ] HTTPS enforced
- [ ] `npm run build` artifacts deployed
- [ ] `php artisan migrate --force`
- [ ] `php artisan config:cache` / `route:cache` / `view:cache` as appropriate
- [ ] `storage:link`
- [ ] Correct file permissions on `storage/` and `bootstrap/cache`
- [ ] Google OAuth redirect URI matches production URL
- [ ] Admin user seeded / password rotated
- [ ] Database backups scheduled

---

## 7. Future VPS notes

When moving beyond XAMPP:

- Nginx or Apache with `public/` as web root
- PHP-FPM 8.3+
- Queue worker only if queued jobs are introduced later
- Scheduler (`cron` → `schedule:run`) if scheduled commands appear
- Deploy via Git pull + Composer/npm on server, or CI artifact pipeline

Document the chosen host in this file when production exists.
