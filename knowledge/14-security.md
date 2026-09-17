# 14 — Security

**Purpose:** Practical security baseline for a personal portfolio CMS.

**Related:** [02-architecture](02-architecture.md) · [03-database](03-database.md) · [06-decisions](06-decisions.md) · [07-deployment](07-deployment.md) · [19-release-process](19-release-process.md)

---

## Table of contents

1. [Principles](#1-principles)
2. [Authentication](#2-authentication)
3. [Authorization](#3-authorization)
4. [Validation](#4-validation)
5. [Uploads](#5-uploads)
6. [XSS](#6-xss)
7. [CSRF](#7-csrf)
8. [Mass assignment](#8-mass-assignment)
9. [Rate limiting](#9-rate-limiting)
10. [Environment and secrets](#10-environment-and-secrets)
11. [Production checklist](#11-production-checklist)
12. [Must / Nice / Future](#12-must--nice--future)

---

## 1. Principles

Practical over theatrical. Laravel defaults first. Least privilege for admin. Never trust client input.

---

## 2. Authentication

- Password login for seeded admin only
- Google OAuth via Socialite + allowlist
- No public registration
- Secure cookies in production

---

## 3. Authorization

- `/admin/*` → `auth` + `EnsureUserIsAdmin`
- Google callback must allowlist email
- Public writes: contact form only (throttled)

---

## 4. Validation

Form Requests on all writes. Strict types. Unique slugs. Reject unexpected mass assignment via fillable.

---

## 5. Uploads

Canonical detail: [24-file-storage](24-file-storage.md). Caps: `config('project.upload_limits')`.

| Asset | Rules |
|-------|-------|
| Images | jpg/jpeg/png/webp + size cap |
| Resume | pdf + size cap |
| Names | UUID / generated — never client filename |
| Disk | `storage/app/public` + `storage:link` |

---

## 6. XSS

Blade `{{ }}` by default. Markdown via Laravel renderer. Avoid `{!! !!}` unless reviewed.

---

## 7. CSRF

`@csrf` on all state-changing forms. No SPA token complexity in v1.

---

## 8. Mass assignment

Explicit `$fillable`. Never request-fill `is_admin`. Guard resume `is_active` in controller transaction.

---

## 9. Rate limiting

Throttle login, Google callback, contact form.

---

## 10. Environment and secrets

Secrets in `.env` only. Never commit secrets. Google secret never in frontend JS.

---

## 11. Production checklist

### Application

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Strong `APP_KEY`
- [ ] `APP_URL` matches public HTTPS URL
- [ ] Config / route / view caches as appropriate

### Transport & cookies

- [ ] **HTTPS** only (HTTP redirects to HTTPS)
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] `SESSION_SAME_SITE=lax` (or `strict` if compatible)
- [ ] `SESSION_HTTP_ONLY=true` (Laravel default — verify)
- [ ] Trusted proxies configured if behind Cloudflare/Load balancer (`TrustProxies`)

### Files & storage

- [ ] `php artisan storage:link`
- [ ] Storage directories not world-writable beyond requirement
- [ ] Upload mime/size validation enforced
- [ ] Web server cannot execute scripts from `storage/`

### Ops

- [ ] Database **backup strategy** scheduled (daily minimum recommended)
- [ ] **Log rotation** configured (Laravel daily logs + host logrotate)
- [ ] OAuth redirect URI exact match
- [ ] Admin password rotated from any default seed
- [ ] Monitoring/uptime optional but encouraged

---

## 12. Must / Nice / Future

### Must Have (v1)

CSRF, Form Requests, admin middleware, allowlist, upload rules, XSS-safe rendering, throttles, fillable discipline, `APP_DEBUG=false`, HTTPS, secure cookies.

### Nice to Have

Security headers (X-Frame-Options, Referrer-Policy), contact `user_agent`, host firewall/fail2ban, automated backup verify.

### Future security improvements

- 2FA for admin
- CAPTCHA on contact if spam
- Content-Security-Policy hardening
- Activity audit log
- Malware scanning for uploads
- Automated dependency vulnerability scans (Composer/npm)

---

## Incident response (brief)

1. Rotate admin password / Google OAuth secret if needed  
2. Invalidate sessions  
3. Review `users` and recent `contact_messages`  
4. Check storage for unexpected files  
5. Record incident in changelog if user-facing
