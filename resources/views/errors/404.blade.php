@extends('layouts.public')

@section('title', 'Page not found')

@section('content')
    @include('errors.partials.panel', [
        'code' => 404,
        'title' => 'Page not found',
        'message' => 'The page you requested does not exist or has been moved.',
    ])
@endsection
