@extends('layouts.public')

@section('title', 'Unauthorized')

@section('content')
    @include('errors.partials.panel', [
        'code' => 401,
        'title' => 'Unauthorized',
        'message' => 'You need to sign in to access this page.',
    ])
@endsection
