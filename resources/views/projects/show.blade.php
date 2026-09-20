@extends('layouts.public')

@section('title', $project->title . ' — Case Study')
@section('meta_description', $project->summary ?: \Illuminate\Support\Str::limit(strip_tags($project->rendered_body), 160))
@if($project->cover_image_url)
    @section('og_image', $project->cover_image_url)
@endif
@section('og_type', 'article')
@if(!empty($project->tech_stack))
    @section('meta_keywords', implode(', ', $project->tech_stack) . ', Case Study, ' . \App\Models\Setting::get('meta_keywords', ''))
@endif

@section('content')
    <div class="py-4 py-lg-5">
        {{-- Breadcrumb & Back navigation --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}#projects" class="text-decoration-none">Projects</a></li>
                    <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 260px;">{{ $project->title }}</li>
                </ol>
            </nav>

            <a href="{{ route('home') }}#projects" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to projects
            </a>
        </div>

        {{-- Case Study Hero Header --}}
        <header class="mb-5 pb-3 border-bottom" style="border-color: var(--pf-border) !important;">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="badge px-3 py-1" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">
                    {{ $project->engagementLabel() }}
                </span>
                @if($project->isPreview())
                    <span class="badge px-3 py-1" style="background-color: var(--pf-accent-subtle); color: var(--pf-accent);">
                        Preview
                    </span>
                @endif
                @if($project->started_at)
                    <span class="small text-muted ms-2">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $project->started_at->format('M Y') }}
                        @if($project->ended_at)
                            — {{ $project->ended_at->format('M Y') }}
                        @else
                            — Present
                        @endif
                    </span>
                @endif
            </div>

            <h1 class="display-5 fw-bolder mb-3" style="color: var(--pf-text);">{{ $project->title }}</h1>

            <p class="lead text-muted mb-4" style="max-width: 780px;">
                {{ $project->summary }}
            </p>

            {{-- Tech Stack Tags & Actions --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                @if(!empty($project->tech_stack) && is_array($project->tech_stack))
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        @foreach($project->tech_stack as $tech)
                            <span class="pf-tech-pill">{{ $tech }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if($project->project_url)
                        <a
                            href="{{ $project->isExternalUrl() ? $project->project_url : url($project->project_url) }}"
                            class="btn btn-primary px-3 py-2"
                            @if($project->isExternalUrl()) target="_blank" rel="noopener noreferrer" @endif
                        >
                            <i class="bi bi-box-arrow-up-right me-1"></i>
                            {{ $project->isPreview() ? 'Visit Preview' : ($project->isExternalUrl() ? 'Live Platform' : 'View System') }}
                        </a>
                    @endif

                    @if($project->repo_url)
                        <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary px-3 py-2">
                            <i class="bi bi-github me-1"></i> Source Code
                        </a>
                    @endif

                    @if($project->embed_url)
                        <button type="button" class="btn btn-outline-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#projectVideoModal" data-video-url="{{ $project->embed_url }}" data-project-title="{{ $project->title }}">
                            <i class="bi bi-play-circle me-1"></i> Video Demo
                        </button>
                    @endif
                </div>
            </div>
        </header>

        {{-- Cover Image / Media Banner --}}
        @if($project->hasCoverImage())
            <div class="mb-5 text-center">
                <img src="{{ $project->cover_image_url }}" alt="{{ $project->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 520px; width: 100%; object-fit: cover; border: 1px solid var(--pf-border);">
            </div>
        @endif

        {{-- Main Case Study Body --}}
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="pf-prose mb-5">
                    @if(filled($project->body))
                        {!! $project->rendered_body !!}
                    @else
                        <div class="p-4 rounded-3 text-muted" style="background-color: var(--pf-surface-muted); border: 1px solid var(--pf-border);">
                            <p class="mb-0 italic">A detailed technical case study for this project is currently being written. Check back soon or visit the live link above.</p>
                        </div>
                    @endif
                </article>

                @if($project->hasGallery())
                    <section class="mb-5 pt-4 border-top" style="border-color: var(--pf-border) !important;">
                        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                            <div>
                                <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">
                                    Visual Showcase
                                </span>
                                <h2 class="h4 fw-bold mb-1" style="color: var(--pf-text);">Media &amp; Screenshots</h2>
                                <p class="text-muted small mb-0">Click any screenshot to view in full resolution.</p>
                            </div>
                            <span class="badge rounded-pill text-muted px-3 py-2 border" style="background-color: var(--pf-surface-muted); border-color: var(--pf-border) !important;">
                                <i class="bi bi-images me-1"></i> {{ count($project->gallery) }} {{ \Illuminate\Support\Str::plural('image', count($project->gallery)) }}
                            </span>
                        </div>

                        <div class="row g-3">
                            @foreach($project->gallery_urls as $idx => $mediaUrl)
                                <div class="col-sm-6">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important; border-radius: var(--pf-radius-md);">
                                        <a href="javascript:void(0)"
                                           class="d-block overflow-hidden position-relative project-gallery-trigger"
                                           data-bs-toggle="modal"
                                           data-bs-target="#projectGalleryModal"
                                           data-image-src="{{ $mediaUrl }}"
                                           data-image-title="{{ $project->title }} — Screenshot {{ $idx + 1 }}"
                                           style="cursor: pointer; aspect-ratio: 16/10;">
                                            <img src="{{ $mediaUrl }}"
                                                 alt="{{ $project->title }} Screenshot {{ $idx + 1 }}"
                                                 class="w-100 h-100 object-fit-cover"
                                                 loading="lazy"
                                                 style="transition: transform var(--pf-duration) var(--pf-ease);">
                                            <div class="position-absolute inset-0 d-flex align-items-center justify-content-center bg-dark bg-opacity-25 opacity-0 gallery-hover-overlay"
                                                 style="transition: opacity var(--pf-duration) var(--pf-ease); inset: 0;">
                                                <span class="btn btn-sm btn-light rounded-pill shadow-sm px-3">
                                                    <i class="bi bi-zoom-in me-1"></i> Preview
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <div class="pt-4 border-top d-flex align-items-center justify-content-between" style="border-color: var(--pf-border) !important;">
                    <a href="{{ route('home') }}#projects" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to all projects
                    </a>
                    <a href="{{ route('home') }}#contact" class="btn btn-primary">
                        <i class="bi bi-envelope me-1"></i> Inquire about similar project
                    </a>
                </div>
            </div>

            {{-- Sidebar with metadata and other projects --}}
            <div class="col-lg-4">
                <div class="card p-4 border-0 shadow-sm mb-4" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                    <h2 class="h6 fw-bold text-uppercase tracking-wider mb-3" style="color: var(--pf-primary);">
                        Project Metadata
                    </h2>

                    <dl class="mb-0 small">
                        <dt class="text-muted fw-normal">Project Scope</dt>
                        <dd class="fw-semibold mb-3" style="color: var(--pf-text);">{{ $project->engagementLabel() }}</dd>

                        <dt class="text-muted fw-normal">Status</dt>
                        <dd class="fw-semibold mb-3" style="color: var(--pf-text);">
                            @if($project->isPreview())
                                Experimental Preview
                            @elseif($project->is_published)
                                Active / Shipped
                            @else
                                Draft
                            @endif
                        </dd>

                        @if($project->project_url)
                            <dt class="text-muted fw-normal">Website</dt>
                            <dd class="text-truncate mb-3">
                                <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="text-primary text-decoration-none">
                                    {{ $project->project_url }}
                                </a>
                            </dd>
                        @endif

                        <dt class="text-muted fw-normal">Core Technology</dt>
                        <dd class="mb-0" style="color: var(--pf-text);">
                            {{ is_array($project->tech_stack) ? implode(', ', array_slice($project->tech_stack, 0, 4)) : 'Laravel' }}
                        </dd>
                    </dl>
                </div>

                @if(!empty($otherProjects) && $otherProjects->isNotEmpty())
                    <div class="card p-4 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                        <h2 class="h6 fw-bold text-uppercase tracking-wider mb-3" style="color: var(--pf-text);">
                            Other Case Studies
                        </h2>

                        <div class="d-flex flex-column gap-3">
                            @foreach($otherProjects as $other)
                                <a href="{{ route('projects.show', $other) }}" class="text-decoration-none group d-block p-2 rounded" style="transition: background-color var(--pf-duration);">
                                    <div class="fw-semibold small" style="color: var(--pf-text);">{{ $other->title }}</div>
                                    <div class="text-muted small text-truncate">{{ $other->summary }}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Video Modal if demo is available --}}
    @if($project->embed_url)
        <div class="modal fade" id="projectVideoModal" tabindex="-1" aria-labelledby="projectVideoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-2 px-3">
                        <h2 class="modal-title fs-6 fw-bold" id="projectVideoModalLabel">{{ $project->title }} — Video Demo</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $project->embed_url }}" title="{{ $project->title }}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Gallery Lightbox Modal --}}
    @if($project->hasGallery())
        <div class="modal fade" id="projectGalleryModal" tabindex="-1" aria-labelledby="projectGalleryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content border-0 shadow-lg" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                    <div class="modal-header py-3 px-4 border-bottom" style="border-color: var(--pf-border) !important;">
                        <h2 class="modal-title fs-6 fw-bold mb-0" id="projectGalleryModalLabel" style="color: var(--pf-text);">Screenshot Preview</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-2 p-md-3 text-center d-flex align-items-center justify-content-center" style="min-height: 320px; background-color: var(--pf-surface-muted);">
                        <img id="projectGalleryModalImage" src="" alt="Full Screenshot Preview" class="img-fluid rounded shadow-sm" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const galleryModal = document.getElementById('projectGalleryModal');
                if (galleryModal) {
                    const modalImg = document.getElementById('projectGalleryModalImage');
                    const modalTitle = document.getElementById('projectGalleryModalLabel');

                    galleryModal.addEventListener('show.bs.modal', function (event) {
                        const trigger = event.relatedTarget;
                        if (trigger) {
                            const src = trigger.getAttribute('data-image-src');
                            const title = trigger.getAttribute('data-image-title') || 'Screenshot Preview';
                            if (modalImg && src) {
                                modalImg.src = src;
                            }
                            if (modalTitle) {
                                modalTitle.textContent = title;
                            }
                        }
                    });

                    galleryModal.addEventListener('hidden.bs.modal', function () {
                        if (modalImg) {
                            modalImg.src = '';
                        }
                    });
                }
            });
        </script>
    @endif
@endsection
