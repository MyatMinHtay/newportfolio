@extends('layouts.admin')

@section('title', 'Skills')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Admin', 'url' => route('admin.home')], ['label' => 'Skills']]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Skills"
        subtitle="Icons can be uploaded on create. Bundled icons are used when no file is set."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.skills.create')">
                <i class="bi bi-plus-lg me-1"></i> New skill
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm">
        @if ($skills->isEmpty())
            <x-empty-state
                icon="bi-stars"
                title="No skills yet"
                description="Add a skill with an optional icon."
                action-label="New skill"
                :action-url="route('admin.skills.create')"
            />
        @else
            <x-table>
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 56px;"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Level</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skills as $skill)
                        <tr>
                            <td>
                                <img src="{{ $skill->icon_url }}" alt="" width="32" height="32" class="rounded" style="object-fit: contain;">
                            </td>
                            <td class="fw-semibold">{{ $skill->name }}</td>
                            <td>{{ $skill->category }}</td>
                            <td>{{ $skill->proficiency ? $skill->proficiency.'/5' : '—' }}</td>
                            <td>
                                @if ($skill->is_published)
                                    <x-badge variant="success">Published</x-badge>
                                @else
                                    <x-badge variant="secondary">Hidden</x-badge>
                                @endif
                            </td>
                            <td class="text-end">
                                <x-button variant="outline-primary" size="sm" :href="route('admin.skills.edit', $skill)">
                                    Edit
                                </x-button>
                                <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this skill?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="outline-danger" size="sm" type="submit">Delete</x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>

            <x-pagination :paginator="$skills" />
        @endif
    </x-card>
@endsection
