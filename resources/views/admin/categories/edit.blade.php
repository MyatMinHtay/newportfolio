@extends('layouts.admin')

@section('title', 'Edit Category')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Categories', 'url' => route('admin.categories.index')],
        ['label' => $category->name],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Edit category"
        :subtitle="$category->name"
    />

    <x-card class="shadow-sm" style="max-width: 600px;">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.categories._form', ['category' => $category])
        </form>
    </x-card>
@endsection
