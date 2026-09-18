@extends('layouts.admin')

@section('title', 'New Category')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Categories', 'url' => route('admin.categories.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="New category"
        subtitle="Organize technical articles and tutorials."
    />

    <x-card class="shadow-sm" style="max-width: 600px;">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            @include('admin.categories._form', ['category' => null])
        </form>
    </x-card>
@endsection
