@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Admin', 'url' => route('admin.home')], ['label' => 'Dashboard']]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Dashboard"
        subtitle="Welcome back, {{ Auth::user()->name }}. Manage case studies, skills, and services."
    />

    <!-- Summary Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Case Studies</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['projects_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary fs-4">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Skills</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['skills_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success fs-4">
                        <i class="bi bi-stars"></i>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Services</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['services_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info fs-4">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-sm-6 col-lg-3">
            <x-card class="h-100 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Unread Messages</span>
                        <h2 class="h3 fw-bold mb-0 mt-1">{{ $stats['unread_messages_count'] }}</h2>
                    </div>
                    <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning fs-4">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Recent case studies -->
    <x-card title="Recent case studies" class="shadow-sm">
        @if ($recentProjects->isEmpty())
            <x-empty-state
                icon="bi-folder"
                title="No case studies yet"
                description="Add a project to start writing case studies."
                action-label="New case study"
                :action-url="route('admin.projects.create')"
            />
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px;">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Tech Stack</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentProjects as $project)
                            <tr>
                                <td>{{ $project->sort_order }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $project->title }}</span>
                                    <div class="small text-muted text-truncate" style="max-width: 350px;">
                                        {{ $project->summary }}
                                    </div>
                                </td>
                                <td>
                                    @if ($project->tech_stack)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($project->tech_stack as $tech)
                                                <x-badge variant="secondary">{{ $tech }}</x-badge>
                                            @endforeach
                                        </div>
                                    @endif
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
                                <td>
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
@endsection
