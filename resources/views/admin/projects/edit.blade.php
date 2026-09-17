@extends('layouts.admin')

@section('title', 'Edit case study')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Case Studies', 'url' => route('admin.projects.index')],
        ['label' => $project->title],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Edit case study"
        subtitle="{{ $project->title }}"
    />

    <x-card class="shadow-sm">
        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.projects._form', ['project' => $project])
        </form>
    </x-card>
@endsection
