<x-form.input
    name="title"
    label="Resume Title / Label"
    :value="$resume->title ?? null"
    placeholder="e.g. Full Stack Developer Resume (2026)"
    required
    help="Descriptive title to easily identify versions."
/>

<div class="mb-3">
    <label for="resume_file" class="form-label fw-semibold">
        PDF Document {{ isset($resume) ? '(Leave empty to keep current)' : '' }}
        @if(!isset($resume)) <span class="text-danger">*</span> @endif
    </label>
    <input
        type="file"
        class="form-control @error('resume_file') is-invalid @enderror"
        id="resume_file"
        name="resume_file"
        accept="application/pdf"
        @if(!isset($resume)) required @endif
    >
    @error('resume_file')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">PDF format only. Maximum size: {{ (int) (config('project.upload_limits.pdf_max_kb', 5120) / 1024) }} MB.</div>

    @if(isset($resume) && $resume->file_path)
        <div class="mt-2 small">
            <span class="text-muted">Current file:</span>
            <a href="{{ $resume->file_url }}" target="_blank" class="ms-1 fw-medium text-primary">
                <i class="bi bi-file-earmark-pdf me-1"></i> View / Download
            </a>
        </div>
    @endif
</div>

<div class="mb-4">
    <x-form.checkbox
        name="is_active"
        label="Set as Active Resume"
        :checked="old('is_active', $resume->is_active ?? true)"
        help="Activating this will automatically deactivate any previously active resume."
    />
</div>

<div class="d-flex gap-2">
    <x-button variant="primary" type="submit">
        <i class="bi bi-upload me-1"></i> {{ isset($resume) ? 'Update resume' : 'Upload resume' }}
    </x-button>
    <x-button variant="outline-secondary" :href="route('admin.resumes.index')">Cancel</x-button>
</div>
