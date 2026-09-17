@extends('layouts.public')

@section('title', 'Page expired')

@section('content')
    @include('errors.partials.panel', [
        'code' => 419,
        'title' => 'Page expired',
        'message' => 'Your session expired or the form was stale. Go back and try again.',
    ])
@endsection
