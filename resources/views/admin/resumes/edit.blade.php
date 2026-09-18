@extends('layouts.admin')

@section('title', 'Edit Resume')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Resumes', 'url' => route('admin.resumes.index')],
        ['label' => $resume->title],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Edit resume"
        :subtitle="$resume->title"
    />

    <x-card class="shadow-sm" style="max-width: 640px;">
        <form action="{{ route('admin.resumes.update', $resume) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.resumes._form', ['resume' => $resume])
        </form>
    </x-card>
@endsection
