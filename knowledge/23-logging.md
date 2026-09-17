# 23 — Logging

**Purpose:** When and how to log. Laravel default logger only — no third-party logging packages.

**Related:** [14-security](14-security.md) · [07-deployment](07-deployment.md) · [04-coding-style](04-coding-style.md)

---

## Principles

1. Use `Illuminate\Support\Facades\Log` (or `logger()`).
2. Prefer structured context arrays over interpolated secrets.
3. Never log passwords, tokens, full payment data, or entire request dumps with secrets.
4. Logs support operators — they are not a substitute for user-facing errors.

---

## Levels

### `Log::info()`

Use for notable successful lifecycle events that help reconstruct history:

- Admin login success (user id / email only)
- Settings cache rebuilt
- Resume activated
- Background job completed (when jobs exist)

Do **not** info-log every page view or every CRUD read.

### `Log::warning()`

Use for recoverable or suspicious conditions:

- Google OAuth email rejected by allowlist
- Upload rejected after validation edge cases
- External API slow/retry (Outline not applicable here; future APIs)
- Deprecated code path still hit

### `Log::error()`

Use when an operation failed and needs attention:

- Unexpected exceptions caught and handled
- File write/storage failures
- Mail send failures (if added later)
- Data integrity problems detected in code

Prefer letting uncaught exceptions hit Laravel’s exception handler (already logged) rather than double-logging.

### `Log::debug()` / `Log::notice()`

Avoid in production paths. Debug only during local investigation; remove or gate behind `APP_DEBUG` if temporary.

---

## When NOT to log

- Successful routine GET requests
- Every validation failure (user sees the form error)
- Full Eloquent models / large payloads
- Session IDs, CSRF tokens, `Authorization` headers
- Client file contents

---

## Channels & rotation

| Env | Recommendation |
|-----|----------------|
| Local | `LOG_CHANNEL=stack` / `single` or `daily` |
| Production | `LOG_CHANNEL=daily` |

- Laravel `daily` driver rotates by day (`LOG_DAYS`, default often 14).
- Ensure disk space; host-level logrotate may also cover web server logs.
- Do not commit `storage/logs/*.log`.

---

## Production recommendations

1. `APP_DEBUG=false`
2. `LOG_LEVEL=warning` or `error` unless actively investigating
3. Monitor disk usage on `storage/logs`
4. After incidents: rotate credentials if logs may have leaked secrets
5. No CloudWatch/Sentry/etc. unless a future ADR approves a package

---

## Example (style only)

```php
Log::warning('Google allowlist rejected login attempt', [
    'email' => $email,
]);

Log::error('Resume file missing on disk', [
    'resume_id' => $resume->id,
    'path' => $resume->path,
]);
```
