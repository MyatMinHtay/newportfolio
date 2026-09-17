@extends('layouts.admin')

@section('title', 'New skill')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Skills', 'url' => route('admin.skills.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header title="New skill" subtitle="Upload an icon now, or keep the bundled fallback." />

    <x-card class="shadow-sm">
        <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.skills._form', ['skill' => null])
        </form>
    </x-card>
@endsection
