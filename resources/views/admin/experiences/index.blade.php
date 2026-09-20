@extends('layouts.admin')

@section('title', 'Experience & Timeline')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Experience'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Experience &amp; Career"
        subtitle="Roles and milestones displayed in the public timeline."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.experiences.create')">
                <i class="bi bi-plus-lg me-1"></i> New experience
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm overflow-hidden">
        @if ($experiences->isEmpty())
            <x-empty-state
                icon="bi-clock-history"
                title="No experiences yet"
                description="Add your work history, freelance milestones, or education."
                action-label="New experience"
                :action-url="route('admin.experiences.create')"
            />
        @else
            {{-- Mobile List View (< 768px) --}}
            <div class="d-md-none">
                @foreach ($experiences as $exp)
                    <div class="pf-mobile-card-item">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="small text-primary fw-semibold">{{ $exp->company }}</span>
                            @if ($exp->is_published)
                                <x-badge variant="success">Published</x-badge>
                            @else
                                <x-badge variant="secondary">Hidden</x-badge>
                            @endif
                        </div>

                        <div class="fw-bold mb-1" style="font-size: 0.95rem; color: var(--pf-text);">
                            {{ $exp->role }}
                        </div>

                        <div class="small text-muted mb-2 d-flex flex-wrap gap-2">
                            <span>
                                <i class="bi bi-calendar3 me-1"></i>
                                @if ($exp->start_date)
                                    {{ $exp->start_date->format('M Y') }} — {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                                @else
                                    —
                                @endif
                            </span>
                            @if($exp->location)
                                <span>&bull; <i class="bi bi-geo-alt me-1"></i>{{ $exp->location }}</span>
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-1">
                            <span class="badge bg-light text-dark border">Order: {{ $exp->sort_order }}</span>
                            <div class="d-flex gap-2">
                                <x-button variant="outline-primary" size="sm" class="py-1" :href="route('admin.experiences.edit', $exp)">
                                    Edit
                                </x-button>
                                <form action="{{ route('admin.experiences.destroy', $exp) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this experience?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1">Delete</button>
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
                            <th scope="col">Role &amp; Company</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Location</th>
                            <th scope="col" style="width: 90px;">Order</th>
                            <th scope="col" style="width: 110px;">Status</th>
                            <th scope="col" class="text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($experiences as $exp)
                            <tr>
                                <td>
                                    <div class="fw-semibold" style="color: var(--pf-text);">{{ $exp->role }}</div>
                                    <div class="small text-primary fw-medium">{{ $exp->company }}</div>
                                </td>
                                <td class="small text-muted">
                                    @if ($exp->start_date)
                                        {{ $exp->start_date->format('M Y') }} — {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Present' }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $exp->location ?? '—' }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $exp->sort_order }}</span>
                                </td>
                                <td>
                                    @if ($exp->is_published)
                                        <x-badge variant="success">Published</x-badge>
                                    @else
                                        <x-badge variant="secondary">Hidden</x-badge>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <x-button variant="outline-primary" size="sm" :href="route('admin.experiences.edit', $exp)">
                                        Edit
                                    </x-button>
                                    <form action="{{ route('admin.experiences.destroy', $exp) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this experience?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>

            <div class="p-3 border-top">
                <x-pagination :paginator="$experiences" />
            </div>
        @endif
    </x-card>
@endsection
