@extends('layouts.admin')

@section('title', 'Edit service')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Services', 'url' => route('admin.services.index')],
        ['label' => $service->title],
    ]" />
@endsection

@section('content')
    <x-layout.page-header title="Edit service" :subtitle="$service->title" />

    <x-card class="shadow-sm">
        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.services._form', ['service' => $service])
        </form>
    </x-card>
@endsection
