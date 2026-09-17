@php
    $categories = [
        'Backend' => 'Backend',
        'Frontend' => 'Frontend',
        'Database' => 'Database',
        'Tools' => 'Tools',
        'Cloud' => 'Cloud',
    ];
    $currentCategory = old('category', $skill->category ?? 'Backend');
    if ($currentCategory && ! array_key_exists($currentCategory, $categories)) {
        $categories[$currentCategory] = $currentCategory;
    }
@endphp

<div class="row">
    <div class="col-lg-8">
        <x-form.input name="name" label="Name" :value="$skill->name ?? null" required />
        <x-form.select name="category" label="Category" :options="$categories" :selected="$currentCategory" required />
        <x-form.select
            name="proficiency"
            label="Proficiency"
            :options="[1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5']"
            :selected="old('proficiency', $skill->proficiency ?? 4)"
            placeholder="Optional"
        />
        <x-form.input name="sort_order" label="Sort order" type="number" :value="$skill->sort_order ?? 0" min="0" />
        <x-form.checkbox name="is_published" label="Published on homepage" :checked="old('is_published', $skill->is_published ?? true)" />
    </div>
    <div class="col-lg-4">
        <x-form.input
            name="icon"
            label="Icon image"
            type="file"
            accept="image/jpeg,image/png,image/webp"
            help="Optional. JPG, PNG, or WebP. Max {{ project('upload_limits.image_max_kb', 2048) }} KB."
        />

        @if ($skill)
            <div class="mb-3">
                <div class="small text-muted mb-2">Current icon</div>
                <img src="{{ $skill->icon_url }}" alt="{{ $skill->name }}" width="64" height="64" class="rounded border p-2 bg-body-secondary" style="object-fit: contain;">
            </div>
        @endif
    </div>
</div>

<div class="d-flex gap-2">
    <x-button variant="primary" type="submit">Save skill</x-button>
    <x-button variant="outline-secondary" :href="route('admin.skills.index')">Cancel</x-button>
</div>
