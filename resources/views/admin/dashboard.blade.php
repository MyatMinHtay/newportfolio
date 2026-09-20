@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Admin', 'url' => route('admin.home')], ['label' => 'Dashboard']]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Dashboard"
        subtitle="Welcome back, {{ Auth::user()->name }}. Complete overview of your portfolio content, blog posts, and inquiries."
    >
        <x-slot:actions>
            <div class="d-flex flex-wrap gap-2">
                <x-button variant="outline-primary" size="sm" :href="route('admin.projects.create')">
                    <i class="bi bi-folder-plus me-1"></i> New case study
                </x-button>
                <x-button variant="outline-primary" size="sm" :href="route('admin.posts.create')">
                    <i class="bi bi-pencil-square me-1"></i> New post
                </x-button>
                <x-button variant="primary" size="sm" :href="route('admin.settings.index')">
                    <i class="bi bi-gear-fill me-1"></i> Settings
                </x-button>
            </div>
        </x-slot:actions>
    </x-layout.page-header>

    <!-- Summary Statistics -->
    <div class="row g-3 mb-4">
        <!-- Projects Card -->
        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Case Studies</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['projects_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary fs-4">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.75rem;">
                        {{ $stats['published_projects_count'] }} Published
                    </span>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.75rem;">
                        {{ $stats['featured_projects_count'] }} Featured
                    </span>
                </div>
            </x-card>
        </div>

        <!-- Blog Posts Card -->
        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Blog Posts</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['posts_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info fs-4">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.75rem;">
                        {{ $stats['published_posts_count'] }} Published
                    </span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25" style="font-size: 0.75rem;">
                        {{ $stats['draft_posts_count'] }} Drafts
                    </span>
                </div>
            </x-card>
        </div>

        <!-- Skills & Services Card -->
        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Skills &amp; Services</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['skills_count'] + $stats['services_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success fs-4">
                        <i class="bi bi-stars"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 pt-2 border-top">
                    <span class="small text-muted">{{ $stats['skills_count'] }} Skills</span>
                    <span class="text-muted">&bull;</span>
                    <span class="small text-muted">{{ $stats['services_count'] }} Services</span>
                    <span class="text-muted">&bull;</span>
                    <span class="small text-muted">{{ $stats['experiences_count'] }} Roles</span>
                </div>
            </x-card>
        </div>

        <!-- Unread Messages Card -->
        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Contact Inbox</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['unread_messages_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning fs-4">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <span class="small text-muted">Unread inquiries</span>
                    <a href="{{ route('admin.messages.index') }}" class="small text-decoration-none fw-semibold">
                        View inbox &rarr;
                    </a>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Active Resume & System Status Alert -->
    <div class="card mb-4 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
        <div class="card-body p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-file-earmark-pdf fs-4"></i>
                </div>
                <div>
                    <div class="fw-semibold small text-uppercase text-muted">Active Public Resume</div>
                    @if($activeResume)
                        <div class="fw-bold">{{ $activeResume->title }}</div>
                    @else
                        <div class="text-warning small"><i class="bi bi-exclamation-triangle me-1"></i>No active resume set for public download</div>
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if($activeResume)
                    <a href="{{ $activeResume->download_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-download me-1"></i> Preview PDF
                    </a>
                @endif
                <a href="{{ route('admin.resumes.index') }}" class="btn btn-sm btn-outline-primary">
                    Manage Resumes
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Left: Recent Case Studies -->
        <div class="col-lg-7">
            <x-card title="Recent case studies" class="shadow-sm h-100">
                <x-slot:actions>
                    <a href="{{ route('admin.projects.index') }}" class="small text-decoration-none fw-semibold">
                        View all ({{ $stats['projects_count'] }}) &rarr;
                    </a>
                </x-slot:actions>

                @if ($recentProjects->isEmpty())
                    <x-empty-state
                        icon="bi-folder"
                        title="No case studies yet"
                        description="Add a project to start writing case studies."
                        action-label="New case study"
                        :action-url="route('admin.projects.create')"
                    />
                @else
                    {{-- Mobile List (< 576px) --}}
                    <div class="d-sm-none">
                        @foreach ($recentProjects as $project)
                            <div class="py-2 border-bottom d-flex align-items-center justify-content-between gap-2">
                                <div class="text-truncate">
                                    <div class="fw-semibold text-truncate small">{{ $project->title }}</div>
                                    <div class="d-flex align-items-center gap-1 mt-1">
                                        @if ($project->is_published)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.65rem;">Published</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25" style="font-size: 0.65rem;">Hidden</span>
                                        @endif
                                        @if ($project->is_featured)
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.65rem;">Featured</span>
                                        @endif
                                    </div>
                                </div>
                                <x-button variant="outline-primary" size="sm" class="py-0 px-2 flex-shrink-0" :href="route('admin.projects.edit', $project)">
                                    Edit
                                </x-button>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop Table (>= 576px) --}}
                    <div class="table-responsive d-none d-sm-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentProjects as $project)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $project->title }}</span>
                                            <div class="small text-muted text-truncate" style="max-width: 280px;">
                                                {{ $project->summary }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($project->is_published)
                                                <x-badge variant="success">Published</x-badge>
                                            @else
                                                <x-badge variant="secondary">Hidden</x-badge>
                                            @endif
                                            @if ($project->is_featured)
                                                <x-badge variant="primary">Featured</x-badge>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <x-button variant="outline-primary" size="sm" :href="route('admin.projects.edit', $project)">
                                                Edit
                                            </x-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Right: Recent Blog Posts & Inquiries -->
        <div class="col-lg-5 d-flex flex-column gap-4">
            <!-- Recent Blog Posts -->
            <x-card title="Recent blog posts" class="shadow-sm">
                <x-slot:actions>
                    <a href="{{ route('admin.posts.index') }}" class="small text-decoration-none fw-semibold">
                        View all ({{ $stats['posts_count'] }}) &rarr;
                    </a>
                </x-slot:actions>

                @if ($recentPosts->isEmpty())
                    <x-empty-state
                        icon="bi-journal-text"
                        title="No blog posts yet"
                        description="Write your first technical article or dev note."
                        action-label="New post"
                        :action-url="route('admin.posts.create')"
                    />
                @else
                    <ul class="list-group list-group-flush mb-0">
                        @foreach ($recentPosts as $post)
                            <li class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                <div class="me-3 text-truncate">
                                    <div class="fw-semibold text-truncate" style="max-width: 250px;">{{ $post->title }}</div>
                                    <div class="small text-muted">
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                                        @if($post->category)
                                            &bull; {{ $post->category->name }}
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if($post->is_published)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Live</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">Draft</span>
                                    @endif
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                        Edit
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-card>

            <!-- Recent Inquiries -->
            <x-card title="Recent inquiries" class="shadow-sm">
                <x-slot:actions>
                    <a href="{{ route('admin.messages.index') }}" class="small text-decoration-none fw-semibold">
                        Inbox &rarr;
                    </a>
                </x-slot:actions>

                @if ($recentMessages->isEmpty())
                    <x-empty-state
                        icon="bi-inbox"
                        title="No messages yet"
                        description="Customer inquiries through the contact form will appear here."
                    />
                @else
                    <ul class="list-group list-group-flush mb-0">
                        @foreach ($recentMessages as $msg)
                            <li class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                <div class="me-3 text-truncate">
                                    <div class="fw-semibold d-flex align-items-center gap-2">
                                        @if(!$msg->is_read)
                                            <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">New</span>
                                        @endif
                                        <span class="text-truncate" style="max-width: 200px;">{{ $msg->name }}</span>
                                    </div>
                                    <div class="small text-muted text-truncate" style="max-width: 250px;">
                                        {{ $msg->subject ?: Str::limit($msg->message, 40) }}
                                    </div>
                                </div>
                                <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-card>
        </div>
    </div>
@endsection
