<x-form.input
    name="label"
    label="Platform / Label"
    :value="$socialLink->label ?? null"
    placeholder="e.g. GitHub, LinkedIn, Telegram"
    required
/>

<x-form.input
    name="url"
    label="Profile / Destination URL"
    type="url"
    :value="$socialLink->url ?? null"
    placeholder="https://..."
    required
/>

<x-form.input
    name="icon"
    label="Bootstrap Icon class"
    :value="$socialLink->icon ?? 'bi-link'"
    required
    help="Example: bi-github, bi-linkedin, bi-telegram, bi-envelope-fill, bi-facebook."
/>

<x-form.input
    name="sort_order"
    label="Sort order"
    type="number"
    :value="$socialLink->sort_order ?? 0"
    min="0"
/>

<x-form.checkbox
    name="is_published"
    label="Visible on public website"
    :checked="old('is_published', $socialLink->is_published ?? true)"
/>

<div class="d-flex gap-2">
    <x-button variant="primary" type="submit">Save link</x-button>
    <x-button variant="outline-secondary" :href="route('admin.social-links.index')">Cancel</x-button>
</div>
