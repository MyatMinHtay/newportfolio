@extends('layouts.public')

@section('title', 'Forbidden')

@section('content')
    @include('errors.partials.panel', [
        'code' => 403,
        'title' => 'Forbidden',
        'message' => 'You do not have permission to view this page.',
    ])
@endsection
