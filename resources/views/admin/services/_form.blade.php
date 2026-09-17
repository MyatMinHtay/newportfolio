<x-form.input name="title" label="Title" :value="$service->title ?? null" required />
<x-form.textarea name="summary" label="Summary" :value="$service->summary ?? null" :rows="4" required />
<x-form.input
    name="icon"
    label="Bootstrap Icon class"
    :value="$service->icon ?? 'bi-layers'"
    required
    help="Example: bi-layers, bi-shield-lock, bi-cloud-arrow-up."
/>
<x-form.input name="sort_order" label="Sort order" type="number" :value="$service->sort_order ?? 0" min="0" />
<x-form.checkbox name="is_published" label="Published on homepage" :checked="old('is_published', $service->is_published ?? true)" />

<div class="d-flex gap-2">
    <x-button variant="primary" type="submit">Save service</x-button>
    <x-button variant="outline-secondary" :href="route('admin.services.index')">Cancel</x-button>
</div>
