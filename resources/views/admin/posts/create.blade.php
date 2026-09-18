@extends('layouts.admin')

@section('title', 'New Blog Post')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Blog Posts', 'url' => route('admin.posts.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="New blog post"
        subtitle="Write an article, tutorial, or developer note in Markdown."
    />

    <x-card class="shadow-sm" style="max-width: 860px;">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.posts._form', ['post' => null])
        </form>
    </x-card>
@endsection
