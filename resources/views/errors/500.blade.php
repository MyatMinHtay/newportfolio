@extends('layouts.public')

@section('title', 'Server error')

@section('content')
    @include('errors.partials.panel', [
        'code' => 500,
        'title' => 'Something went wrong',
        'message' => 'An unexpected error occurred. Please try again later.',
    ])
@endsection
