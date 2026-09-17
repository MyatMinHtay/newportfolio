@extends('layouts.admin')

@section('title', 'Services')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Admin', 'url' => route('admin.home')], ['label' => 'Services']]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Services"
        subtitle="Offerings shown on the public homepage."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.services.create')">
                <i class="bi bi-plus-lg me-1"></i> New service
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm">
        @if ($services->isEmpty())
            <x-empty-state
                icon="bi-briefcase"
                title="No services yet"
                description="Add what clients can hire you for."
                action-label="New service"
                :action-url="route('admin.services.create')"
            />
        @else
            <x-table>
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 48px;"></th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td><i class="bi {{ $service->iconClass() }}" aria-hidden="true"></i></td>
                            <td>
                                <div class="fw-semibold">{{ $service->title }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 420px;">{{ $service->summary }}</div>
                            </td>
                            <td>
                                @if ($service->is_published)
                                    <x-badge variant="success">Published</x-badge>
                                @else
                                    <x-badge variant="secondary">Hidden</x-badge>
                                @endif
                            </td>
                            <td class="text-end">
                                <x-button variant="outline-primary" size="sm" :href="route('admin.services.edit', $service)">
                                    Edit
                                </x-button>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="outline-danger" size="sm" type="submit">Delete</x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>

            <x-pagination :paginator="$services" />
        @endif
    </x-card>
@endsection
