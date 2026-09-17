@extends('layouts.admin')

@section('title', 'Admin shell')

@section('breadcrumb')
    <x-breadcrumb :items="[['label' => 'Admin'], ['label' => 'Shell']]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Admin shell"
        subtitle="Phase 0b UI foundation — no dashboard or CRUD yet."
    />

    <x-card title="Placeholder">
        <p class="text-muted mb-0">Sidebar, topbar, flash area, breadcrumb, and footer are wired. Content pages come later.</p>
    </x-card>
@endsection
