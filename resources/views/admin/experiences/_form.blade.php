<div class="row g-3">
    <div class="col-md-6">
        <x-form.input
            name="role"
            label="Role / Position"
            :value="$experience->role ?? null"
            placeholder="e.g. Full Stack Web Developer"
            required
        />
    </div>
    <div class="col-md-6">
        <x-form.input
            name="company"
            label="Company / Client"
            :value="$experience->company ?? null"
            placeholder="e.g. MorningStar Translation MM, Freelance"
            required
        />
    </div>
</div>

<x-form.input
    name="location"
    label="Location"
    :value="$experience->location ?? null"
    placeholder="e.g. Mandalay, Myanmar or Remote"
/>

<div class="row g-3">
    <div class="col-md-6">
        <x-form.input
            name="start_date"
            label="Start Date"
            type="date"
            :value="isset($experience->start_date) ? $experience->start_date->format('Y-m-d') : null"
            required
        />
    </div>
    <div class="col-md-6">
        <x-form.input
            name="end_date"
            label="End Date"
            type="date"
            :value="isset($experience->end_date) && $experience->end_date ? $experience->end_date->format('Y-m-d') : null"
            help="Leave blank if currently working here (displays as 'Present')."
        />
    </div>
</div>

<x-form.textarea
    name="description"
    label="Description &amp; Achievements (Markdown)"
    :value="$experience->description ?? null"
    :rows="5"
    help="Brief overview of responsibilities, technologies used, and outcomes."
/>

<div class="row g-3">
    <div class="col-md-6">
        <x-form.input
            name="sort_order"
            label="Sort order"
            type="number"
            :value="$experience->sort_order ?? 0"
            min="0"
        />
    </div>
    <div class="col-md-6 d-flex align-items-center">
        <x-form.checkbox
            name="is_published"
            label="Published on homepage timeline"
            :checked="old('is_published', $experience->is_published ?? true)"
        />
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <x-button variant="primary" type="submit">Save experience</x-button>
    <x-button variant="outline-secondary" :href="route('admin.experiences.index')">Cancel</x-button>
</div>
