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

    <x-card class="shadow-sm overflow-hidden">
        @if ($skills->isEmpty())
            <x-empty-state
                icon="bi-stars"
                title="No skills yet"
                description="Add a skill with an optional icon."
                action-label="New skill"
                :action-url="route('admin.skills.create')"
            />
        @else
            {{-- Mobile List View (< 768px) --}}
            <div class="d-md-none">
                @foreach ($skills as $skill)
                    <div class="pf-mobile-card-item d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3 text-truncate">
                            <img src="{{ $skill->icon_url }}" alt="" width="36" height="36" class="rounded flex-shrink-0" style="object-fit: contain;">
                            <div class="text-truncate">
                                <div class="fw-semibold text-truncate">{{ $skill->name }}</div>
                                <div class="small text-muted d-flex align-items-center gap-1">
                                    <span>{{ $skill->category }}</span>
                                    @if($skill->proficiency)
                                        <span>&bull; {{ $skill->proficiency }}/5</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                            @if ($skill->is_published)
                                <x-badge variant="success">Live</x-badge>
                            @else
                                <x-badge variant="secondary">Hidden</x-badge>
                            @endif
                            <div class="d-flex gap-1">
                                <x-button variant="outline-primary" size="sm" class="py-0 px-2" :href="route('admin.skills.edit', $skill)">
                                    Edit
                                </x-button>
                                <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this skill?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Desktop Table View (>= 768px) --}}
            <div class="d-none d-md-block">
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
            </div>

            <x-pagination :paginator="$skills" />
        @endif
    </x-card>
@endsection
