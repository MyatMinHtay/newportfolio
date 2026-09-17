@extends('layouts.admin')

@section('title', 'New service')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Services', 'url' => route('admin.services.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header title="New service" subtitle="Shown in the homepage services section when published." />

    <x-card class="shadow-sm">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            @include('admin.services._form', ['service' => null])
        </form>
    </x-card>
@endsection
