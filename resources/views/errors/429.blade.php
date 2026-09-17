@extends('layouts.public')

@section('title', 'Too many requests')

@section('content')
    @include('errors.partials.panel', [
        'code' => 429,
        'title' => 'Too many requests',
        'message' => 'You have made too many requests. Please wait a moment and try again.',
    ])
@endsection
