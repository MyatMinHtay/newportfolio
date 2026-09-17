@extends('layouts.public')

@section('title', 'Service unavailable')

@section('content')
    @include('errors.partials.panel', [
        'code' => 503,
        'title' => 'Service unavailable',
        'message' => 'The site is temporarily unavailable for maintenance. Please check back soon.',
    ])
@endsection
