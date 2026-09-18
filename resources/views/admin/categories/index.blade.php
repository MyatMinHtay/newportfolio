@extends('layouts.admin')

@section('title', 'Categories')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Categories'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Categories"
        subtitle="Manage blog post and tutorial categories."
    >
        <x-slot:actions>
            <x-button variant="primary" :href="route('admin.categories.create')">
                <i class="bi bi-plus-lg me-1"></i> New category
            </x-button>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm">
        @if ($categories->isEmpty())
            <x-empty-state
                icon="bi-tags"
                title="No categories yet"
                description="Add categories to organize your blog posts."
                action-label="New category"
                :action-url="route('admin.categories.create')"
            />
        @else
            <x-table>
                <thead class="table-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col" style="width: 120px;">Posts</th>
                        <th scope="col" class="text-end" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $category->name }}</span>
                            </td>
                            <td>
                                <code class="text-muted">{{ $category->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $category->blog_posts_count }}</span>
                            </td>
                            <td class="text-end">
                                <x-button variant="outline-primary" size="sm" :href="route('admin.categories.edit', $category)">
                                    Edit
                                </x-button>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
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
                <x-pagination :paginator="$categories" />
            </div>
        @endif
    </x-card>
@endsection
