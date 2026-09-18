@extends('layouts.admin')

@section('title', 'Edit Social Link')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Social Links', 'url' => route('admin.social-links.index')],
        ['label' => $socialLink->label],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Edit social link"
        :subtitle="$socialLink->label"
    />

    <x-card class="shadow-sm" style="max-width: 640px;">
        <form action="{{ route('admin.social-links.update', $socialLink) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.social_links._form', ['socialLink' => $socialLink])
        </form>
    </x-card>
@endsection
