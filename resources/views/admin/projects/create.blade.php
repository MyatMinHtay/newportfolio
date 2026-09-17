@extends('layouts.admin')

@section('title', 'New case study')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Case Studies', 'url' => route('admin.projects.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="New case study"
        subtitle="Homepage card plus Markdown body for a later public write-up."
    />

    <x-card class="shadow-sm">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.projects._form', ['project' => null])
        </form>
    </x-card>
@endsection
