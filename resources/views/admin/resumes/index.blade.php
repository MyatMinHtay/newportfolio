@extends('layouts.admin')

@section('title', 'Resumes & CV')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Resumes'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Resumes &amp; CV"
        subtitle="Upload and manage PDF resumes. The active resume is linked to the homepage download button."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.resumes.create')">
                <i class="bi bi-upload me-1"></i> Upload resume
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm">
        @if ($resumes->isEmpty())
            <x-empty-state
                icon="bi-file-earmark-pdf"
                title="No resumes uploaded"
                description="Upload a PDF CV so prospective clients can download it."
                action-label="Upload resume"
                :action-url="route('admin.resumes.create')"
            />
        @else
            <x-table>
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 48px;"></th>
                        <th scope="col">Title</th>
                        <th scope="col">Uploaded</th>
                        <th scope="col" style="width: 140px;">Status</th>
                        <th scope="col" class="text-end" style="width: 240px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumes as $resume)
                        <tr>
                            <td class="text-center">
                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 1.5rem;"></i>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $resume->title }}</div>
                                <div class="small">
                                    <a href="{{ $resume->file_url }}" target="_blank" class="text-muted text-decoration-none">
                                        <i class="bi bi-download me-1"></i> Download PDF
                                    </a>
                                </div>
                            </td>
                            <td class="small text-muted">
                                {{ $resume->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                @if ($resume->is_active)
                                    <x-badge variant="success">Active on Site</x-badge>
                                @else
                                    <x-badge variant="secondary">Archived</x-badge>
                                @endif
                            </td>
                            <td class="text-end">
                                @if (!$resume->is_active)
                                    <form action="{{ route('admin.resumes.activate', $resume) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success me-1">
                                            <i class="bi bi-check-circle me-1"></i> Activate
                                        </button>
                                    </form>
                                @endif

                                <x-button variant="outline-primary" size="sm" :href="route('admin.resumes.edit', $resume)">
                                    Edit
                                </x-button>

                                <form action="{{ route('admin.resumes.destroy', $resume) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this resume file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>

            <div class="p-3 border-top">
                <x-pagination :paginator="$resumes" />
            </div>
        @endif
    </x-card>
@endsection
