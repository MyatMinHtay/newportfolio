@php
    $techValue = old(
        'tech_stack',
        $project ? implode(', ', $project->tech_stack ?? []) : ''
    );
@endphp

<div class="row">
    <div class="col-lg-8">
        <x-form.input name="title" label="Title" :value="$project->title ?? null" required />
        <x-form.input name="slug" label="Slug" :value="$project->slug ?? null" help="Leave blank to generate from the title. Letters, numbers, and dashes only." />
        <x-form.textarea name="summary" label="Summary" :value="$project->summary ?? null" :rows="3" required help="Short homepage blurb." />
        <x-form.textarea name="body" label="Case study body (Markdown)" :value="$project->body ?? null" :rows="12" help="Stored now. Public case-study pages come later." />
        <x-form.textarea name="tech_stack" label="Tech stack" :value="$techValue" :rows="2" help="Comma-separated, e.g. Laravel 12, MySQL, Bootstrap 5." />
    </div>
    <div class="col-lg-4">
        <x-form.input name="cover_image" label="Cover image" type="file" accept="image/jpeg,image/png,image/webp" help="JPG, PNG, or WebP. Max {{ project('upload_limits.image_max_kb', 2048) }} KB." />

        @if ($project?->hasCoverImage())
            <div class="mb-3">
                <img src="{{ $project->cover_image_url }}" alt="Current cover" class="img-fluid rounded border" style="max-height: 140px;">
            </div>
        @endif

        <x-form.input name="project_url" label="Live URL" :value="$project->project_url ?? null" help="Full URL or / for this site." />
        <x-form.input name="repo_url" label="Repo URL" :value="$project->repo_url ?? null" />
        <x-form.input name="video_url" label="Video URL" :value="$project->video_url ?? null" />
        <x-form.input name="sort_order" label="Sort order" type="number" :value="$project->sort_order ?? 0" min="0" />
        <x-form.input name="started_at" label="Started" type="date" :value="optional($project)->started_at?->format('Y-m-d')" />
        <x-form.input name="ended_at" label="Ended" type="date" :value="optional($project)->ended_at?->format('Y-m-d')" />
        <x-form.checkbox name="is_published" label="Published on homepage" :checked="old('is_published', $project->is_published ?? true)" />
        <x-form.checkbox name="is_featured" label="Featured" :checked="old('is_featured', $project->is_featured ?? false)" />
    </div>
</div>

<div class="d-flex gap-2">
    <x-button variant="primary" type="submit">Save case study</x-button>
    <x-button variant="outline-secondary" :href="route('admin.projects.index')">Cancel</x-button>
</div>
