# 24 — File Storage

**Purpose:** Conventions for uploads and public files. **Documentation only** — no upload implementation in Foundation Lock.

**Related:** [03-database](03-database.md) · [14-security](14-security.md) · [25-validation](25-validation.md) · [config/project.php](../config/project.php) `upload_limits`

---

## Disk

| Disk | Use |
|------|-----|
| `public` | User-facing uploads (covers, profile, resumes) via `storage/app/public` |
| Symlink | `php artisan storage:link` → `public/storage` |

Never store uploads under `public/assets/` (reserved for app CSS/JS/libs).

---

## Folder hierarchy

```text
storage/app/public/
├── projects/covers/
├── skills/icons/
├── blog/covers/
├── resumes/
└── profile/
```

| Path | Contents |
|------|----------|
| `projects/covers/` | Project cover images |
| `skills/icons/` | Skill icons uploaded from admin |
| `blog/covers/` | Blog post covers |
| `resumes/` | Resume PDF files |
| `profile/` | About/profile photo |

---

## Naming rules

1. **Never** keep the client’s original filename as the stored name.
2. Generate a **UUID** (or UUID + safe extension), e.g. `a1b2c3d4-….webp`.
3. Extension derived from validated mime/type, lowercased.
4. Database stores the **relative path** on the public disk (e.g. `projects/covers/{uuid}.jpg`), not a full URL.

---

## Public URLs

```text
Storage::disk('public')->url($path)
→ /storage/projects/covers/{uuid}.jpg
```

Do not invent custom download routes unless auth is required (resume may be a controlled download later).

---

## Size & type caps (config)

Defaults live in `config/project.php` → `upload_limits`:

| Kind | Default max | Mimes |
|------|-------------|-------|
| Images | 2048 KB | jpg, jpeg, png, webp |
| Resume PDF | 5120 KB | pdf |

Enforce in Form Requests ([25-validation](25-validation.md)).

---

## Security

- Validate mime + size server-side
- Web server must not execute scripts from `storage/`
- Strip/ignore malicious double extensions
- Delete old files when replacing covers/resumes (implementation phase)

---

## Future image resize strategy

Deferred (not Foundation Lock):

1. v1: store original within size cap  
2. Later: optional intervention/spatie or native GD/Imagick resize to max width (e.g. 1600px) on upload  
3. Requires ADR before adding an image-processing package  

Do not add resize packages until approved.
