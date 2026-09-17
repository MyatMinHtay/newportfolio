@extends('layouts.public')

@section('title', 'Home')

@section('content')
    <h1 class="h3 mb-2">Public shell</h1>
    <p class="text-muted mb-3">Phase 0b UI foundation — header, nav, and footer only.</p>
    <x-button variant="outline-secondary" href="{{ route('ui-preview') }}">Open UI Preview</x-button>
@endsection
