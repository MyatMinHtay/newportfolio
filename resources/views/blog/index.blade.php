@extends('layouts.public')

@section('title', 'Articles & Tutorials — ' . project('site_name', 'Myat Min Htay'))

@section('content')
    <div class="py-4 py-lg-5">
        {{-- Blog Header --}}
        <div class="text-center mb-5">
            <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">Technical Writing</span>
            <h1 class="display-5 fw-bold mb-3" style="color: var(--pf-text);">Articles &amp; Developer Notes</h1>
            <p class="lead text-muted" style="max-width: 640px; margin: 0 auto;">
                Insights on software architecture, Laravel best practices, cloud infrastructure, and lessons learned from production systems.
            </p>

            {{-- Category Filter Pills --}}
            @if($categories->isNotEmpty())
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                    <a href="{{ route('blog.index') }}" class="btn btn-sm {{ !$currentCategory ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
                        All Articles
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="btn btn-sm {{ $currentCategory?->id === $cat->id ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
                            {{ $cat->name }} ({{ $cat->blog_posts_count }})
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Posts Grid --}}
        @if($posts->isEmpty())
            <div class="text-center py-5 my-5">
                <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background-color: var(--pf-surface-muted); color: var(--pf-text-muted);">
                    <i class="bi bi-journal-text fs-2"></i>
                </div>
                <h3 class="h5 fw-bold mb-2">No articles published yet</h3>
                <p class="text-muted">Technical tutorials and software write-ups will be published here soon.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-primary mt-2">
                    <i class="bi bi-arrow-left me-1"></i> Return Home
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm overflow-hidden" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                            @if($post->hasCoverImage())
                                <a href="{{ route('blog.show', $post) }}">
                                    <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}" class="card-img-top" style="height: 190px; object-fit: cover;" loading="lazy">
                                </a>
                            @else
                                <div class="d-flex align-items-center justify-content-center py-4 text-muted" style="background-color: var(--pf-surface-muted); height: 140px; border-bottom: 1px solid var(--pf-border);">
                                    <i class="bi bi-code-slash fs-1 text-primary opacity-50"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    @if($post->category)
                                        <span class="badge" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">
                                            {{ $post->category->name }}
                                        </span>
                                    @else
                                        <span></span>
                                    @endif
                                    <span class="small text-muted">
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}
                                    </span>
                                </div>

                                <h2 class="h5 fw-bold mb-2">
                                    <a href="{{ route('blog.show', $post) }}" class="text-decoration-none" style="color: var(--pf-text);">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <p class="text-muted small mb-4 flex-grow-1">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->body), 120) }}
                                </p>

                                <div class="pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--pf-border) !important;">
                                    <a href="{{ route('blog.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                        Read Article <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
