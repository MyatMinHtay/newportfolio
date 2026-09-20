@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Blog Posts'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Blog Posts"
        subtitle="Manage technical articles, tutorials, and developer notes."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.posts.create')">
                <i class="bi bi-plus-lg me-1"></i> New post
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    {{-- Status Filter Tabs --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-sm {{ empty($status) ? 'btn-primary' : 'btn-outline-secondary' }}">
            All ({{ $counts['all'] ?? $posts->total() }})
        </a>
        <a href="{{ route('admin.posts.index', ['status' => 'published']) }}" class="btn btn-sm {{ ($status ?? '') === 'published' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Published ({{ $counts['published'] ?? 0 }})
        </a>
        <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="btn btn-sm {{ ($status ?? '') === 'draft' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Drafts ({{ $counts['draft'] ?? 0 }})
        </a>
    </div>

    <x-card class="shadow-sm overflow-hidden">
        @if ($posts->isEmpty())
            <x-empty-state
                icon="bi-journal-text"
                title="No blog posts found"
                description="{{ !empty($status) ? 'No blog posts match the selected status filter.' : 'Share your insights, code tutorials, and software architecture articles.' }}"
                action-label="{{ !empty($status) ? 'Clear filter' : 'New post' }}"
                :action-url="!empty($status) ? route('admin.posts.index') : route('admin.posts.create')"
            />
        @else
            {{-- Mobile List View (< 768px) --}}
            <div class="d-md-none">
                @foreach ($posts as $post)
                    <div class="pf-mobile-card-item">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                                @if($post->category)
                                    <span class="badge bg-light text-dark border me-1">{{ $post->category->name }}</span>
                                @endif
                                <span class="small text-muted">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                            </div>

                            <form action="{{ route('admin.posts.toggle-publish', $post) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to {{ $post->is_published ? 'unpublish' : 'publish' }}">
                                    @if ($post->is_published)
                                        <x-badge variant="success"><i class="bi bi-check-circle me-1"></i>Published</x-badge>
                                    @else
                                        <x-badge variant="secondary"><i class="bi bi-pencil me-1"></i>Draft</x-badge>
                                    @endif
                                </button>
                            </form>
                        </div>

                        <div class="fw-semibold mb-1" style="font-size: 0.95rem;">
                            {{ $post->title }}
                        </div>

                        @if($post->excerpt || $post->body)
                            <p class="small text-muted mb-2 text-truncate">
                                {{ $post->excerpt ?: Str::limit($post->body, 90) }}
                            </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-end gap-2 pt-1">
                            @if($post->is_published)
                                <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1" title="View live">
                                    <i class="bi bi-eye me-1"></i> Live
                                </a>
                            @endif
                            <x-button variant="outline-primary" size="sm" class="py-1" :href="route('admin.posts.edit', $post)">
                                Edit
                            </x-button>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-1">Delete</button>
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
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Published Date</th>
                            <th scope="col" style="width: 130px;">Status</th>
                            <th scope="col" class="text-end" style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $post->title }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 420px;">
                                        {{ $post->excerpt ?: Str::limit($post->body, 90) }}
                                    </div>
                                </td>
                                <td>
                                    @if($post->category)
                                        <span class="badge bg-light text-dark border">{{ $post->category->name }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.posts.toggle-publish', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to {{ $post->is_published ? 'unpublish' : 'publish' }}">
                                            @if ($post->is_published)
                                                <x-badge variant="success"><i class="bi bi-check-circle me-1"></i>Published</x-badge>
                                            @else
                                                <x-badge variant="secondary"><i class="bi bi-pencil me-1"></i>Draft</x-badge>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    @if($post->is_published)
                                        <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View live">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif

                                    <x-button variant="outline-primary" size="sm" :href="route('admin.posts.edit', $post)">
                                        Edit
                                    </x-button>

                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post?');">
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
                <x-pagination :paginator="$posts" />
            </div>
        @endif
    </x-card>
@endsection
