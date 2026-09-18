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
        <label for="category_id" class="form-label fw-semibold">Category</label>
        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">(No Category)</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? null) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
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
