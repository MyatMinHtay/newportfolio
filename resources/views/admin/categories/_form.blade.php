<x-form.input
    name="name"
    label="Category Name"
    :value="$category->name ?? null"
    placeholder="e.g. Web Development, Laravel, Architecture"
    required
/>

<x-form.input
    name="slug"
    label="Slug (optional)"
    :value="$category->slug ?? null"
    help="Leave blank to automatically generate from name."
/>

<div class="d-flex gap-2 mt-4">
    <x-button variant="primary" type="submit">Save category</x-button>
    <x-button variant="outline-secondary" :href="route('admin.categories.index')">Cancel</x-button>
</div>
