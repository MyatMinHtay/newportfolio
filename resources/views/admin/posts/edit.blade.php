@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Blog Posts', 'url' => route('admin.posts.index')],
        ['label' => $post->title],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Edit blog post"
        :subtitle="$post->title"
    >
        @if($post->is_published)
            <x-slot:actions>
                <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View live
                </a>
            </x-slot:actions>
        @endif
    </x-layout.page-header>

    <x-card class="shadow-sm" style="max-width: 860px;">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.posts._form', ['post' => $post])
        </form>
    </x-card>
@endsection
