@extends('layouts.admin')

@section('title', 'New Social Link')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Social Links', 'url' => route('admin.social-links.index')],
        ['label' => 'New'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="New social link"
        subtitle="Connect a profile to the public footer and contact sections."
    />

    <x-card class="shadow-sm" style="max-width: 640px;">
        <form action="{{ route('admin.social-links.store') }}" method="POST">
            @csrf
            @include('admin.social_links._form', ['socialLink' => null])
        </form>
    </x-card>
@endsection
