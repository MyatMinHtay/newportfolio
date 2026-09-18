@extends('layouts.admin')

@section('title', 'Upload Resume')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Resumes', 'url' => route('admin.resumes.index')],
        ['label' => 'Upload'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Upload resume"
        subtitle="Upload a PDF resume for visitors to download from your portfolio."
    />

    <x-card class="shadow-sm" style="max-width: 640px;">
        <form action="{{ route('admin.resumes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.resumes._form', ['resume' => null])
        </form>
    </x-card>
@endsection
