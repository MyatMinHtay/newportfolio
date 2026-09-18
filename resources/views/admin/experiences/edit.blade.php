@extends('layouts.admin')

@section('title', 'Edit Experience')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Experience', 'url' => route('admin.experiences.index')],
        ['label' => $experience->role . ' at ' . $experience->company],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Edit experience"
        :subtitle="$experience->role . ' at ' . $experience->company"
    />

    <x-card class="shadow-sm" style="max-width: 760px;">
        <form action="{{ route('admin.experiences.update', $experience) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.experiences._form', ['experience' => $experience])
        </form>
    </x-card>
@endsection
