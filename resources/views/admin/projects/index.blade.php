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

    <x-card class="shadow-sm">
        @if ($projects->isEmpty())
            <x-empty-state
                icon="bi-folder"
                title="No case studies yet"
                description="Add a project to publish it on the homepage."
                action-label="New case study"
                :action-url="route('admin.projects.create')"
            />
        @else
            <x-table>
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 64px;">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
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

            <x-pagination :paginator="$projects" />
        @endif
    </x-card>
@endsection
