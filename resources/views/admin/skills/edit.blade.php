@extends('layouts.admin')

@section('title', 'Edit skill')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Skills', 'url' => route('admin.skills.index')],
        ['label' => $skill->name],
    ]" />
@endsection

@section('content')
    <x-layout.page-header title="Edit skill" :subtitle="$skill->name" />

    <x-card class="shadow-sm">
        <form action="{{ route('admin.skills.update', $skill) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.skills._form', ['skill' => $skill])
        </form>
    </x-card>
@endsection
