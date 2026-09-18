@extends('layouts.public')

@section('title', $post->title . ' — ' . project('site_name', 'Myat Min Htay'))

@section('content')
    <div class="py-4 py-lg-5">
        {{-- Breadcrumbs & Back Nav --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none">Blog</a></li>
                    <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 260px;">{{ $post->title }}</li>
                </ol>
            </nav>

            <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> All Articles
            </a>
        </div>

        {{-- Post Header --}}
        <header class="mb-5 pb-3 border-bottom text-center" style="border-color: var(--pf-border) !important;">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                @if($post->category)
                    <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="badge text-decoration-none px-3 py-1" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">
                        {{ $post->category->name }}
                    </a>
                @endif
                <span class="small text-muted">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $post->published_at ? $post->published_at->format('F d, Y') : 'Draft' }}
                </span>
            </div>

            <h1 class="display-5 fw-bolder mb-3" style="color: var(--pf-text); max-width: 860px; margin: 0 auto;">
                {{ $post->title }}
            </h1>

            @if($post->excerpt)
                <p class="lead text-muted mb-0" style="max-width: 720px; margin: 0 auto;">
                    {{ $post->excerpt }}
                </p>
            @endif
        </header>

        {{-- Post Cover Image --}}
        @if($post->hasCoverImage())
            <div class="mb-5 text-center" style="max-width: 860px; margin: 0 auto;">
                <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 480px; width: 100%; object-fit: cover; border: 1px solid var(--pf-border);">
            </div>
        @endif

        {{-- Post Content & Sidebar --}}
        <div class="row g-5 justify-content-center">
            <div class="col-lg-8">
                <article class="pf-prose mb-5">
                    {!! $post->rendered_body !!}
                </article>

                {{-- Author & Share Card --}}
                <div class="card p-4 border-0 shadow-sm my-5" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/img/profile.png') }}" alt="Author" class="rounded-circle" style="width: 54px; height: 54px; object-fit: cover; border: 2px solid var(--pf-primary);">
                        <div>
                            <div class="fw-bold" style="color: var(--pf-text);">Written by {{ project('site_name', 'Myat Min Htay') }}</div>
                            <div class="text-muted small">Full Stack Laravel Developer crafting reliable web systems and product tools.</div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-top d-flex align-items-center justify-content-between" style="border-color: var(--pf-border) !important;">
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to all articles
                    </a>
                    <a href="{{ route('home') }}#contact" class="btn btn-primary">
                        <i class="bi bi-envelope me-1"></i> Contact author
                    </a>
                </div>
            </div>

            {{-- Recent Posts Sidebar --}}
            @if(!empty($recentPosts) && $recentPosts->isNotEmpty())
                <div class="col-lg-4">
                    <div class="card p-4 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                        <h2 class="h6 fw-bold text-uppercase tracking-wider mb-3" style="color: var(--pf-primary);">
                            Recent Articles
                        </h2>

                        <div class="d-flex flex-column gap-3">
                            @foreach($recentPosts as $recent)
                                <a href="{{ route('blog.show', $recent) }}" class="text-decoration-none group d-block p-2 rounded" style="transition: background-color var(--pf-duration);">
                                    <div class="fw-semibold small" style="color: var(--pf-text);">{{ $recent->title }}</div>
                                    <div class="text-muted small">{{ $recent->published_at ? $recent->published_at->format('M d, Y') : '' }}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
