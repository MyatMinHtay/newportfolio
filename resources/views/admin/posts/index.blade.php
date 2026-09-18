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

    <x-card class="shadow-sm">
        @if ($posts->isEmpty())
            <x-empty-state
                icon="bi-journal-text"
                title="No blog posts yet"
                description="Share your insights, code tutorials, and software architecture articles."
                action-label="New post"
                :action-url="route('admin.posts.create')"
            />
        @else
            <x-table>
                <thead class="table-light">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Published</th>
                        <th scope="col" style="width: 110px;">Status</th>
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
                                @if ($post->is_published)
                                    <x-badge variant="success">Published</x-badge>
                                @else
                                    <x-badge variant="secondary">Draft</x-badge>
                                @endif
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

            <div class="p-3 border-top">
                <x-pagination :paginator="$posts" />
            </div>
        @endif
    </x-card>
@endsection
