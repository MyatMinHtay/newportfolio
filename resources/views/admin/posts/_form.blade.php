<div class="row g-3">
    <div class="col-md-8">
        <x-form.input
            name="title"
            label="Post Title"
            :value="$post->title ?? null"
            placeholder="e.g. Building Scalable Laravel Architectures with Docker"
            required
        />
    </div>
    <div class="col-md-4">
        @php
            $selectedCategoryIds = array_map('intval', (array) old('category_ids', $post?->categories?->pluck('id')->all() ?? []));
        @endphp
        <span class="form-label fw-semibold d-block">Categories</span>
        <div class="border rounded p-2 @error('category_ids') border-danger @enderror @error('category_ids.*') border-danger @enderror" style="max-height: 180px; overflow: auto;">
            @forelse($categories as $category)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="category_ids[]"
                        id="category_{{ $category->id }}"
                        value="{{ $category->id }}"
                        @checked(in_array($category->id, $selectedCategoryIds, true))
                    >
                    <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @empty
                <p class="small text-muted mb-0">No categories yet. Create one under Categories first.</p>
            @endforelse
        </div>
        <div class="form-text">Select one or more. Leave all unchecked for no category.</div>
        @error('category_ids')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        @error('category_ids.*')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<x-form.input
    name="slug"
    label="Slug (optional)"
    :value="$post->slug ?? null"
    help="Leave blank to automatically generate from title."
/>

<x-form.textarea
    name="excerpt"
    label="Excerpt / Brief summary"
    :value="$post->excerpt ?? null"
    :rows="2"
    help="Used in article preview cards and meta descriptions."
/>

<div class="mb-3">
    <label for="cover_image" class="form-label fw-semibold">
        Cover Image {{ isset($post) && $post->hasCoverImage() ? '(Leave empty to keep current)' : '' }}
    </label>
    <input
        type="file"
        class="form-control @error('cover_image') is-invalid @enderror"
        id="cover_image"
        name="cover_image"
        accept="image/*"
    >
    @error('cover_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($post) && $post->hasCoverImage())
        <div class="mt-2">
            <img src="{{ $post->cover_image_url }}" alt="Cover" class="img-thumbnail" style="max-height: 120px;">
        </div>
    @endif
</div>

<x-form.textarea
    name="body"
    label="Article Content (Markdown)"
    :value="$post->body ?? null"
    :rows="12"
    required
    help="Supports standard Markdown formatting: headings (#, ##), code blocks (```), bullet lists, and links."
/>

<div class="row g-3 align-items-center mb-4">
    <div class="col-md-6">
        <x-form.input
            name="published_at"
            label="Publish Date"
            type="datetime-local"
            :value="isset($post->published_at) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : null"
            help="Defaults to current timestamp if left empty upon publishing."
        />
    </div>
    <div class="col-md-6 pt-md-2">
        <x-form.checkbox
            name="is_published"
            label="Published publicly"
            :checked="old('is_published', $post->is_published ?? false)"
        />
    </div>
</div>

<div class="d-flex gap-2">
    <x-button variant="primary" type="submit">
        <i class="bi bi-check-lg me-1"></i> Save post
    </x-button>
    <x-button variant="outline-secondary" :href="route('admin.posts.index')">Cancel</x-button>
</div>
