@extends('layouts.admin')

@section('title', 'Social Links')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Social Links'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Social Links"
        subtitle="Manage external profiles displayed on the public website."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.social-links.create')">
                <i class="bi bi-plus-lg me-1"></i> New social link
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm overflow-hidden">
        @if ($socialLinks->isEmpty())
            <x-empty-state
                icon="bi-share"
                title="No social links yet"
                description="Add links to GitHub, LinkedIn, Telegram, etc."
                action-label="New social link"
                :action-url="route('admin.social-links.create')"
            />
        @else
            {{-- Mobile List View (< 768px) --}}
            <div class="d-md-none">
                @foreach ($socialLinks as $link)
                    <div class="pf-mobile-card-item d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3 text-truncate">
                            <i class="bi {{ $link->icon }} fs-4 text-primary flex-shrink-0"></i>
                            <div class="text-truncate">
                                <div class="fw-semibold text-truncate">{{ $link->label }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 180px;">
                                    {{ $link->url }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                            @if ($link->is_published)
                                <x-badge variant="success">Visible</x-badge>
                            @else
                                <x-badge variant="secondary">Hidden</x-badge>
                            @endif
                            <div class="d-flex gap-1">
                                <x-button variant="outline-primary" size="sm" class="py-0 px-2" :href="route('admin.social-links.edit', $link)">
                                    Edit
                                </x-button>
                                <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this social link?');">
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
                            <th scope="col" style="width: 48px;"></th>
                            <th scope="col">Platform</th>
                            <th scope="col">Destination URL</th>
                            <th scope="col" style="width: 100px;">Order</th>
                            <th scope="col" style="width: 110px;">Status</th>
                            <th scope="col" class="text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socialLinks as $link)
                            <tr>
                                <td class="text-center">
                                    <i class="bi {{ $link->icon }}" style="font-size: 1.25rem;"></i>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $link->label }}</span>
                                </td>
                                <td>
                                    <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="text-truncate d-inline-block text-muted small" style="max-width: 320px;">
                                        {{ $link->url }} <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.75rem;"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $link->sort_order }}</span>
                                </td>
                                <td>
                                    @if ($link->is_published)
                                        <x-badge variant="success">Visible</x-badge>
                                    @else
                                        <x-badge variant="secondary">Hidden</x-badge>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <x-button variant="outline-primary" size="sm" :href="route('admin.social-links.edit', $link)">
                                        Edit
                                    </x-button>
                                    <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this social link?');">
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
                <x-pagination :paginator="$socialLinks" />
            </div>
        @endif
    </x-card>
@endsection
