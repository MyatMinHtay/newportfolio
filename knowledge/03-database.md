# 03 — Database

**Purpose:** Schema conventions, table definitions, indexes, soft-delete policy, and migration rules.

**Related:** [02-architecture](02-architecture.md) · [04-coding-style](04-coding-style.md) · [06-decisions](06-decisions.md) · [14-security](14-security.md)

---

## Table of contents

1. [Conventions](#1-conventions)
2. [Naming rules](#2-naming-rules)
3. [Soft delete policy](#3-soft-delete-policy)
4. [JSON usage](#4-json-usage)
5. [Indexes](#5-indexes)
6. [Relationships](#6-relationships)
7. [Table specifications](#7-table-specifications)
8. [Migration conventions](#8-migration-conventions)
9. [Future expansion rules](#9-future-expansion-rules)

---

## 1. Conventions

- Engine: InnoDB, utf8mb4
- Primary keys: `id` bigIncrements
- Foreign keys: `{model}_id` with explicit `onDelete` behavior
- Timestamps: `created_at`, `updated_at` on all tables unless documented otherwise
- Booleans: `is_*` prefixed (`is_published`, `is_admin`, `is_active`, `is_read`, `is_featured`)
- Ordering: `sort_order` integer default `0` (lower = earlier / higher priority as documented per resource)
- Public URLs: `slug` string, unique where used

---

## 2. Naming rules

| Item | Rule | Example |
|------|------|---------|
| Tables | snake_case plural | `blog_posts` |
| Columns | snake_case | `published_at` |
| Models | PascalCase singular | `BlogPost` |
| Pivot tables | singular alphabetical | (none in v1) |
| Migrations | Laravel date prefix + action | `2026_07_24_000001_create_projects_table` |

---

## 3. Soft delete policy

| Table | Soft deletes? | Why |
|-------|---------------|-----|
| `projects` | Yes | Accidental delete / restore |
| `blog_posts` | Yes | Same |
| `experiences` | Yes | Same |
| `skills` | No | Cheap to recreate; less clutter |
| `services` | No | Cheap to recreate |
| `social_links` | No | Tiny list |
| `categories` | No | Reassign or null posts on delete |
| `settings` | No | Key-value registry |
| `contact_messages` | No | Hard delete is fine |
| `resumes` | No | Keep history via rows; deactivate instead |
| `users` | No (v1) | Single admin |

Never soft-delete “just in case” on every table.

---

## 4. JSON usage

Use JSON when:

- The value is a **list of primitives** owned by one row
- You do not need to query/filter individual elements as first-class relations

**v1 usage:** `projects.tech_stack` — JSON array of strings, e.g. `["Laravel","MySQL"]`.

Do **not** create a `tags` / `project_tag` schema until you need tag pages or admin tag management.

Cast in Eloquent: `'tech_stack' => 'array'`.

---

## 5. Indexes

Always index:

- Unique business keys (`slug`, `settings.key`, `users.email`)
- Foreign keys (`user_id`, `category_id`)
- Common filters used together

Required composite / secondary indexes (v1):

| Table | Index |
|-------|-------|
| `projects` | `(is_published, sort_order)` |
| `projects` | `(is_featured, is_published)` |
| `blog_posts` | `(is_published, published_at)` |
| `blog_posts` | `category_id` |
| `experiences` | `(is_published, sort_order)` |
| `skills` | `(is_published, sort_order)` |
| `social_links` | `(is_published, sort_order)` |
| `contact_messages` | `(is_read, created_at)` |
| `users` | `google_id` (nullable unique or indexed) |

---

## 6. Relationships

| From | To | Type | On delete |
|------|----|------|-----------|
| User → BlogPost | hasMany | `user_id` cascade |
| Category → BlogPost | hasMany | `category_id` nullOnDelete |
| BlogPost → User | belongsTo | — |
| BlogPost → Category | belongsTo | — |

Standalone entities (no FKs in v1): Project, Skill, Experience, SocialLink, Setting, ContactMessage, Resume.

---

## 7. Table specifications

### `users`

- Stock Laravel auth columns
- `google_id` nullable string, indexed
- `avatar` nullable string
- `is_admin` boolean default `false`

### `projects`

- `title`, `slug` unique, `summary` text
- `body` longText nullable (Markdown)
- `cover_image` nullable
- `project_url`, `repo_url` nullable
- `tech_stack` JSON nullable
- `is_featured`, `is_published` booleans
- `sort_order` int
- `started_at`, `ended_at` nullable dates
- soft deletes

### `categories`

- `name`, `slug` unique
- timestamps only

### `blog_posts`

- `user_id`, `category_id` nullable
- `title`, `slug` unique
- `excerpt` text nullable
- `body` longText (Markdown)
- `cover_image` nullable
- `is_published`, `published_at` nullable
- soft deletes

### `skills`

- `name`, `category` string
- `icon_path` nullable (public-disk relative path, e.g. `skills/icons/{uuid}.png`)
- `proficiency` unsignedTinyInteger nullable (1–5)
- `sort_order`, `is_published`

### `services`

- `title` string
- `summary` text (short summary for cards)
- `details` text nullable (Markdown formatted scope, deliverables, technology stack, and timeline)
- `icon` string (Bootstrap Icons class, e.g. `bi-layers`, with or without `bi-` prefix)
- `sort_order` int
- `is_published` boolean
- timestamps only (no soft deletes — cheap to recreate)
- **Model helpers:**
  - `renderedDetails(): string` — parses `details` Markdown safely into HTML with sanitized output
  - `highlights(): array` — extracts bullet points from `details` for card preview pills

### `experiences`

- `company`, `role`, `location` nullable
- `start_date` date, `end_date` date nullable (null = present)
- `description` text (Markdown)
- `sort_order`, `is_published`
- soft deletes

### `social_links`

- `label`, `url`, `icon` (Bootstrap Icons class name)
- `sort_order`, `is_published`

### `settings`

- `key` unique string
- `value` text nullable

### `contact_messages`

- `name`, `email`, `subject` nullable, `message`
- `is_read` default false
- `ip_address` nullable

### `resumes`

- `title`, `file_path`
- `is_active` boolean
- **App invariant:** at most one row with `is_active = true` (enforce in transaction; MySQL has no portable partial unique index)

---

## 8. Migration conventions

- One logical table (or tight alteration) per migration file
- Create indexes in the same migration as the columns
- Never assume production data in migrations
- Seeders: `AdminUserSeeder`, `SettingsSeeder` — idempotent where practical
- Do not put business logic in migrations

---

## 9. Future expansion rules

1. Prefer **new tables** for new concepts (`project_images`) over overloading unrelated columns.
2. Prefer **nullable columns** for optional metadata before inventing parallel tables.
3. Do not break public `slug` uniqueness without redirects.
4. Document schema changes in [08-changelog](08-changelog.md) and update this file.

---

## Maintenance

Schema changes require: migration + model update + this doc + changelog entry.
