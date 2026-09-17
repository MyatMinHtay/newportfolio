# 25 — Validation

**Purpose:** How input is validated. **No Form Request code in this phase** — conventions only.

**Related:** [04-coding-style](04-coding-style.md) · [14-security](14-security.md) · [24-file-storage](24-file-storage.md) · [27-toast-guidelines](27-toast-guidelines.md)

---

## Form Request usage

1. **Every write** (create/update/delete with body) uses a Form Request.
2. Namespaces:
   - Admin → `App\Http\Requests\Admin\`
   - Auth → `App\Http\Requests\Auth\`
   - Public (contact) → `App\Http\Requests\`
3. Controllers must **not** duplicate `$request->validate([...])` when a Form Request exists.
4. Authorization: prefer middleware for admin gate; Form Request `authorize()` returns `true` or checks ownership when needed.

---

## Validation message style

- Prefer Laravel defaults; customize only when UX needs clearer wording.
- Field-level errors render under inputs via `<x-form.*>` (`is-invalid` + feedback).
- Summary list allowed via `<x-layout.flash>` (inline Alert).
- **Global** “validation failed” toasts (Toastify) are optional later — never replace field errors.

Tone: short, plain English. No blamey copy.

---

## Custom rules

- Prefer built-in rules (`required`, `email`, `unique`, `exists`, `date`, `boolean`, `array`).
- Extract a custom `Rule` class only when reused ≥ 2 places.
- Do not invent a validation “framework.”

---

## File validation

Align with `config('project.upload_limits')` and [24-file-storage](24-file-storage.md):

```text
images:  mimes:jpg,jpeg,png,webp | max:{image_max_kb}
resume:  mimes:pdf               | max:{pdf_max_kb}
```

- Always validate mime **and** max size.
- Never trust client extension alone.

---

## Image validation

- Same as file rules for covers/profile.
- Optional later: dimensions (`dimensions:max_width=…`) after resize strategy ADR.
- Store UUID filename after validation passes.

---

## Slugs & uniqueness

- `alpha_dash` (or `slug` pattern) + `unique:table,slug,{id}`
- Generate from title in controller/model observer later — still validate uniqueness.

---

## What not to do

- Validate in Blade
- Silent `$request->all()` into models
- Skip validation on “trusted” admin forms
- Put business workflows inside Form Requests (keep them rules + messages)
