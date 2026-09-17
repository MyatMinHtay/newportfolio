# 27 — Toast Guidelines

**Purpose:** Global vs inline notification rules. Source ADR: [ADR-016](06-decisions.md#adr-016-toastify-global-notifications).

**Related:** [05-ui-guidelines](05-ui-guidelines.md) · [13-design-system](13-design-system.md) · [22-ui-components](22-ui-components.md) · `config/project.php` → `toast_default_duration`

---

## Dual-channel rule (mandatory)

| Channel | Tool | Use |
|---------|------|-----|
| **Global notification** | Toastify (`public/assets/libs/toast/`) | Cross-page feedback after actions |
| **Inline message** | Bootstrap `<x-alert>` | Contextual page/form notices |

**Never mix both for the same event.**  
Example: after “Project saved”, show a **toast** — do not also flash a success Alert.

---

## Toast types

| Type | When |
|------|------|
| **Success** | Login OK, save OK, delete OK, upload complete, publish OK |
| **Error** | Permission denied (after redirect), unexpected failure, upload failed |
| **Warning** | Soft failures, “saved as draft”, rate-limit near miss (optional) |
| **Info** | Neutral notices (“Copied to clipboard”, “No changes”) |

Default duration: `config('project.toast_default_duration')` (ms). Errors may stay longer when JS is wired later.

---

## Bootstrap Alert usage (inline only)

Allowed:

- Persistent page banners (“Maintenance tonight”)
- Validation **summary** at top of a form (optional; field errors still required)
- Contextual tips on a single screen

Not allowed:

- Login success
- CRUD success/error after redirect
- Permission errors after redirect (prefer toast + 403 page when hard-blocked)

---

## Copy guidelines

- One short sentence
- No emoji spam
- Prefer “Project saved.” over “Your amazing project was successfully saved!!!”
- Do not include secrets or full exception traces

---

## Implementation status

| Item | Status |
|------|--------|
| Toastify CSS/JS in layouts | Done (Phase 0b) |
| JS helper / session→toast bridge | **Done** (session `toast_success` / `toast_error` → Toastify in `app.js`) |
| Duplicate toast libraries | **Forbidden** |

---

## Future wiring (do not invent early)

When implementing:

1. One small vanilla JS helper in `public/assets/js/` (or extend `app.js`)
2. Optional flash keys e.g. `toast_success`, `toast_error` read once in layout
3. Call Toastify with type styling consistent with design tokens

No Livewire toast packages. No SweetAlert unless ADR supersedes this document.
