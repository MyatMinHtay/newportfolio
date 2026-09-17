@props([
    'code',
    'title',
    'message',
])

<div class="row justify-content-center py-5">
    <div class="col-md-7 col-lg-6">
        <div class="pf-surface p-4 text-center">
            <p class="text-muted small mb-2">Error {{ $code }}</p>
            <h1 class="h3 mb-3">{{ $title }}</h1>
            <p class="text-muted mb-4">{{ $message }}</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
        </div>
    </div>
</div>
