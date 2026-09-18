@extends('layouts.admin')

@section('title', 'New Experience')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Experience', 'url' => route('admin.experiences.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="New experience"
        subtitle="Add a role, employment milestone, or freelance period to your career timeline."
    />

    <x-card class="shadow-sm" style="max-width: 760px;">
        <form action="{{ route('admin.experiences.store') }}" method="POST">
            @csrf
            @include('admin.experiences._form', ['experience' => null])
        </form>
    </x-card>
@endsection
