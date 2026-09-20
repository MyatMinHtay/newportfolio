@extends('layouts.admin')

@section('title', 'Case Studies')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Admin', 'url' => route('admin.home')], ['label' => 'Case Studies']]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Case Studies"
        subtitle="Project write-ups shown on the homepage. Public case-study pages come later."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.projects.create')">
                <i class="bi bi-plus-lg me-1"></i> New case study
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    {{-- Status Filter Tabs --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm {{ empty($status) ? 'btn-primary' : 'btn-outline-secondary' }}">
            All ({{ $counts['all'] ?? $projects->total() }})
        </a>
        <a href="{{ route('admin.projects.index', ['status' => 'published']) }}" class="btn btn-sm {{ ($status ?? '') === 'published' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Published ({{ $counts['published'] ?? 0 }})
        </a>
        <a href="{{ route('admin.projects.index', ['status' => 'hidden']) }}" class="btn btn-sm {{ ($status ?? '') === 'hidden' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Hidden ({{ $counts['hidden'] ?? 0 }})
        </a>
        <a href="{{ route('admin.projects.index', ['status' => 'featured']) }}" class="btn btn-sm {{ ($status ?? '') === 'featured' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Featured ({{ $counts['featured'] ?? 0 }})
        </a>
    </div>

    <x-card class="shadow-sm overflow-hidden">
        @if ($projects->isEmpty())
            <x-empty-state
                icon="bi-folder"
                title="No case studies found"
                description="{{ !empty($status) ? 'No case studies match the selected status filter.' : 'Add a project to publish it on the homepage.' }}"
                action-label="{{ !empty($status) ? 'Clear filter' : 'New case study' }}"
                :action-url="!empty($status) ? route('admin.projects.index') : route('admin.projects.create')"
            />
        @else
            {{-- Mobile List View (< 768px) --}}
            <div class="d-md-none">
                @foreach ($projects as $project)
                    <div class="pf-mobile-card-item">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-light text-dark border">#{{ $project->sort_order }}</span>
                            <div class="d-inline-flex gap-1 align-items-center">
                                <form action="{{ route('admin.projects.toggle-publish', $project) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to {{ $project->is_published ? 'hide' : 'publish' }}">
                                        @if ($project->is_published)
                                            <x-badge variant="success"><i class="bi bi-check-circle me-1"></i>Published</x-badge>
                                        @else
                                            <x-badge variant="secondary"><i class="bi bi-eye-slash me-1"></i>Hidden</x-badge>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.projects.toggle-featured', $project) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to {{ $project->is_featured ? 'unfeature' : 'feature' }}">
                                        @if ($project->is_featured)
                                            <x-badge variant="primary"><i class="bi bi-star-fill me-1"></i>Featured</x-badge>
                                        @else
                                            <span class="badge border text-muted" style="font-size: 0.75rem;"><i class="bi bi-star me-1"></i>Regular</span>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="fw-semibold mb-1" style="font-size: 0.95rem;">
                            {{ $project->title }}
                        </div>

                        @if($project->summary)
                            <p class="small text-muted mb-2 text-truncate">
                                {{ $project->summary }}
                            </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-end gap-2 pt-1">
                            @if($project->is_published)
                                <a href="{{ route('projects.show', $project) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1" title="View live">
                                    <i class="bi bi-eye me-1"></i> Live
                                </a>
                            @endif
                            <x-button variant="outline-primary" size="sm" class="py-1" :href="route('admin.projects.edit', $project)">
                                Edit
                            </x-button>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this case study?');">
                                @csrf
                                @method('DELETE')
                                <x-button variant="outline-danger" size="sm" class="py-1" type="submit">Delete</x-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Desktop Table View (>= 768px) --}}
            <div class="d-none d-md-block">
                <x-table>
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 64px;">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Status &amp; Visibility</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->sort_order }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $project->title }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 420px;">{{ $project->summary }}</div>
                                </td>
                                <td>
                                    <div class="d-inline-flex gap-1 align-items-center">
                                        <form action="{{ route('admin.projects.toggle-publish', $project) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to {{ $project->is_published ? 'hide' : 'publish' }}">
                                                @if ($project->is_published)
                                                    <x-badge variant="success"><i class="bi bi-check-circle me-1"></i>Published</x-badge>
                                                @else
                                                    <x-badge variant="secondary"><i class="bi bi-eye-slash me-1"></i>Hidden</x-badge>
                                                @endif
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.projects.toggle-featured', $project) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to {{ $project->is_featured ? 'unfeature' : 'feature' }}">
                                                @if ($project->is_featured)
                                                    <x-badge variant="primary"><i class="bi bi-star-fill me-1"></i>Featured</x-badge>
                                                @else
                                                    <span class="badge border text-muted" style="font-size: 0.75rem;"><i class="bi bi-star me-1"></i>Regular</span>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @if($project->is_published)
                                        <a href="{{ route('projects.show', $project) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View live">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif
                                    <x-button variant="outline-primary" size="sm" :href="route('admin.projects.edit', $project)">
                                        Edit
                                    </x-button>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this case study?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="outline-danger" size="sm" type="submit">Delete</x-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>

            <x-pagination :paginator="$projects" />
        @endif
    </x-card>
@endsection
